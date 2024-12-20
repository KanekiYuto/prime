<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Testing\Fluent\AssertableJson;
use Handyfit\Framework\Preacher\PreacherResponse as PResponse;

test('DevOps admin login', function (string $account, string $pass) {
    $response = $this->post('/dev-ops/admin/login', [
        'account' => $account,
        'pass' => $pass,
    ]);

    $response->assertStatus(200)->assertJson(
        fn(AssertableJson $json) => $json->hasAll(['code', 'msg'])
            ->where(PResponse::DEFAULT_KEY_CODE, PResponse::RESP_CODE_SUCCEED)
            ->has('receipt', fn(AssertableJson $json) => $json->hasall(['accessToken', 'tokenId']))
    );

    $json = $response->json();
    $receipt = $json['receipt'];

    $token = Str::of($receipt['accessToken'])->prepend('Bearer ');

    // 存储令牌
    Cache::put('phpunit-auth-access-token', $token);
})->with([
    [
        'account' => 'phpunit@master',
        'pass' => 'phpunit@pass',
    ],
]);
