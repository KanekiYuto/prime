<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Constants\BackstageConstant;
use App\Cascade\Models\Admin\InfoModel;
use App\Cascade\Models\Admin\RoleModel;
use Handyfit\Framework\Support\Facades\Preacher;
use Handyfit\Framework\Preacher\PreacherResponse;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace;
use App\Cascade\Trace\Eloquent\Admin\AbilityTrace;

/**
 * 后台能力验证中间件
 *
 * @author KanekiYuto
 */
class BackstageAbility
{

    /**
     * 处理传入的请求
     *
     * @param  Request  $request
     * @param  Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $user = $request->user(BackstageConstant::GUARD);

        if (!($user instanceof InfoModel)) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_FAIL,
                '系统异常'
            );
        }

        $roleInfo = $user->role();
        $roleModel = RoleModel::query()->find($roleInfo->value(RoleTrace::ID));
        $abilities = $roleModel->abilities()->pluck(AbilityTrace::SERVER_ROUTING);

        $abilities = collect($abilities)->reject(function (array $item) {
            return empty($item);
        });

        $useAbilities = [];

        foreach ($abilities as $ability) {
            $useAbilities = array_merge($useAbilities, $ability);
        }

        if (!in_array($request->route()->getName(), $useAbilities)) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_ACCESS_DENIED,
                '无权访问'
            )->export()->json();
        }

        return $next($request);
    }

}
