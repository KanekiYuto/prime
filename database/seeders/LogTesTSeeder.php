<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Cascade\Models\Admin\LogModel;

class LogTesTSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i = 0; $i <= 1000; $i++) {
            LogModel::query()->create([
                'admin_id' => 1733713907198,
                'api' => 'test',
                'ipaddress' => '127.0.0.1',
                'payload' => [],
                'headers' => [],
                'response' => [],
            ]);
        }
    }

}
