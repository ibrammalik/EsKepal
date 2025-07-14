<?php

namespace Database\Seeders;

use App\Models\Penduduk;
use App\Models\Rt;
use App\Models\Rw;
use App\Models\Agama;
use App\Models\Pekerjaan;
use App\Models\Pendidikan;
use App\Models\StatusKependudukan;
use App\Models\StatusPerkawinan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PendudukSeeder extends Seeder
{
    public function run(): void
    {
        $rws = Rw::all();
        $agama = Agama::inRandomOrder()->first();
        $pekerjaan = Pekerjaan::inRandomOrder()->first();
        $statusPerkawinan = StatusPerkawinan::inRandomOrder()->first();
        $statusKependudukan = StatusKependudukan::inRandomOrder()->first();
        $pendidikan = Pendidikan::inRandomOrder()->first();

        $shdkOptions = [
            'Kepala Keluarga',
            'Suami',
            'Istri',
            'Anak',
            'Menantu',
            'Orang Tua',
            'Mertua',
            'Pembantu',
            'Famili Lain',
            'Lainnya',
        ];

        foreach ($rws as $rw) {
            foreach ($rw->rts as $rt) {
                foreach (range(1, 5) as $i) {
                    Penduduk::create([
                        'nik' => fake()->unique()->numerify('3204###########'),
                        'no_kk' => fake()->numerify('3204############'),
                        'nama' => fake()->name(),
                        'pendidikan_id' => $pendidikan?->id,
                        'shdk' => fake()->randomElement($shdkOptions),
                        'alamat' => fake()->address(),
                        'jenis_kelamin' => fake()->randomElement(['L', 'P']),
                        'tanggal_lahir' => fake()->dateTimeBetween('-70 years', '-1 years')->format('Y-m-d'),
                        'tempat_lahir' => fake()->city(),
                        'rt_id' => $rt->id,
                        'rw_id' => $rw->id,
                        'agama_id' => $agama?->id,
                        'pekerjaan_id' => $pekerjaan?->id,
                        'status_perkawinan_id' => $statusPerkawinan?->id,
                        'status_kependudukan_id' => $statusKependudukan?->id,
                    ]);
                }
            }
        }
    }
}
