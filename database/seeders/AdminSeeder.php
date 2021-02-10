<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('users')
            ->table('user_priv')
            ->insert([
                'user_id' => 1,
                'syscode' => 'intranet',
                'level' => 'admin'
            ]);
    }
}
