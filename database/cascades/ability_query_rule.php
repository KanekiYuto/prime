<?php

use Handyfit\Framework\Cascade\Schema;
use Handyfit\Framework\Cascade\Cascade;
use Handyfit\Framework\Cascade\Blueprint;

return Cascade::configure()->withTable(
    'ability_query_rule',
    '能力查询规则'
)->withSchema(function (Schema $schema) {

    $schema->create(function (Blueprint $table) {
        // Do it...
    });

}, function (Schema $schema) {

    $schema->dropIfExists();

});
