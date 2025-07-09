<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusPerkawinanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $statuses = ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'];

        foreach ($statuses as $status) {
            DB::table('status_perkawinans')->insert(['name' => $status, 'created_at' => now(), 'updated_at' => now()]);
        }
    }
}
