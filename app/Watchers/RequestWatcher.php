<?php

namespace App\Watchers;

use App\Cascade\Models\Admin\InfoModel;
use App\Cascade\Models\Admin\LogModel as AdminLog;
use App\Cascade\Summaries\Admin\InfoSummary;
use App\Cascade\Summaries\Admin\LogSummary as TheSummary;
use App\Constants\DevOpsConstant;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Routing\Route;

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
     * @param Application $app
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
     * @param RequestHandled $event
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

        if (!($user instanceof InfoModel)) {
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
            TheSummary::ADMIN_ID => $userArray[InfoSummary::ID],
            TheSummary::API => $routeName,
            TheSummary::IPADDRESS => $request->ip(),
            TheSummary::PAYLOAD => $request->input(),
            TheSummary::HEADERS => $request->headers->all(),
            TheSummary::RESPONSE => $event->response,
        ])->save();
    }

}
