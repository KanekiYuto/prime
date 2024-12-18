<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Cascade\Models\Admin\InfoModel as AdminInfo;
use App\Cascade\Trace\Eloquent\Admin\InfoTrace as TheTrace;

/**
 * 管理员数据填充
 *
 * @author KanekiYuto
 */
class AdminInfoSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $roleId = (int) Cache::get('seeder-admin-role-id');

        AdminInfo::query()->create([
            TheTrace::ACCOUNT => 'phpunit@master',
            TheTrace::PASS => Hash::make('phpunit@pass'),
            TheTrace::EMAIL => 'phpunit-master@rubust.com',
            TheTrace::ADMIN_ROLE_ID => $roleId,
        ])->save();

        AdminInfo::query()->create([
            TheTrace::ACCOUNT => 'KanekiYuto',
            TheTrace::PASS => Hash::make('KanekiYuto@pass'),
            TheTrace::EMAIL => 'kaneki.yuto.404@gmail.com',
            TheTrace::ADMIN_ROLE_ID => $roleId,
        ])->save();
    }

}
