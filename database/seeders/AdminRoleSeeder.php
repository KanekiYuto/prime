<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use App\Cascade\Models\Admin\RoleModel;
use Handyfit\Framework\Support\Timestamp;
use App\Cascade\Models\Admin\AbilityModel;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace;
use App\Cascade\Trace\Eloquent\Admin\AbilityTrace;
use App\Cascade\Models\AdminRole\AbilityModel as AdminRoleAbilityModel;
use App\Cascade\Trace\Eloquent\AdminRole\AbilityTrace as AdminRoleAbilityTrace;

/**
 * 管理员角色填充
 *
 * @author KanekiYuto
 */
class AdminRoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $roleId = Timestamp::millisecond();

        $idArray = AbilityModel::query()
            ->pluck(AbilityTrace::ID)
            ->toArray();

        RoleModel::query()->create([
            RoleTrace::ID => $roleId,
            RoleTrace::NAME => '超级管理员',
            RoleTrace::EXPLAIN => '拥有平台所有权限',
        ])->save();

        foreach ($idArray as $item) {
            AdminRoleAbilityModel::query()->create([
                AdminRoleAbilityTrace::ROLE_ID => $roleId,
                AdminRoleAbilityTrace::ABILITY_ID => $item,
            ]);
        }

        Cache::put('seeder-admin-role-id', $roleId, 5 * 60);

        $this->callOnce([
            AdminInfoSeeder::class,
        ]);
    }

}
