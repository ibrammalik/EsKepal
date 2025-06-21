<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $agamas = [
            'Islam',
            'Kristen',
            'Katolik',
            'Hindu',
            'Buddha',
            'Konghucu',
            'Kepercayaan Lain',
        ];

        foreach ($agamas as $agama) {
            DB::table('agamas')->insert([
                'agama' => $agama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
