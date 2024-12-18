<?php

namespace App\Http\Controllers\Backstage;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use App\Http\Service\Backstage\AdminService;
use Handyfit\Framework\Support\Facades\Preacher;
use Handyfit\Framework\Preacher\PreacherResponse;

/**
 * 管理员控制器
 *
 * @author KanekiYuto
 */
class AdminController
{

    /**
     * 管理员登录
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public function login(Request $request): PreacherResponse
    {
        $requestParams = $request::validate([
            'account' => ['required', 'string'],
            'pass' => ['required', 'string'],
        ]);

        $auth = AdminService::auth(
            $requestParams['account'],
            $requestParams['pass']
        );

        if (!($auth->isSucceed())) {
            return $auth;
        }

        $user = $auth->getModel();
        $createToken = AdminService::createToken($user);

        return Preacher::msg(
            '登录成功'
        )->setReceipt($createToken->getReceipt());
    }

    /**
     * 退出登录
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public function logout(Request $request): PreacherResponse
    {
        $user = AdminService::user($request);

        if (!$user->isSucceed()) {
            return $user;
        }

        $user->getModel()->tokens()->delete();

        return Preacher::msg('退出登录成功');
    }

    /**
     * 获取管理员信息
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public function info(Request $request): PreacherResponse
    {
        sleep(1);

        $user = AdminService::user($request);

        if (!$user->isSucceed()) {
            return $user;
        }

        sleep(1);

        $user = $user->getModel();
        $createToken = AdminService::createToken($user);

        return AdminService::info($user)->mergeReceipt((object) [
            'token' => $createToken->getReceipt(),
        ]);
    }

    /**
     * 修改管理员账号信息
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public function account(Request $request): PreacherResponse
    {
        $requestParams = $request::validate([
            'account' => ['required', 'string'],
        ]);

        $user = AdminService::user($request);

        if (!$user->isSucceed()) {
            return $user;
        }

        $user = $user->getModel();

        $account = AdminService::account(
            $user->id,
            $requestParams['account']
        );

        if (!$account->isSucceed()) {
            return $account;
        }

        $createToken = AdminService::createToken($user);

        return $account->setReceipt($createToken->getReceipt());
    }

    /**
     * 修改管理员邮箱
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public function email(Request $request): PreacherResponse
    {
        $requestParams = $request::validate([
            'email' => ['required', 'string'],
            'code' => ['required', 'integer'],
        ]);

        $user = AdminService::user($request);

        if (!$user->isSucceed()) {
            return $user;
        }

        $user = $user->getModel();

        return AdminService::email($user->id, $requestParams['code'], $requestParams['email']);
    }

    /**
     * 更改管理员密码
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public function pass(Request $request): PreacherResponse
    {
        $requestParams = $request::validate([
            'original' => ['required', 'string'],
            'fresh' => ['required', 'string'],
        ]);

        $user = AdminService::user($request);

        if (!$user->isSucceed()) {
            return $user;
        }

        $user = $user->getModel();

        if (!Hash::check($requestParams['original'], $user->pass)) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_WARN,
                '原密码错误'
            );
        }

        $pass = AdminService::pass(
            $user->id,
            $requestParams['fresh']
        );

        $createToken = AdminService::createToken($user);

        return $pass->setReceipt($createToken->getReceipt());
    }

}
