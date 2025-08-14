<?php

namespace App\Filament\Widgets;

use App\Models\Penduduk;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class StatistikUsia extends ChartWidget
{
    protected static ?string $heading = 'Statistik Umur Penduduk';

    protected function getData(): array
    {
        $now = Carbon::now();

        // Kelompok usia (rentang & label)
        $ranges = [
            [0, 4],
            [5, 9],
            [10, 14],
            [15, 19],
            [20, 24],
            [25, 29],
            [30, 34],
            [35, 39],
            [40, 44],
            [45, 49],
            [50, 54],
            [55, 59],
            [60, 64],
            [65, 200], // 65+ dianggap 200 tahun batas atas
        ];
        $labels = [
            '0–4',
            '5–9',
            '10–14',
            '15–19',
            '20–24',
            '25–29',
            '30–34',
            '35–39',
            '40–44',
            '45–49',
            '50–54',
            '55–59',
            '60–64',
            '65+',
        ];

        // Ambil user login
        $user = Auth::user();

        // Query dasar dengan filter role
        $query = Penduduk::query();
        if ($user->hasRole('ketua_rt')) {
            $query->where('rt_id', $user->rt_id);
        } elseif ($user->hasRole('ketua_rw')) {
            $query->where('rw_id', $user->rw_id);
        }
        // admin_kelurahan melihat semua, jadi tidak difilter

        $data = [];

        foreach ($ranges as [$min, $max]) {
            if ($max < 200) {
                $count = (clone $query)->whereBetween(
                    'tanggal_lahir',
                    [
                        $now->copy()->subYears($max + 1)->addDay(),
                        $now->copy()->subYears($min),
                    ]
                )->count();
            } else {
                $count = (clone $query)->where('tanggal_lahir', '<=', $now->copy()->subYears(65))->count();
            }
            $data[] = $count;
        }

        // warna gradasi (14 warna)
        $colors = [];
        foreach (range(0, 13) as $i) {
            // gradasi dari biru ke merah
            $colors[] = "hsl(" . (200 + ($i * 10)) . ", 70%, 60%)";
        }

        return [
            'datasets' => [
                [
                    'type' => 'bar',
                    'label' => '', // tidak tampil di legend
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderColor' => 'transparent',
                    'borderWidth' => 0,
                ],
                // [
                //     'type' => 'line',
                //     'label' => '', // tidak tampil di legend
                //     'data' => $data,
                //     'borderColor' => '#000000',
                //     'tension' => 0.4,
                //     'pointBackgroundColor' => '#ffffff',
                //     'pointBorderColor' => '#000000',
                //     'fill' => false,
                // ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false, // hilangkan legend
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
