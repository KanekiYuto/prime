<?php

namespace App\Http\Controllers\DevOps\Admin;

use Illuminate\Support\Facades\Request;
use Kaneki\Diverse\PagingQuery\PagingQuery;
use Handyfit\Framework\Preacher\PreacherResponse;
use App\Http\Service\DevOps\Admin\LogService;
use App\Cascade\Trace\Eloquent\Admin\LogTrace as TheTrace;

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
	 * @param  Request  $request
	 *
	 * @return PreacherResponse
	 */
	public function paging(Request $request): PreacherResponse
	{
		return PagingQuery::request(
			request: $request,
			class: LogService::class,
			orderBy: [
				TheTrace::ID,
				TheTrace::UPDATED_AT,
				TheTrace::CREATED_AT,
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
