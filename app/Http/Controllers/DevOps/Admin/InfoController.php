<?php

namespace App\Http\Controllers\DevOps\Admin;

use App\Cascade\Summaries\Admin\InfoSummary as TheSummary;
use App\Http\Service\DevOps\Admin\InfoService;
use Handyfit\Framework\Preacher\PreacherResponse;
use Handyfit\Framework\Support\Facades\Preacher;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rules\Password;
use Kaneki\Diverse\PagingQuery\PagingQuery;

/**
 * 管理员信息控制器
 *
 * @author KanekiYuto
 */
class InfoController
{

    /**
     * 容器
     *
     * @var InfoService
     */
    private InfoService $service;

    /**
     * 构造控制器实例
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = new InfoService;
    }

    /**
     * 獲取選項數據
     *
     * @return PreacherResponse
     */
    public static function select(): PreacherResponse
    {
        return InfoService::select();
    }

    /**
     * 分頁查詢獲取管理員信息
     *
     * @param Request $request
     *
     * @return PreacherResponse
     */
    public function paging(Request $request): PreacherResponse
    {
        return PagingQuery::request(
            request: $request,
            class: InfoService::class,
            orderBy: [
                TheSummary::ID,
                TheSummary::ACCOUNT,
                TheSummary::EMAIL,
                TheSummary::UPDATED_AT,
                TheSummary::CREATED_AT,
            ],
            queryRule: [
                'id' => ['nullable', 'string'],
            ]
        );
    }

    /**
     * 新增管理員信息
     *
     * @param Request $request
     *
     * @return PreacherResponse
     */
    public function append(Request $request): PreacherResponse
    {
        $requestParams = $request::validate([
            'account' => ['required', 'string'],
            'email' => ['required', 'string', 'email:rfc,dns'],
            'pass' => [
                'required',
                'string',
                // 必须八位以上且带至少一个数字且至少包含一个字母
                Password::min(8)->numbers()->letters(),
            ],
            'role_id' => ['required', 'integer'],
        ]);

        return InfoService::append(
            $requestParams['account'],
            $requestParams['email'],
            $requestParams['pass'],
            $requestParams['role_id'],
        );
    }

    /**
     * 修改管理員信息
     *
     * @param Request $request
     *
     * @return PreacherResponse
     */
    public function modify(Request $request): PreacherResponse
    {
        $requestParams = $request::validate([
            'id' => ['required', 'integer'],
            'account' => ['required', 'string'],
            'email' => ['required', 'string'],
            'role_id' => ['required', 'integer'],
        ]);

        $user = $request::user('sanctum');
        if ((int) $user->id === (int) $requestParams['id']) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_WARN,
                '不允許編輯自身賬號信息'
            );
        }

        return InfoService::modify(
            $requestParams['id'],
            $requestParams['account'],
            $requestParams['email'],
            $requestParams['role_id'],
        );
    }

}
