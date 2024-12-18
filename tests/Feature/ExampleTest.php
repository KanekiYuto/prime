<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Testing\Fluent\AssertableJson;
use Handyfit\Framework\Preacher\PreacherResponse as PResponse;

describe('管理员相关', function () {

	it('管理员 登录', function (string $account, string $pass) {
		$response = $this->post('/backstage/admin/login', [
			'account' => $account,
			'pass' => $pass,
		]);

		$response->assertStatus(200)
			->assertJson(
				fn(AssertableJson $json) => $json->hasAll(['code', 'msg'])
					->where(PResponse::DEFAULT_KEY_CODE, PResponse::RESP_CODE_SUCCEED)
					->has('receipt', fn(AssertableJson $json) => $json->hasall(['tokenId', 'tokenBody']))
			);

		$json = $response->json();

		$receipt = $json['receipt'];
		$tokenId = $receipt['tokenId'];
		$tokenBody = $receipt['tokenBody'];
		$token = "Bearer $tokenId|$tokenBody";

		// 存储令牌
		Cache::put('phpunit-auth-token', $token);
	})->with([
		[
			'account' => 'phpunit@master',
			'pass' => 'phpunit@pass',
		],
	]);

	it('管理员 信息', function () {
		$response = $this->withHeaders([
			'Authorization' => Cache::get('phpunit-auth-token'),
		])->get('/backstage/admin/info');

		$response->assertStatus(200)
			->assertJson(['code' => 200]);

		dd($response->json());
	});


});
