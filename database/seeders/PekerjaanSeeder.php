<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pekerjaans = [
            'Petani',
            'Nelayan',
            'Guru',
            'Dosen',
            'Dokter',
            'Perawat',
            'Karyawan Swasta',
            'Pegawai Negeri',
            'Wiraswasta',
            'Pelajar',
            'Mahasiswa',
            'Tidak Bekerja',
            'Lainnya'
        ];
        foreach ($pekerjaans as $pekerjaan) {
            DB::table('pekerjaans')->insert(['pekerjaan' => $pekerjaan, 'created_at' => now(), 'updated_at' => now()]);
        }
    }
}
