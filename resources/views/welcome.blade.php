@extends('layouts.app')

@section('content')
<!-- Hero -->
<section class="bg-brand/10 dark:bg-brand/20 py-16 text-center fade-in">
    <h1 class="text-4xl font-bold mb-4">Elektronik Sistem Kependudukan Kalicari
    </h1>
    <p class="text-lg text-gray-600 dark:text-gray-300">Digitalisasi
        administrasi dan layanan masyarakat tingkat kelurahan</p>
</section>

<!-- Tentang -->
<section class="max-w-4xl mx-auto px-4 py-12 fade-in">
    <h2 class="text-2xl font-semibold mb-4">Tentang Aplikasi</h2>
    <p class="leading-relaxed">
        Aplikasi ini membantu kelurahan dan ketua RW untuk mengelola data
        penduduk, mencatat peristiwa mutasi,
        serta memudahkan layanan surat menyurat secara online.
    </p>
</section>

<!-- Statistik Penduduk -->
<section id="statistik" class="py-12 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-6xl mx-auto px-4">
        <h2
            class="text-2xl font-semibold text-center mb-8 text-gray-800 dark:text-gray-100">
            Statistik Penduduk</h2>
        <div class="grid md:grid-cols-2 gap-8">

            <!-- Chart: RW -->
            <div class="bg-white dark:bg-gray-900 p-4 rounded shadow">
                <h3
                    class="font-semibold text-center mb-2 text-gray-700 dark:text-gray-200">
                    Jumlah Penduduk per RW</h3>
                <canvas id="rwChart" height="200"></canvas>
            </div>

            <!-- Chart: Jenis Kelamin -->
            <div class="bg-white dark:bg-gray-900 p-4 rounded shadow">
                <h3
                    class="font-semibold text-center mb-2 text-gray-700 dark:text-gray-200">
                    Komposisi Jenis Kelamin</h3>
                <canvas id="genderChart" height="200"></canvas>
            </div>
        </div>
    </div>
</section>

<!-- Rekapitulasi Penduduk -->
<section id="rekap" class="py-12 bg-white dark:bg-gray-900">
    <div class="max-w-6xl mx-auto px-4">
        <h2
            class="text-2xl font-semibold text-center mb-6 text-gray-800 dark:text-gray-100">
            Rekapitulasi Penduduk</h2>
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr
                        class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-100">
                        <th class="border px-4 py-2">RW</th>
                        <th class="border px-4 py-2">Jumlah KK</th>
                        <th class="border px-4 py-2">Jumlah Penduduk</th>
                        <th class="border px-4 py-2">Laki-laki</th>
                        <th class="border px-4 py-2">Perempuan</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 dark:text-gray-300">
                    <tr>
                        <td class="border px-4 py-2 text-center">01</td>
                        <td class="border px-4 py-2 text-center">120</td>
                        <td class="border px-4 py-2 text-center">450</td>
                        <td class="border px-4 py-2 text-center">230</td>
                        <td class="border px-4 py-2 text-center">220</td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2 text-center">02</td>
                        <td class="border px-4 py-2 text-center">98</td>
                        <td class="border px-4 py-2 text-center">370</td>
                        <td class="border px-4 py-2 text-center">190</td>
                        <td class="border px-4 py-2 text-center">180</td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2 text-center">03</td>
                        <td class="border px-4 py-2 text-center">110</td>
                        <td class="border px-4 py-2 text-center">400</td>
                        <td class="border px-4 py-2 text-center">210</td>
                        <td class="border px-4 py-2 text-center">190</td>
                    </tr>
                </tbody>
                <tfoot
                    class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                    <tr>
                        <td class="border px-4 py-2 text-center font-bold">Total
                        </td>
                        <td class="border px-4 py-2 text-center font-bold">328
                        </td>
                        <td class="border px-4 py-2 text-center font-bold">1.220
                        </td>
                        <td class="border px-4 py-2 text-center font-bold">630
                        </td>
                        <td class="border px-4 py-2 text-center font-bold">590
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</section>

<!-- Kontak -->
<section class="py-12 bg-white dark:bg-gray-800 fade-in">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-2xl font-semibold mb-4">Kontak Kelurahan</h2>
        <p><strong>Alamat:</strong> Jl. Contoh No.123, Kalicari</p>
        <p><strong>Telepon:</strong> 0812-3456-7890</p>
        <p><strong>Email:</strong> kelurahan@example.com</p>
        <p><strong>Jam Layanan:</strong> Senin–Jumat, 08.00–15.00 WIB</p>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
            // Fade-in
            document.querySelectorAll('.fade-in').forEach(el => {
                el.classList.add('opacity-0', 'translate-y-4');
                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.remove('opacity-0', 'translate-y-4');
                            entry.target.classList.add('transition', 'duration-700', 'ease-out');
                        }
                    });
                });
                observer.observe(el);
            });

            // Chart
            new Chart(document.getElementById('rwChart'), {
                type: 'bar',
                data: {
                    labels: ['RW 01', 'RW 02', 'RW 03'],
                    datasets: [{
                        label: 'Jumlah Penduduk',
                        data: [120, 95, 140],
                        backgroundColor: '#DC2626'
                    }]
                }
            });

            new Chart(document.getElementById('genderChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Laki-laki', 'Perempuan'],
                    datasets: [{
                        data: [180, 175],
                        backgroundColor: ['#DC2626', '#fbbf24']
                    }]
                }
            });

            // CountUp
            const countPenduduk = new countUp.CountUp('countPenduduk', 355);
            const countKK = new countUp.CountUp('countKK', 125);
            const countRW = new countUp.CountUp('countRW', 3);
            countPenduduk.start();
            countKK.start();
            countRW.start();
        });
</script>
@endsection