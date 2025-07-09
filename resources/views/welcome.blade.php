<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Informasi Penduduk Kelurahan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-6xl mx-auto px-4 py-6 flex justify-between items-center">
            <div class="text-xl font-bold">Kelurahan Contoh</div>
            <a href="/admin/login" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Login</a>
        </div>
    </header>

    <!-- Hero -->
    <section class="bg-blue-50 py-16 text-center">
        <h1 class="text-4xl font-bold mb-4">Sistem Informasi Penduduk</h1>
        <p class="text-lg text-gray-600">Digitalisasi administrasi dan layanan masyarakat tingkat kelurahan</p>
    </section>

    <!-- Tentang -->
    <section class="max-w-4xl mx-auto px-4 py-12">
        <h2 class="text-2xl font-semibold mb-4">Tentang Aplikasi</h2>
        <p class="text-gray-700 leading-relaxed">
            Aplikasi ini membantu kelurahan dan ketua RW untuk mengelola data penduduk, mencatat peristiwa mutasi,
            serta memudahkan layanan surat menyurat secara online.
        </p>
    </section>

    <!-- Fitur -->
    <section class="bg-white py-12">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-semibold text-center mb-10">Fitur Utama</h2>
            <div class="grid md:grid-cols-3 gap-6 text-center">
                <div class="bg-blue-100 p-6 rounded shadow">
                    <h3 class="font-semibold text-lg mb-2">📄 Pengajuan Surat Online</h3>
                    <p class="text-gray-600">Ajukan surat tanpa harus datang ke kelurahan secara langsung.</p>
                </div>
                <div class="bg-blue-100 p-6 rounded shadow">
                    <h3 class="font-semibold text-lg mb-2">👪 Pendataan RT/RW</h3>
                    <p class="text-gray-600">Penduduk dikelompokkan rapi berdasarkan wilayah tempat tinggal.</p>
                </div>
                <div class="bg-blue-100 p-6 rounded shadow">
                    <h3 class="font-semibold text-lg mb-2">📊 Statistik Penduduk</h3>
                    <p class="text-gray-600">Lihat jumlah dan distribusi penduduk secara langsung dan akurat.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistik Penduduk -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-semibold text-center mb-8">Statistik Penduduk (Contoh Data)</h2>
            <div class="grid md:grid-cols-2 gap-8">

                <!-- Chart: RW -->
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-semibold text-center mb-2">Jumlah Penduduk per RW</h3>
                    <canvas id="rwChart" height="200"></canvas>
                </div>

                <!-- Chart: Jenis Kelamin -->
                <div class="bg-white p-4 rounded shadow">
                    <h3 class="font-semibold text-center mb-2">Komposisi Jenis Kelamin</h3>
                    <canvas id="genderChart" height="200"></canvas>
                </div>

            </div>
        </div>
    </section>

    <!-- Kontak -->
    <section class="py-12 bg-white">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-2xl font-semibold mb-4">Kontak Kelurahan</h2>
            <p><strong>Alamat:</strong> Jl. Contoh No.123, Kelurahan Contoh</p>
            <p><strong>Telepon:</strong> 0812-3456-7890</p>
            <p><strong>Email:</strong> kelurahan@example.com</p>
            <p><strong>Jam Layanan:</strong> Senin–Jumat, 08.00–15.00 WIB</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-6 text-gray-500 text-sm">
        &copy; {{ date('Y') }} Kelurahan Contoh. Semua Hak Dilindungi.
    </footer>

    <!-- Chart Scripts -->
    <script>
        // Dummy data RW
        const rwLabels = ['RW 01', 'RW 02', 'RW 03'];
        const rwData = [120, 95, 140];

        // Dummy data jenis kelamin
        const genderLabels = ['Laki-laki', 'Perempuan'];
        const genderData = [180, 175];

        // Chart RW
        new Chart(document.getElementById('rwChart'), {
            type: 'bar',
            data: {
                labels: rwLabels,
                datasets: [{
                    label: 'Jumlah Penduduk',
                    data: rwData,
                    backgroundColor: '#3b82f6'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Chart Gender
        new Chart(document.getElementById('genderChart'), {
            type: 'doughnut',
            data: {
                labels: genderLabels,
                datasets: [{
                    label: 'Jenis Kelamin',
                    data: genderData,
                    backgroundColor: ['#60a5fa', '#f472b6']
                }]
            },
            options: {
                responsive: true,
            }
        });
    </script>

</body>
</html>
