<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusKependudukanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $statuses = ['Aktif', 'Pindah', 'Meninggal', 'Pendatang'];
        foreach ($statuses as $status) {
            DB::table('status_kependudukans')->insert(['status' => $status, 'created_at' => now(), 'updated_at' => now()]);
        }
    }
}
