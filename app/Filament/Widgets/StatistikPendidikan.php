<?php

namespace App\Filament\Widgets;

use App\Models\Pendidikan;
use Filament\Widgets\ChartWidget;

class StatistikPendidikan extends ChartWidget
{
    protected static ?string $heading = 'Statistik Pendidikan Penduduk';

    protected function getData(): array
    {
        $pendidikan = Pendidikan::withCount('penduduk')->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => $pendidikan->pluck('penduduk_count'),
                    'backgroundColor' => '#6366f1',
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
