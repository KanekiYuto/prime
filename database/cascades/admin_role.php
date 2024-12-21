<?php

use App\Models\Admin\Role as Model;
use Handyfit\Framework\Cascade\Blueprint;
use Handyfit\Framework\Cascade\Cascade;
use Handyfit\Framework\Cascade\Schema;
use Handyfit\Framework\Foundation\Database\Eloquent\Casts\AutoTimezone;

return Cascade::configure()->withTable(
    'admin_role',
    '管理员权限表'
)->withSchema(function (Schema $schema) {

    $schema->create(function (Blueprint $table) {
        $table->bigInteger('id')->primary()->unique()->fillable()->comment('管理员角色ID');
        $table->string('name', 32)->fillable()->comment('管理员角色名称');
        $table->string('explain', 64)->nullable()->fillable()->comment('管理员角色说明');
        $table->bigInteger('created_at')->cast(AutoTimezone::class)->fillable()->comment('创建时间');
        $table->bigInteger('updated_at')->cast(AutoTimezone::class)->fillable()->comment('修改时间');
    });

}, function (Schema $schema) {

    $schema->dropIfExists();

})->withMigration()->withModel(Model::class);
