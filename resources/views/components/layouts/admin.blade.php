<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ $title ?? 'Admin Console' }} | TirtoFind Staff</title>
    
    <!-- Google Fonts Inter & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- Inline Theme Initializer -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('admin_theme');
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <!-- Alpine.js Global Theme Store -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                darkMode: localStorage.getItem('admin_theme') === 'dark',
                toggle() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('admin_theme', this.darkMode ? 'dark' : 'light');
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                },
                setLight() {
                    this.darkMode = false;
                    localStorage.setItem('admin_theme', 'light');
                    document.documentElement.classList.remove('dark');
                },
                setDark() {
                    this.darkMode = true;
                    localStorage.setItem('admin_theme', 'dark');
                    document.documentElement.classList.add('dark');
                }
            });
        });
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ sidebarOpen: true }" class="font-sans antialiased bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-full flex transition-colors duration-200">
    
    <!-- Admin Sidebar -->
    <x-sidebar />

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/50 z-30 lg:hidden"></div>

    <!-- Main Content Container -->
    <div class="flex-1 flex flex-col min-w-0 lg:pl-64 transition-all duration-300">
        <!-- Topbar -->
        <x-topbar :title="$title ?? 'Admin Console'" />

        <!-- Main Workspace Area -->
        <main class="flex-1 p-4 md:p-6 lg:p-8 max-w-[1280px] mx-auto w-full space-y-6">
            {{ $slot }}
        </main>

        <!-- Admin Footer -->
        <footer class="py-6 px-8 border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-center text-xs text-slate-500 dark:text-slate-400">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-2 max-w-[1280px] mx-auto">
                <div>© {{ date('Y') }} Kementerian Perhubungan RI — Terminal Tirtonadi. Hak Cipta Dilindungi.</div>
                <div class="flex items-center gap-4 text-xs font-semibold">
                    <a href="{{ route('about') }}" target="_blank" class="hover:text-blue-600">Tentang</a>
                    <a href="{{ route('contact') }}" target="_blank" class="hover:text-blue-600">Bantuan Support</a>
                    <a href="https://hubdat.dephub.go.id" target="_blank" class="hover:text-blue-600">Portal Kemenhub</a>
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
