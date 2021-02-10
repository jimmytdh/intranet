<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nodes')
            ->insert([
                'parent_id' => 0,
                'title' => 'MCC',
                'type' => 'main'
            ]);

        DB::table('nodes')
            ->insert([
                'parent_id' => 0,
                'title' => 'HOPSS',
                'type' => 'main'
            ]);

        DB::table('nodes')
            ->insert([
                'parent_id' => 0,
                'title' => 'NSD',
                'type' => 'main'
            ]);

        DB::table('nodes')
            ->insert([
                'parent_id' => 0,
                'title' => 'MPS',
                'type' => 'main'
            ]);

        DB::table('nodes')
            ->insert([
                'parent_id' => 1,
                'title' => 'IHOMP',
                'type' => 'sub'
            ]);

        DB::table('nodes')
            ->insert([
                'parent_id' => 1,
                'title' => 'PETRO',
                'type' => 'sub'
            ]);
    }
}
