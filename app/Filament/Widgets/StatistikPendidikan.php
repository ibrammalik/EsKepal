<?php

namespace App\Filament\Widgets;

use App\Models\Pendidikan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class StatistikPendidikan extends ChartWidget
{
    protected static ?string $heading = 'Statistik Pendidikan Penduduk';

    protected function getData(): array
    {
        $user = Auth::user();

        $pendidikan = Pendidikan::withCount([
            'penduduk as penduduk_count' => function ($query) use ($user) {
                if ($user->hasRole('ketua_rt')) {
                    $query->where('rt_id', $user->rt_id);
                } elseif ($user->hasRole('ketua_rw')) {
                    $query->where('rw_id', $user->rw_id);
                }
                // admin_kelurahan -> tidak difilter
            }
        ])->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => $pendidikan->pluck('penduduk_count'),
                    'backgroundColor' => '#6366f1',
                    'borderColor' => 'transparent',
                    'borderWidth' => 0,
                ],
            ],
            'labels' => $pendidikan->pluck('nama'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
