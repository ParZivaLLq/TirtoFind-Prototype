<header class="h-16 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 sticky top-0 z-30 px-4 md:px-6 flex items-center justify-between transition-colors shadow-xs">
    <!-- Left: Brand / Page Title -->
    <div class="flex items-center gap-3 min-w-0">
        <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-white text-base">manage_search</span>
        </div>
        <div>
            <div class="text-sm font-bold text-slate-900 dark:text-white leading-tight">
                Selamat Datang, <span class="text-blue-600 dark:text-blue-400">Admin</span>
            </div>
            <div class="text-[10px] text-slate-400 leading-tight">TirtoFind — Terminal Tirtonadi</div>
        </div>
    </div>

    <!-- Right: Theme Toggle & Profile -->
    <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
        <!-- Theme Toggle -->
        <button @click="$store.theme.toggle()"
            class="p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors cursor-pointer"
            title="Ganti Tema">
            <span class="material-symbols-outlined text-xl" x-text="$store.theme.darkMode ? 'light_mode' : 'dark_mode'">dark_mode</span>
        </button>

        <!-- Divider -->
        <div class="w-px h-6 bg-slate-200 dark:bg-slate-700 mx-1"></div>

        <!-- User Profile Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="flex items-center gap-2.5 px-2 py-1.5 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors cursor-pointer">
                <div class="w-7 h-7 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold shrink-0">A</div>
                <div class="hidden sm:block text-left">
                    <div class="text-xs font-bold text-slate-900 dark:text-white leading-tight">Admin</div>
                    <div class="text-[10px] text-slate-400 leading-tight">Staff TirtoFind</div>
                </div>
                <span class="material-symbols-outlined text-sm text-slate-400">expand_more</span>
            </button>

            <div x-show="open"
                 @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 x-cloak
                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-800 py-1.5 z-50">
                <a href="{{ route('admin.profile.index') }}"
                    class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-base">person</span>
                    <span>Profil Saya</span>
                </a>
                <a href="{{ route('admin.settings.index') }}"
                    class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-base">settings</span>
                    <span>Pengaturan</span>
                </a>
                <div class="border-t border-slate-100 dark:border-slate-800 my-1"></div>
                <a href="{{ route('home') }}"
                    class="flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                    <span class="material-symbols-outlined text-base">logout</span>
                    <span>Keluar</span>
                </a>
            </div>
        </div>
    </div>
</header>
