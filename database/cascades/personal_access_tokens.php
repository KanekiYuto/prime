<?php

use Handyfit\Framework\Cascade\Schema;
use Handyfit\Framework\Cascade\Cascade;
use Handyfit\Framework\Cascade\Blueprint;
use Laravel\Sanctum\PersonalAccessToken as Model;
use Handyfit\Framework\Foundation\Hook\Eloquent as Hook;

return Cascade::configure()->withTable(
    'personal_access_tokens',
    '私人授权令牌信息表'
)->withSchema(function (Schema $schema) {

    $schema::create(function (Blueprint $table) {
        $table->bigInteger('id')->comment('私人访问令牌ID');
        $table->morphs('tokenable');
        $table->string('name')->fillable()->comment('令牌名称');
        $table->string('token', 64)->unique()->fillable()->hidden()->comment('令牌内容');
        $table->text('abilities')->nullable()->fillable()->comment('令牌能力');
        $table->timestamp('last_used_at')->nullable()->comment('令牌最终使用时间');
        $table->timestamp('expires_at')->nullable()->fillable()->comment('令牌过期时间');
        $table->bigInteger('created_at')->comment('创建时间');
        $table->bigInteger('updated_at')->comment('修改时间');
    });

}, function (Schema $schema) {

    $schema::dropIfExists();

})->withModel(Model::class, Hook::class);
