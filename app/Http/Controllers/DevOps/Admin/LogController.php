<?php

namespace App\Http\Controllers\DevOps\Admin;

use App\Cascade\Summaries\AdminLogSummary;
use App\Http\Service\DevOps\Admin\LogService;
use Handyfit\Framework\Preacher\PreacherResponse;
use Illuminate\Support\Facades\Request;
use Kaneki\Diverse\PagingQuery\PagingQuery;

/**
 * 管理员日志控制器
 *
 * @author KanekiYuto
 */
class LogController
{

    /**
     * 分页查询管理员日志信息
     *
     * @param Request $request
     *
     * @return PreacherResponse
     */
    public function paging(Request $request): PreacherResponse
    {
        return PagingQuery::request(
            request: $request,
            class: LogService::class,
            orderBy: [
                AdminLogSummary::ID,
                AdminLogSummary::UPDATED_AT,
                AdminLogSummary::CREATED_AT,
            ],
            queryRule: [
                'id' => ['nullable', 'integer'],
                'admin_id' => ['nullable', 'integer'],
                'api' => ['nullable', 'string'],
                'ipaddress' => ['nullable', 'string'],
                'updated_at' => ['nullable', 'string'],
                'created_at' => ['nullable', 'string'],
            ]
        );
    }

}
