<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Cascade\Models\AdminAbilityModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Cascade\Summaries\Admin\RoleAbilitySummary as AdminRoleAbilityTrace;

class Role extends Model
{

    /**
     * 绑定能力信息 [多对多关联]
     *
     * @return BelongsToMany
     */
    public function abilities(): BelongsToMany
    {
        return $this->belongsToMany(
            AdminAbilityModel::class,
            AdminRoleAbilityTrace::TABLE,
            AdminRoleAbilityTrace::ROLE_ID,
            AdminRoleAbilityTrace::ABILITY_ID
        );
    }

}
