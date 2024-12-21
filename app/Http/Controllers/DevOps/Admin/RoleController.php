<?php

namespace App\Http\Controllers\DevOps\Admin;

use App\Experimental\Crush\Crush;
use Illuminate\Support\Facades\Request;
use App\Http\Service\DevOps\Admin\RoleService;
use Handyfit\Framework\Preacher\PreacherResponse;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace as TheTrace;

/**
 * 管理员角色控制器
 *
 * @author KanekiYuto
 */
class RoleController
{

    /**
     * 分页查询管理员角色信息
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public function paging(Request $request): PreacherResponse
    {
        return Crush::request(
            request: $request,
            class: RoleService::class,
            orderBy: [
                TheTrace::ID,
                TheTrace::UPDATED_AT,
                TheTrace::CREATED_AT,
            ],
            queryRule: [
                'id' => ['nullable', 'string'],
            ]
        );
    }

    /**
     * 管理员角色选项
     *
     * @return PreacherResponse
     */
    public function select(): PreacherResponse
    {
        return RoleService::select();
    }

    /**
     * 新增管理员角色信息
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public function append(Request $request): PreacherResponse
    {
        $requestParams = $request::validate([
            'name' => ['required', 'string'],
            'explain' => ['nullable', 'string'],
        ]);

        return RoleService::append(
            $requestParams['name'],
            $requestParams['explain']
        );
    }

    /**
     * 修改管理员角色信息
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public function modify(Request $request): PreacherResponse
    {
        $requestParams = $request::validate([
            'id' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'explain' => ['nullable', 'string'],
        ]);

        return RoleService::modify(
            $requestParams['id'],
            $requestParams['name'],
            $requestParams['explain'] ?? ''
        );
    }

    public function delete(Request $request): void
    {
    }

    /**
     * 设置角色能力
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public function ability_old(Request $request): PreacherResponse
    {
        $requestParams = $request::validate([
            'id' => ['required', 'integer'],
            'abilities' => ['array'],
        ]);

        return RoleService::ability(
            $requestParams['id'],
            $requestParams['abilities'],
        );
    }

    /**
     * 获取角色能力信息
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public function ability(Request $request): PreacherResponse
    {
        $requestParams = $request::validate([
            'id' => ['required', 'integer'],
        ]);

        return RoleService::ability($requestParams['id']);
    }

}
