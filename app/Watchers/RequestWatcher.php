<?php

namespace App\Watchers;

use Illuminate\Routing\Route;
use App\Constants\DevOpsConstant;
use App\Cascade\Models\AdminInfoModel;
use App\Cascade\Summaries\AdminInfoSummary;
use Illuminate\Contracts\Foundation\Application;
use App\Cascade\Models\AdminLogModel as AdminLog;
use Illuminate\Foundation\Http\Events\RequestHandled;
use App\Cascade\Summaries\AdminLogSummary as TheSummary;

/**
 * 请求监视器
 *
 * @author KanekiYuto
 */
class RequestWatcher extends Watcher
{

    /**
     * Register the watcher.
     *
     * @param  Application  $app
     *
     * @return void
     */
    public function register(Application $app): void
    {
        $app['events']->listen(RequestHandled::class, [$this, 'recordRequest']);
    }

    /**
     * Record an incoming HTTP request.
     *
     * @param  RequestHandled  $event
     *
     * @return void
     */
    public function recordRequest(RequestHandled $event): void
    {
        $request = $event->request;

        // 仅记录 [POST] 请求
        if ($request->method() !== 'POST') {
            return;
        }

        // 排除非 [Guard] 路由
        $user = $request->user(DevOpsConstant::GUARD);

        if (!($user instanceof AdminInfoModel)) {
            return;
        }

        $userArray = $user->toArray();
        $route = $request->route();

        if (!($route instanceof Route)) {
            return;
        }

        $routeName = $route->getName();

        if (empty($routeName)) {
            return;
        }

        AdminLog::query()->create([
            TheSummary::ADMIN_ID => $userArray[AdminInfoSummary::ID],
            TheSummary::API => $routeName,
            TheSummary::IPADDRESS => $request->ip(),
            TheSummary::PAYLOAD => $request->input(),
            TheSummary::HEADERS => $request->headers->all(),
            TheSummary::RESPONSE => $event->response,
        ])->save();
    }

}
