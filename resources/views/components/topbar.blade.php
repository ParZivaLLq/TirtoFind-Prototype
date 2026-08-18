<header class="h-16 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 sticky top-0 z-30 px-4 md:px-6 flex items-center justify-between transition-colors shadow-xs">
    <!-- Left Section: Mobile Hamburger Toggle, Title & Search Bar -->
    <div class="flex items-center gap-3 md:gap-6 flex-1 min-w-0">
        <!-- Sidebar Toggle Button (Mobile & Desktop) -->
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors flex-shrink-0 cursor-pointer" title="Toggle Sidebar">
            <span class="material-symbols-outlined text-xl">menu</span>
        </button>

        <!-- Brand / Page Greeting -->
        <div class="flex items-center gap-2 min-w-0">
            <h2 class="text-sm md:text-base font-bold text-slate-900 dark:text-white truncate">
                @php
                    $hour = date('H');
                    $greeting = $hour < 12 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
                @endphp
                {{ $greeting }}, <span class="text-blue-600 dark:text-blue-400">Admin</span>
            </h2>
        </div>

        <!-- Search Bar matching design -->
        <div class="relative hidden md:block w-72 lg:w-80 ml-2">
            <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-lg">search</span>
            <input type="text" placeholder="Search items, reports, or users (Cmd+K)" class="w-full pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-slate-100 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all">
        </div>
    </div>

    <!-- Right Section: Actions, Theme Switcher, Notifications, Profile Dropdown -->
    <div class="flex items-center gap-1.5 sm:gap-3 flex-shrink-0">
        <!-- Theme Toggle Button -->
        <button @click="$store.theme.toggle()" class="p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors relative cursor-pointer" title="Ganti Tema (Gelap / Terang)">
            <span class="material-symbols-outlined text-xl" x-text="$store.theme.darkMode ? 'light_mode' : 'dark_mode'">dark_mode</span>
        </button>

        <!-- Notification Bell & Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl relative transition-colors cursor-pointer" title="Notifikasi">
                <span class="material-symbols-outlined text-xl">notifications</span>
                <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white dark:ring-slate-900"></span>
            </button>

            <!-- Notifications Dropdown Menu -->
            <div x-show="open" 
                 @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-80 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-800 py-2 z-50">
                <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                    <span class="font-bold text-xs text-slate-900 dark:text-white">Notifikasi Petugas</span>
                    <span class="text-[11px] text-blue-600 dark:text-blue-400 font-semibold cursor-pointer hover:underline">Tandai Dibaca</span>
                </div>
                <div class="max-h-64 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-800">
                    <a href="{{ route('admin.claims.index') }}" class="p-3 block hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <div class="text-xs font-bold text-blue-600 dark:text-blue-400">Pengajuan Klaim Baru</div>
                        <div class="text-xs text-slate-600 dark:text-slate-300 mt-0.5">Budi Santoso mengajukan klaim Dompet Imperial Horse</div>
                        <div class="text-[10px] text-slate-400 mt-1">5 menit yang lalu</div>
                    </a>
                    <a href="{{ route('admin.ai-matching.index') }}" class="p-3 block hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <div class="text-xs font-bold text-emerald-600 dark:text-emerald-400">AI Match 98% Terdeteksi</div>
                        <div class="text-xs text-slate-600 dark:text-slate-300 mt-0.5">Laporan #REP-9902 cocok dengan #TF-8912</div>
                        <div class="text-[10px] text-slate-400 mt-1">12 menit yang lalu</div>
                    </a>
                </div>
            </div>
        </div>

        <!-- History Icon -->
        <a href="{{ route('admin.analytics.index') }}" class="p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors" title="Riwayat & Analitik">
            <span class="material-symbols-outlined text-xl">history</span>
        </a>

        <!-- User Profile Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center gap-2.5 p-1 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors cursor-pointer">
                <img class="w-8 h-8 rounded-full object-cover border border-blue-500/40 shadow-xs" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150" alt="Officer Handoko">
                <span class="hidden lg:block text-xs font-bold text-slate-900 dark:text-white">Officer Handoko</span>
                <span class="material-symbols-outlined text-sm text-slate-400">expand_more</span>
            </button>

            <!-- Profile Menu Dropdown -->
            <div x-show="open" 
                 @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-52 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-800 py-1.5 z-50">
                <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-800">
                    <div class="text-xs font-bold text-slate-900 dark:text-white">Officer Handoko</div>
                    <div class="text-[10px] text-slate-400">admin@tirtofind.go.id</div>
                </div>
                <a href="{{ route('admin.profile.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-base">person</span>
                    <span>Profil Saya</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-base">settings</span>
                    <span>Pengaturan Tema</span>
                </a>
                <div class="border-t border-slate-100 dark:border-slate-800 my-1"></div>
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                    <span class="material-symbols-outlined text-base">logout</span>
                    <span>Keluar Sistem</span>
                </a>
            </div>
        </div>
    </div>
</header>
