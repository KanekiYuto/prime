<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Testing\Fluent\AssertableJson;
use Handyfit\Framework\Preacher\PreacherResponse as PResponse;

$adminStack = collect()->push([
    'account' => 'phpunit@master',
    'pass' => 'phpunit@pass',
]);

$adminStackUuid = $adminStack->map(function (array $item) {
    return md5($item['account']);
});

// 管理员登录
test('DevOps: Admin login', function (string $account, string $pass) {
    $response = $this->post('/dev-ops/admin/login', [
        'account' => $account,
        'pass' => $pass,
    ]);

    $response->assertStatus(200)->assertJson(
        fn(AssertableJson $json) => $json->hasAll(
            ['code', 'msg', 'receipt']
        )->where(PResponse::DEFAULT_KEY_CODE, PResponse::RESP_CODE_SUCCEED)
    );

    $json = $response->json();
    $receipt = $json['receipt'];

    $token = Str::of($receipt['accessToken'])->prepend('Bearer ');

    $uuid = md5($account);

    // 存储令牌
    Cache::put("phpunit-access-token-$uuid", $token);
})->with($adminStack->all());

// 获取管理员信息
it('DevOps: Get admin info', function (string $uuid) {
    $response = $this->withHeaders([
        'Authorization' => Cache::get("phpunit-access-token-$uuid"),
    ])->get('/dev-ops/admin/info');

    $response->assertStatus(200)->assertJson(
        fn(AssertableJson $json) => $json->hasAll(
            ['code', 'msg', 'receipt']
        )->where(PResponse::DEFAULT_KEY_CODE, PResponse::RESP_CODE_SUCCEED)
    );

    $json = $response->json();
    $receipt = $json['receipt'];

    $token = Str::of($receipt['token']['accessToken'])->prepend('Bearer ');

    // 令牌更新替换
    Cache::put("phpunit-access-token-$uuid", $token);
})->with($adminStackUuid);

// 批量接口测试
describe('DevOps: Batch interface testing', function () use ($adminStackUuid) {
    // 分页接口
    it('DevOps: Paging batch testing', function (string $uuid) {
        $uriStack = collect(['info', 'role', 'log',]);

        foreach ($uriStack as $item) {
            $url = url()->query("/dev-ops/admin/$item/paging", [
                'page' => 1,
                'prePage' => 5,
                'orderBy' => 'id',
                'order' => 'asc',
            ]);

            $response = $this->withHeaders([
                'Authorization' => Cache::get("phpunit-access-token-$uuid"),
            ])->get($url);

            $response->assertStatus(200)->assertJson(
                fn(AssertableJson $json) => $json->hasAll(
                    ['code', 'msg', 'paging']
                )->where(PResponse::DEFAULT_KEY_CODE, PResponse::RESP_CODE_SUCCEED)
            );
        }
    })->with($adminStackUuid);

    it('DevOps: Select batch testing', function (string $uuid) {
        $uriStack = collect(['info', 'role',]);

        foreach ($uriStack as $item) {
            $url = url()->query("/dev-ops/admin/$item/select");

            $response = $this->withHeaders([
                'Authorization' => Cache::get("phpunit-access-token-$uuid"),
            ])->get($url);

            $response->assertStatus(200)->assertJson(
                fn(AssertableJson $json) => $json->hasAll(
                    ['code', 'msg', 'rows']
                )->where(PResponse::DEFAULT_KEY_CODE, PResponse::RESP_CODE_SUCCEED)
            );
        }
    })->with($adminStackUuid);
});

// 退出登录
it('Dev Ops: Admin logout', function (string $uuid) {
    $response = $this->withHeaders([
        'Authorization' => Cache::get("phpunit-access-token-$uuid"),
    ])->post('/dev-ops/admin/logout');

    $response->assertStatus(200)->assertJson(
        fn(AssertableJson $json) => $json->hasAll(
            ['code', 'msg']
        )->where(PResponse::DEFAULT_KEY_CODE, PResponse::RESP_CODE_SUCCEED)
    );
})->with($adminStackUuid);
