<?php

namespace App\Http\Service\Backstage;

use Illuminate\Support\Facades\Hash;
use App\Constants\BackstageConstant;
use Illuminate\Support\Facades\Cache;
use App\Cascade\Models\Admin\RoleModel;
use Illuminate\Support\Facades\Request;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace;
use Handyfit\Framework\Support\Facades\Preacher;
use Handyfit\Framework\Preacher\PreacherResponse;
use App\Cascade\Trace\Eloquent\Admin\AbilityTrace;
use App\Cascade\Models\Admin\InfoModel as AdminInfoModel;
use App\Cascade\Trace\Eloquent\Admin\InfoTrace as AdminInfoTrace;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace as AdminRoleTrace;

/**
 * 管理员业务类
 *
 * @author KanekiYuto
 */
class AdminService
{

    /**
     * 获取用户信息
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public static function user(Request $request): PreacherResponse
    {
        $user = $request::user(BackstageConstant::GUARD);

        if (!($user instanceof AdminInfoModel)) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_FAIL,
                '系统异常'
            );
        }

        return Preacher::model($user);
    }

    /**
     * 创建令牌凭证
     *
     * @param  AdminInfoModel  $model
     *
     * @return PreacherResponse
     */
    public static function createToken(AdminInfoModel $model): PreacherResponse
    {
        // 删除过去签发的所有令牌
        $model->tokens()->delete();

        $createToken = $model->createToken(
            $model->getAttributeValue(AdminInfoTrace::ID)
        );

        $token = $createToken->token;

        return Preacher::receipt((object) [
            'tokenId' => $token->toArray()['id'],
            'accessToken' => $createToken->accessToken,
        ]);
    }

    /**
     * 获取用户信息
     *
     * @param  AdminInfoModel  $model
     *
     * @return PreacherResponse
     * @todo 需要重构
     *
     */
    public static function info(AdminInfoModel $model): PreacherResponse
    {
        $roleInfo = $model->role();

        $roleModel = RoleModel::query()->find($roleInfo->value(RoleTrace::ID));
        $abilities = $roleModel->abilities()->get([
            AbilityTrace::CLIENT_ROUTING,
            AbilityTrace::OPERATION,
            AbilityTrace::TYPE,
        ]);

        $permissions = [];

        foreach ($abilities as $ability) {
            if (!empty($ability[AbilityTrace::CLIENT_ROUTING])) {
                $permissions[] = "@route:{$ability[AbilityTrace::CLIENT_ROUTING]}";
            }

            if (!empty($ability[AbilityTrace::OPERATION])) {
                foreach ($ability[AbilityTrace::OPERATION] as $key => $val) {
                    $permissions[] = "@$val:$key";
                }
            }
        }

        return Preacher::receipt((object) [
            'id' => $model[AdminInfoTrace::ID],
            'account' => $model[AdminInfoTrace::ACCOUNT],
            'email' => $model[AdminInfoTrace::EMAIL],
            'role' => $roleInfo->value(AdminRoleTrace::NAME),
            'permissions' => $permissions,
        ]);
    }

    /**
     * 修改管理员账号信息
     *
     * @param  int     $id
     * @param  string  $account
     *
     * @return PreacherResponse
     */
    public static function account(int $id, string $account): PreacherResponse
    {
        $user = AdminInfoModel::query()
            ->where(AdminInfoTrace::ACCOUNT, $account)
            ->where(AdminInfoTrace::ID, '<>', $id);

        if ($user->exists()) {
            return Preacher::code(
                PreacherResponse::RESP_CODE_WARN
            )->setMsg('账号已存在');
        }

        $user = AdminInfoModel::query()->find($id, [
            AdminInfoTrace::ID,
            AdminInfoTrace::ACCOUNT,
        ]);

        $column = AdminInfoTrace::ACCOUNT;
        $user->$column = $account;

        return Preacher::allow(
            $user->save(),
            Preacher::msg('修改成功'),
            Preacher::msgCode(PreacherResponse::RESP_CODE_FAIL, '修改失败')
        );
    }

    /**
     * 修改管理员邮箱
     *
     * @param  int     $id
     * @param  int     $code
     * @param  string  $email
     *
     * @return PreacherResponse
     */
    public static function email(
        int $id,
        int $code,
        string $email
    ): PreacherResponse {
        $theCode = Cache::get('backstage-admin-modify-email');
        if (empty($theCode)) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_WARN,
                '验证码已过期',
            );
        }

        if ($code === $theCode) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_WARN,
                '验证码无效',
            );
        }

        $model = AdminInfoModel::query();
        $model = $model->where(AdminInfoTrace::EMAIL, $email);
        $model = $model->where(AdminInfoTrace::ID, '<>', $id);
        if ($model->exists()) {
            return Preacher::code(
                PreacherResponse::RESP_CODE_WARN
            )->setMsg('邮箱已存在');
        }

        $model = AdminInfoModel::query()->find($id);

        $column = AdminInfoTrace::EMAIL;
        $model->$column = $email;

        return Preacher::allow(
            $model->save(),
            Preacher::msg('修改成功'),
            Preacher::msgCode(PreacherResponse::RESP_CODE_FAIL, '修改失败')
        );
    }

    /**
     * 更改管理员密码
     *
     * @param  int     $id
     * @param  string  $pass
     *
     * @return PreacherResponse
     */
    public static function pass(int $id, string $pass): PreacherResponse
    {
        $user = AdminInfoModel::query()->find($id);

        $column = AdminInfoTrace::PASS;
        $user->$column = Hash::make($pass);

        return Preacher::allow(
            $user->save(),
            Preacher::msg('修改成功'),
            Preacher::msgCode(PreacherResponse::RESP_CODE_FAIL, '修改失败')
        );
    }

    /**
     * 使用密码鉴权
     *
     * @param  string  $account
     * @param  string  $pass
     *
     * @return PreacherResponse
     */
    public static function auth(string $account, string $pass): PreacherResponse
    {
        $user = AdminInfoModel::query()->where(
            AdminInfoTrace::ACCOUNT,
            $account,
        )->first();

        if (is_null($user)) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_WARN,
                '账号不存在'
            );
        }

        if (!Hash::check($pass, $user->pass)) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_WARN,
                '密码错误'
            );
        }

        return Preacher::model($user);
    }

}
