<?php

namespace App\Http\Controllers\Backstage;

use App\Ability\Ability;
use Illuminate\Support\Facades\Request;
use Handyfit\Framework\Support\Facades\Preacher;
use Handyfit\Framework\Preacher\PreacherResponse;

/**
 * 能力控制器
 *
 * @author KanekiYuto
 */
class AbilityController
{

	/**
	 * 获取所有能力信息
	 *
	 * @param  Request  $request
	 *
	 * @return PreacherResponse
	 */
	public function abilities(Request $request): PreacherResponse
	{
		$requestParams = $request::validate([
			'rely' => ['required', 'string'],
		]);

        Preacher::base();

		return Preacher::rows(Ability::abilities($requestParams['rely']));
	}

	/**
	 * 获取所有能力组信息
	 *
	 * @param  Request  $request
	 *
	 * @return PreacherResponse
	 */
	public function groups(Request $request): PreacherResponse
	{
		$requestParams = $request::validate([
			'rely' => ['nullable', 'string'],
		]);

		return Preacher::rows(Ability::groups($requestParams['rely'] ?? ''));
	}

}
