<?php

namespace App\Filament\Widgets;

use App\Models\Penduduk;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class StatistikUsia extends ChartWidget
{
    protected static ?string $heading = 'Statistik Usia Penduduk';

    protected function getData(): array
    {
        $now = Carbon::now();

        $usia0_14 = Penduduk::whereBetween('tanggal_lahir', [
            $now->copy()->subYears(14),
            $now,
        ])->count();

        $usia15_64 = Penduduk::whereBetween('tanggal_lahir', [
            $now->copy()->subYears(64),
            $now->copy()->subYears(15),
        ])->count();

        $usia65plus = Penduduk::where('tanggal_lahir', '<=', $now->copy()->subYears(65))->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => [$usia0_14, $usia15_64, $usia65plus],
                    'backgroundColor' => ['#38bdf8', '#4ade80', '#f87171'],
                ],
            ],
            'labels' => ['0–14 tahun', '15–64 tahun', '65+ tahun'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
