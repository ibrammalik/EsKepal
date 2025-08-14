<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $tahun = request('tahun', date('Y'));
        $statistik = [
            'total_penduduk' => 1234,
            'laki_laki' => 650,
            'perempuan' => 584,
            'kepala_keluarga' => 300
        ];
        $rekap = [
            ['nama' => 'Dusun A', 'jumlah' => 400, 'laki' => 210, 'perempuan' => 190],
            ['nama' => 'Dusun B', 'jumlah' => 500, 'laki' => 260, 'perempuan' => 240],
            ['nama' => 'Dusun C', 'jumlah' => 334, 'laki' => 180, 'perempuan' => 154],
        ];
        $chartUsia = [
            'labels' => ['0-5', '6-12', '13-17', '18-45', '46-60', '60+'],
            'data' => [50, 100, 80, 300, 200, 50]
        ];
        $chartPekerjaan = [
            'labels' => ['Petani', 'Pedagang', 'PNS', 'Wiraswasta', 'Pelajar'],
            'data' => [200, 150, 50, 100, 80]
        ];

        return view('welcome', compact(
            'tahun',
            'statistik',
            'rekap',
            'chartUsia',
            'chartPekerjaan'
        ));
    }
}
