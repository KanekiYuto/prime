<?php

namespace App\Watchers;

use Illuminate\Routing\Route;
use App\Constants\BackstageConstant;
use App\Cascade\Models\Admin\InfoModel;
use App\Cascade\Trace\Eloquent\Admin\InfoTrace;
use Illuminate\Contracts\Foundation\Application;
use App\Cascade\Models\Admin\LogModel as AdminLog;
use Illuminate\Foundation\Http\Events\RequestHandled;
use App\Cascade\Trace\Eloquent\Admin\LogTrace as TheTrace;

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
        $user = $request->user(BackstageConstant::GUARD);

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
            TheTrace::ADMIN_ID => $userArray[InfoTrace::ID],
            TheTrace::API => $routeName,
            TheTrace::IPADDRESS => $request->ip(),
            TheTrace::PAYLOAD => $request->input(),
            TheTrace::HEADERS => $request->headers->all(),
            TheTrace::RESPONSE => $event->response,
        ])->save();
    }

}
