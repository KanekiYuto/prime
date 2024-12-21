<?php

use Handyfit\Framework\Cascade\Blueprint;
use Handyfit\Framework\Cascade\Cascade;
use Handyfit\Framework\Cascade\Schema;
use Handyfit\Framework\Foundation\Database\Eloquent\Casts\AutoTimezone;

return Cascade::configure()->withTable(
    'ability_query',
    '查询能力'
)->withSchema(function (Schema $schema) {

    $schema->create(function (Blueprint $table) {
        $table->bigInteger('id')->primary()->unique()->fillable()->comment('ID');
        $table->string('name', 32)->fillable()->comment('名称');
        $table->string('explain', 64)->nullable()->fillable()->comment('说明');
        $table->string('instance')->fillable()->comment('实例');
        $table->bigInteger('created_at')->cast(AutoTimezone::class)->fillable()->comment('创建时间');
        $table->bigInteger('updated_at')->cast(AutoTimezone::class)->fillable()->comment('修改时间');
    });

}, function (Schema $schema) {

    $schema->dropIfExists();

});
