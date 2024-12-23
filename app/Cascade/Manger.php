<?php

namespace App\Cascade;

use Illuminate\Support\Collection;

class Manger
{

    protected function summaries(): Collection
    {
        return collect([
            Summaries\AbilityApiSummary::class,
            Summaries\AbilityInfoSummary::class,
            Summaries\AbilityQuerySummary::class,
            Summaries\Ability\Relation\AbilityApiSummary::class,
            Summaries\Ability\Relation\ApiQuerySummary::class,
            Summaries\AdminAbilitySummary::class,
            Summaries\AdminInfoSummary::class,
            Summaries\AdminLogSummary::class,
            Summaries\AdminRoleSummary::class,
            Summaries\Admin\RoleAbilitySummary::class,
            Summaries\Personal\AccessTokensSummary::class,
        ]);
    }

}
