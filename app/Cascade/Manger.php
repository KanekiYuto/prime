<?php

namespace App\Cascade;

use Illuminate\Support\Collection;

class Manger
{

    protected function summaries(): Collection
    {
        return collect([
            Summaries\Ability\ApiSummary::class,
            Summaries\Ability\InfoSummary::class,
            Summaries\Ability\QuerySummary::class,
            Summaries\Ability\Relation\Ability\ApiSummary::class,
            Summaries\Ability\Relation\Api\QuerySummary::class,
            Summaries\Admin\AbilitySummary::class,
            Summaries\Admin\InfoSummary::class,
            Summaries\Admin\LogSummary::class,
            Summaries\Admin\RoleSummary::class,
            Summaries\Admin\Role\AbilitySummary::class,
            Summaries\Personal\Access\TokensSummary::class,
        ]);
    }

}
