<?php

namespace Database\Seeders;

use App\Models\Pendidikan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'TK', 'kategori' => 'Umum'],
            ['nama' => 'SD', 'kategori' => 'Umum'],
            ['nama' => 'SMP', 'kategori' => 'Umum'],
            ['nama' => 'SMA', 'kategori' => 'Umum'],
            ['nama' => 'D1-D3', 'kategori' => 'Umum'],
            ['nama' => 'Sarjana', 'kategori' => 'Umum'],
            ['nama' => 'Pascasarjana', 'kategori' => 'Umum'],
            ['nama' => 'Pondok Pesantren', 'kategori' => 'Khusus'],
            ['nama' => 'Pendidikan Keagamaan', 'kategori' => 'Khusus'],
            ['nama' => 'Sekolah Luar Biasa', 'kategori' => 'Khusus'],
            ['nama' => 'Kursus Keterampilan', 'kategori' => 'Khusus'],
        ];

        Pendidikan::insert($data);
    }
}
