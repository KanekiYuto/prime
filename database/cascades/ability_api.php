<?php

use Handyfit\Framework\Cascade\Schema;
use Handyfit\Framework\Cascade\Cascade;
use Handyfit\Framework\Cascade\Blueprint;

return Cascade::configure()->withTable(
    'ability_api',
    'Table explain'
)->withSchema(function (Schema $schema) {

    $schema->create(function (Blueprint $table) {

        $table->bigInteger('id')->primary()->unique()->fillable()->comment('ID');

    });

}, function (Schema $schema) {

    $schema->dropIfExists();

});
