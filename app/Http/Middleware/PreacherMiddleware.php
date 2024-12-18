<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteAction;
use Handyfit\Framework\Preacher\Export;
use Symfony\Component\HttpFoundation\Response;
use Handyfit\Framework\Preacher\PreacherResponse;
use Laravel\SerializableClosure\SerializableClosure;

class PreacherMiddleware
{

    /**
     * 处理传入的请求
     *
     * @param  Request  $request
     * @param  Closure  $next
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route = $request->route();
        $action = $route->getAction();

        $handle = function (mixed $callable, Route $route) {
            if ($callable instanceof PreacherResponse) {
                $route->uses(function () use ($callable) {
                    return $callable->export()->json();
                });
            }

            if ($callable instanceof Export) {
                $route->uses(function () use ($callable) {
                    return $callable->json();
                });
            }

            return false;
        };

        if ($this->isControllerAction($action)) {
            return $this->runController($request, $next, $handle);
        }

        return $this->runCallable($request, $next, $handle);
    }

    protected function isControllerAction(array $action): bool
    {
        return is_string($action['uses']) && !$this->isSerializedClosure($action);
    }

    protected function isSerializedClosure(array $action): bool
    {
        return RouteAction::containsSerializedClosure($action);
    }

    /**
     * 运行控制器方式的路由处理
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  Closure  $handle
     *
     * @return Response
     */
    protected function runController(Request $request, Closure $next, Closure $handle): Response
    {
        $route = $request->route();

        $callable = $route->controllerDispatcher()
            ->dispatch($route, $route->getController(), $route->getActionMethod());

        $handleResult = $handle($callable, $route);

        if ($handleResult !== false) {
            return $handleResult;
        }

        return $next($request);
    }

    /**
     * 运行回调方式的路由处理
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  Closure  $handle
     *
     * @return Response
     */
    protected function runCallable(Request $request, Closure $next, Closure $handle): Response
    {
        $route = $request->route();
        $action = $route->getAction();

        if ($this->isSerializedClosure($action)) {
            $callable = unserialize($action['uses']);

            if ($callable instanceof SerializableClosure) {
                $callable = $callable->getClosure();
            }

            $callable = $callable();

            $handleResult = $handle($callable, $route);

            if ($handleResult !== false) {
                return $handleResult;
            }
        }

        return $next($request);
    }

}
