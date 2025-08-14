<?php

namespace App\Filament\Widgets;

use App\Models\Penduduk;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class StatistikOverview extends BaseWidget
{
  protected function getStats(): array
  {
    $now = Carbon::now();
    $user = Auth::user();

    // Query dasar sesuai role user
    $pendudukQuery = Penduduk::query();
    if ($user->hasRole('ketua_rt')) {
      $pendudukQuery->where('rt_id', $user->rt_id);
    } elseif ($user->hasRole('ketua_rw')) {
      $pendudukQuery->where('rw_id', $user->rw_id);
    }
    // admin_kelurahan => tidak difilter

    // Gunakan clone agar query tidak saling mempengaruhi
    $total = (clone $pendudukQuery)->count();
    $laki = (clone $pendudukQuery)->where('jenis_kelamin', 'L')->count();
    $perempuan = (clone $pendudukQuery)->where('jenis_kelamin', 'P')->count();

    // Jumlah KK (berdasarkan no_kk unik)
    $jumlahKk = (clone $pendudukQuery)->distinct('no_kk')->count('no_kk');

    // Usia produktif 15–64 tahun
    $usiaProduktif = (clone $pendudukQuery)->whereBetween('tanggal_lahir', [
      $now->copy()->subYears(64),
      $now->copy()->subYears(15),
    ])->count();

    // Pendidikan (opsional: jika ingin dipakai lagi)
    // $pendidikanDasar = (clone $pendudukQuery)
    //     ->whereHas('pendidikan', fn($q) => $q->whereIn('nama', ['SD', 'MI']))->count();
    // $pendidikanMenengah = (clone $pendudukQuery)
    //     ->whereHas('pendidikan', fn($q) => $q->whereIn('nama', ['SMP', 'MTs', 'SMA', 'MA', 'SMK']))->count();
    // $pendidikanTinggi = (clone $pendudukQuery)
    //     ->whereHas('pendidikan', fn($q) => $q->whereIn('nama', ['D3', 'S1', 'S2', 'S3']))->count();

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
