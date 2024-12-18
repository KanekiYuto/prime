<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * 初始化时的数据填充
 *
 * @author KanekiYuto
 */
class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->callOnce([
            AdminSeeder::class
        ]);
    }

}
