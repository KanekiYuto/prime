<?php

use Handyfit\Framework\Cascade\Schema;
use Handyfit\Framework\Cascade\Cascade;
use Handyfit\Framework\Cascade\Blueprint;
use Handyfit\Framework\Foundation\Database\Eloquent\Casts\AutoTimezone;

return Cascade::configure()->withTable(
    'ability_api_query',
    '接口能力 - 查询能力 - 关联'
)->withSchema(function (Schema $schema) {

    $schema->create(function (Blueprint $table) {
        $table->bigInteger('id')->primary()->unique()->fillable()->comment('ID');
        $table->bigInteger('ability_api_id')->fillable()->comment('接口能力 - ID');
        $table->bigInteger('ability_query_id')->fillable()->comment('查询能力 - ID');
        $table->bigInteger('created_at')->cast(AutoTimezone::class)->fillable()->comment('创建时间');
        $table->bigInteger('updated_at')->cast(AutoTimezone::class)->fillable()->comment('修改时间');
    });

}, function (Schema $schema) {

    $schema->dropIfExists();

});
