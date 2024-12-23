<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Constants\DevOpsConstant;
use App\Cascade\Models\AdminRoleModel;
use App\Cascade\Models\AdminInfoModel;
use App\Cascade\Summaries\AdminRoleSummary;
use App\Cascade\Summaries\AdminAbilitySummary;
use Handyfit\Framework\Support\Facades\Preacher;
use Handyfit\Framework\Preacher\PreacherResponse;

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
        $user = $request->user(DevOpsConstant::GUARD);

        if (!($user instanceof AdminInfoModel)) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_FAIL,
                '系统异常'
            );
        }

        $roleInfo = $user->role();
        $roleModel = AdminRoleModel::query()->find($roleInfo->value(AdminRoleSummary::ID));
        $abilities = $roleModel->abilities()->pluck(AdminAbilitySummary::SERVER_ROUTING);

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
