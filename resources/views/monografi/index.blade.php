@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-500 to-blue-700 text-white py-16 px-4 text-center">
        <h1 class="text-4xl font-bold mb-4 animate-fade-in">Data Kependudukan Desa</h1>
        <p class="text-lg mb-6 animate-fade-in">Lihat informasi lengkap warga desa dalam bentuk statistik interaktif</p>
        <a href="#statistik"
           class="px-6 py-3 bg-white text-blue-600 font-semibold rounded-full shadow hover:bg-gray-100 transition animate-fade-in">
            Lihat Data
        </a>
    </section>

    <!-- Filter -->
    <section class="px-4 mt-10" id="statistik" x-data="{ tahun: '{{ $tahun }}' }">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 animate-fade-in">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Monografi Warga</h2>
                <p class="text-gray-500">Data kependudukan desa berdasarkan tahun</p>
            </div>
            <select x-model="tahun" @change="window.location='?tahun='+tahun"
                class="border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                @for($i = date('Y'); $i >= date('Y')-5; $i--)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
    </section>

    <!-- Statistik Cards -->
    <section class="grid grid-cols-1 md:grid-cols-4 gap-6 px-4 mt-8">
        @php
            $cards = [
                ['label'=>'Total Penduduk','value'=>$statistik['total_penduduk']],
                ['label'=>'Laki-laki','value'=>$statistik['laki_laki']],
                ['label'=>'Perempuan','value'=>$statistik['perempuan']],
                ['label'=>'Kepala Keluarga','value'=>$statistik['kepala_keluarga']],
            ];
        @endphp
        @foreach ($cards as $card)
        <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-4 hover:shadow-md hover:-translate-y-1 transition animate-fade-in">
            <div class="w-12 h-12 rounded-xl bg-blue-100"></div>
            <div>
                <p class="text-sm text-gray-500">{{ $card['label'] }}</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $card['value'] }}</p>
            </div>
        </div>
        @endforeach
    </section>

    <!-- Grafik -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-6 px-4 mt-8">
        <div class="bg-white rounded-2xl shadow-sm p-6 animate-fade-in">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Distribusi Usia</h3>
            <canvas id="chartUsia"></canvas>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-6 animate-fade-in">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Pekerjaan</h3>
            <canvas id="chartPekerjaan"></canvas>
        </div>
    </section>

    <!-- Tabel Ringkas -->
    <section class="bg-white rounded-2xl shadow-sm p-6 px-4 mt-8 animate-fade-in">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Rekap Per Dusun</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="text-left px-4 py-2 font-medium text-gray-500">Dusun</th>
                        <th class="text-left px-4 py-2 font-medium text-gray-500">Jumlah</th>
                        <th class="text-left px-4 py-2 font-medium text-gray-500">Laki-laki</th>
                        <th class="text-left px-4 py-2 font-medium text-gray-500">Perempuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekap as $row)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $row['nama'] }}</td>
                        <td class="px-4 py-2 font-semibold">{{ $row['jumlah'] }}</td>
                        <td class="px-4 py-2">{{ $row['laki'] }}</td>
                        <td class="px-4 py-2">{{ $row['perempuan'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartUsia = new Chart(document.getElementById('chartUsia').getContext('2d'), {
        type: 'bar',
        data: {
            labels: @json($chartUsia['labels']),
            datasets: [{
                label: 'Jumlah',
                data: @json($chartUsia['data']),
                backgroundColor: '#3b82f6',
                borderRadius: 6
            }]
        },
        options: { responsive: true }
    });

    const chartPekerjaan = new Chart(document.getElementById('chartPekerjaan').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: @json($chartPekerjaan['labels']),
            datasets: [{
                data: @json($chartPekerjaan['data']),
                backgroundColor: ['#34d399', '#60a5fa', '#fbbf24', '#f87171', '#a78bfa'],
                borderWidth: 1
            }]
        },
        options: { responsive: true, cutout: '70%' }
    });
</script>
@endpush
