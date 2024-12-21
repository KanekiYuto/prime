<?php

namespace App\Http\Controllers\DevOps\Admin;

use App\Cascade\Summaries\Admin\RoleSummary as TheSummary;
use App\Experimental\Crush\Crush;
use App\Http\Service\DevOps\Admin\RoleService;
use Handyfit\Framework\Preacher\PreacherResponse;
use Illuminate\Support\Facades\Request;

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
     * @param Request $request
     *
     * @return PreacherResponse
     */
    public function paging(Request $request): PreacherResponse
    {
        return Crush::request(
            request: $request,
            class: RoleService::class,
            orderBy: [
                TheSummary::ID,
                TheSummary::UPDATED_AT,
                TheSummary::CREATED_AT,
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
     * @param Request $request
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
     * @param Request $request
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

    /**
     * 获取角色能力信息
     *
     * @param Request $request
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
