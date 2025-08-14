<!DOCTYPE html>
<html lang="id" class="scroll-smooth"
    x-data="{ dark: window.matchMedia('(prefers-color-scheme: dark)').matches }"
    x-bind:class="{ 'dark': dark }"
    x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
    x-cloak>

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'ESKEPAL') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: '#DC2626',
                    }
                }
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
        defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/countup.js@2.6.2/dist/countUp.umd.js">
    </script>
</head>

<body
    class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300">

    <!-- Navbar -->
    <header class="bg-white dark:bg-gray-800 shadow">
        <div
            class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo-icon.svg') }}" alt="Logo"
                    class="w-10 h-10">
                <span
                    class="text-xl font-bold text-brand dark:text-brand">ESKEPAL</span>
            </div>
            <div class="flex items-center space-x-4">
                <button id="darkToggle"
                    class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-transform duration-500 ease-in-out transform active:scale-90">
                    <!-- Icon Sun -->
                    <svg id="iconLight"
                        class="w-5 h-5 hidden dark:block transition-transform duration-500 ease-in-out"
                        xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 3v1m0 16v1m8.66-12.34l-.71.7M4.05 19.95l.7-.7M21 12h1M3 12H2m16.95 7.95l-.7-.7M4.05 4.05l.7.7M12 5a7 7 0 100 14 7 7 0 000-14z" />
                    </svg>
                    <!-- Icon Moon -->
                    <svg id="iconDark"
                        class="w-5 h-5 block dark:hidden transition-transform duration-500 ease-in-out"
                        xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                    </svg>
                </button>

                <a href="/admin/login"
                    class="bg-brand text-white px-4 py-2 rounded hover:bg-red-700">Login</a>
            </div>
        </div>
    </header>


    <!-- Main -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center py-6 text-gray-500 dark:text-gray-400 text-sm">
        &copy; {{ date('Y') }} ESKEPAL - Elektronik Sistem Kependudukan
        Kalicari.
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('darkToggle');
        const iconLight = document.getElementById('iconLight');
        const iconDark = document.getElementById('iconDark');

        toggle.addEventListener('click', () => {
            // Animasi hanya icon yang aktif
            const activeIcon = document.documentElement.classList.contains('dark') ? iconLight : iconDark;
            activeIcon.classList.add('transform', 'rotate-180', 'scale-125');
            setTimeout(() => {
                activeIcon.classList.remove('rotate-180', 'scale-125');
            }, 400);

            // Delay pergantian mode agar animasi terlihat smooth
            setTimeout(() => {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.theme = 'light';
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.theme = 'dark';
                }
            }, 100);
        });

        // Inisialisasi dark mode sesuai preferensi
        if (localStorage.theme === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    });
    </script>

</body>

</html>