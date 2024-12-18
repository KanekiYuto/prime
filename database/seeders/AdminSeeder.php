<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * 管理员数据填充
 *
 * @author KanekiYuto
 */
class AdminSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->callOnce([
            AdminAbilitySeeder::class,
        ]);
    }

}
