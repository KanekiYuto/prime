<?php

use Handyfit\Framework\Cascade\Blueprint;
use Handyfit\Framework\Cascade\Cascade;
use Handyfit\Framework\Cascade\Schema;
use Handyfit\Framework\Foundation\Database\Eloquent\Casts\AutoTimezone;
use Illuminate\Database\Eloquent\Model as Model;

return Cascade::configure()->withTable(
    'admin_role_ability',
    '管理员角色能力信息表'
)->withSchema(function (Schema $schema) {

    $schema->create(function (Blueprint $table) {
        $table->bigInteger('id')->primary()->unique()->fillable()->comment('角色能力 - [ID]');
        $table->bigInteger('role_id')->fillable()->comment('角色 - [ID]');
        $table->bigInteger('ability_id')->fillable()->comment('能力 - [ID]');
        $table->bigInteger('created_at')->cast(AutoTimezone::class)->fillable()->comment('创建时间');
        $table->bigInteger('updated_at')->cast(AutoTimezone::class)->fillable()->comment('修改时间');
    });

}, function (Schema $schema) {

    $schema->dropIfExists();

})->withMigration()->withModel(Model::class);
