<?php

namespace App\Filament\Widgets;

use App\Models\Penduduk;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class StatistikOverview extends BaseWidget
{
  protected function getStats(): array
  {
    $now = Carbon::now();

    $total = Penduduk::count();
    $laki = Penduduk::where('jenis_kelamin', 'L')->count();
    $perempuan = Penduduk::where('jenis_kelamin', 'P')->count();

    // Jumlah KK berdasarkan no_kk unik
    $jumlahKk = Penduduk::distinct('no_kk')->count('no_kk');

    // Usia produktif 15–64 tahun
    $usiaProduktif = Penduduk::whereBetween('tanggal_lahir', [
      $now->copy()->subYears(64),
      $now->copy()->subYears(15),
    ])->count();

    // Contoh kategori pendidikan umum
    $pendidikanDasar = Penduduk::whereHas('pendidikan', fn($q) => $q->whereIn('nama', ['SD', 'MI']))->count();
    $pendidikanMenengah = Penduduk::whereHas('pendidikan', fn($q) => $q->whereIn('nama', ['SMP', 'MTs', 'SMA', 'MA', 'SMK']))->count();
    $pendidikanTinggi = Penduduk::whereHas('pendidikan', fn($q) => $q->whereIn('nama', ['D3', 'S1', 'S2', 'S3']))->count();

    return [
      Stat::make('Total Penduduk', $total)
        ->description('Semua penduduk terdaftar')
        ->color('primary'),

      Stat::make('Jumlah KK', $jumlahKk)
        ->description('Nomor KK')
        ->color('secondary'),

      Stat::make('Laki-laki', $laki)
        ->description('Penduduk laki-laki')
        ->color('info'),

      Stat::make('Perempuan', $perempuan)
        ->description('Penduduk perempuan')
        ->color('pink'),

      Stat::make('Usia Produktif', $usiaProduktif)
        ->description('15 – 64 tahun')
        ->color('success'),
    ];
  }
}
