<?php

use Handyfit\Framework\Cascade\Schema;
use Handyfit\Framework\Cascade\Cascade;
use Handyfit\Framework\Cascade\Blueprint;
use Handyfit\Framework\Foundation\Database\Eloquent\Casts\AutoTimezone;

return Cascade::configure()->withTable(
    'ability_info',
    '能力信息表'
)->withSchema(function (Schema $schema) {

    $schema->create(function (Blueprint $table) {

        $table->bigInteger('id')->cast('string')->primary()->unique()->fillable()->comment('能力 - [ID]');
        $table->string('name', 32)->fillable()->comment('能力名称');
        $table->string('explain', 64)->nullable()->fillable()->comment('能力解释');
        $table->bigInteger('parent_id')->fillable()->comment('父级 - ID');
        $table->enum('type', ['group', 'menu', 'ability'])->fillable()->comment('能力类型');
        $table->bigInteger('created_at')->cast(AutoTimezone::class)->fillable()->comment('创建时间');
        $table->bigInteger('updated_at')->cast(AutoTimezone::class)->fillable()->comment('修改时间');

    });

}, function (Schema $schema) {

    $schema->dropIfExists();

});