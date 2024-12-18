<?php

namespace App\Http\Controllers\Backstage\Admin;

use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rules\Password;
use Kaneki\Diverse\PagingQuery\PagingQuery;
use Handyfit\Framework\Support\Facades\Preacher;
use Handyfit\Framework\Preacher\PreacherResponse;
use App\Http\Service\Backstage\Admin\InfoService;
use App\Cascade\Trace\Eloquent\Admin\InfoTrace as TheTrace;

/**
 * 管理員信息控制器
 *
 * @author KanekiYuto
 */
class InfoController
{

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
	 * @param  Request  $request
	 *
	 * @return PreacherResponse
	 */
	public function paging(Request $request): PreacherResponse
	{
		return PagingQuery::request(
			request: $request,
			class: InfoService::class,
			orderBy: [
                TheTrace::ID,
                TheTrace::ACCOUNT,
                TheTrace::EMAIL,
                TheTrace::UPDATED_AT,
                TheTrace::CREATED_AT,
            ],
			queryRule: [
				'id' => ['nullable', 'string'],
			]
		);
	}

	/**
	 * 新增管理員信息
	 *
	 * @param  Request  $request
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
	 * @param  Request  $request
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

	/**
	 * 刪除管理員信息
	 *
	 * @param  Request  $request
	 *
	 * @todo 暫時不打算支持
	 */
	public function delete(Request $request): void
	{

	}

}
