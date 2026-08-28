<header x-data="{ mobileMenuOpen: false }"
        class="sticky top-0 w-full z-50 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 h-16 transition-colors duration-300 shadow-xs">
    <div class="max-w-[1280px] mx-auto px-4 md:px-6 h-full flex justify-between items-center">
        <!-- Brand Logo & Main Nav -->
        <div class="flex items-center gap-6 md:gap-10">
            <a href="{{ route('home') }}" class="text-xl font-bold text-blue-700 flex items-center gap-2 hover:opacity-90 transition-opacity">
                <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-2xl">location_searching</span>
                </div>
                <div class="flex flex-col leading-none">
                    <span class="text-lg font-extrabold tracking-tight text-slate-900 dark:text-white">Tirto<span class="text-blue-600">Find</span></span>
                    <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Terminal Tirtonadi</span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex gap-5 items-center">
                <a href="{{ route('found-items') }}" class="text-xs md:text-sm font-semibold {{ request()->routeIs('found-items*') ? 'text-blue-600' : 'text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }} transition-colors">
                    Barang Temuan
                </a>
                <a href="{{ route('lost-report') }}" class="text-xs md:text-sm font-semibold {{ request()->routeIs('lost-report*') ? 'text-blue-600' : 'text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }} transition-colors">
                    Lapor Kehilangan
                </a>
                <a href="{{ route('claim.tracking') }}" class="text-xs md:text-sm font-semibold {{ request()->routeIs('claim.tracking*') ? 'text-blue-600' : 'text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }} transition-colors">
                    Lacak Klaim
                </a>
                <a href="{{ route('search') }}" class="text-xs md:text-sm font-semibold {{ request()->routeIs('search*') ? 'text-blue-600' : 'text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }} transition-colors">
                    Cari Barang
                </a>
                <a href="{{ route('about') }}" class="text-xs md:text-sm font-semibold {{ request()->routeIs('about*') ? 'text-blue-600' : 'text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }} transition-colors">
                    Tentang Kami
                </a>
                <a href="{{ route('contact') }}" class="text-xs md:text-sm font-semibold {{ request()->routeIs('contact*') ? 'text-blue-600' : 'text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400' }} transition-colors">
                    Kontak & Pos
                </a>
            </nav>
        </div>

        <!-- Right Side: Theme Toggle + Mobile Menu Toggle -->
        <div class="flex items-center gap-2">
            <!-- Dark Mode Toggle -->
            <button @click="$store.theme.toggle()"
                    class="p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer"
                    title="Ganti Tema">
                <span class="material-symbols-outlined text-xl"
                      x-text="$store.theme.darkMode ? 'light_mode' : 'dark_mode'">dark_mode</span>
            </button>

            <!-- Mobile Menu Toggle -->
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="md:hidden p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors cursor-pointer">
                <span class="material-symbols-outlined" x-text="mobileMenuOpen ? 'close' : 'menu'">menu</span>
            </button>
        </div>
    </div>

    <!-- Mobile Dropdown Menu -->
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         @click.outside="mobileMenuOpen = false"
         x-cloak
         class="md:hidden bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-4 py-3 space-y-1 shadow-lg">
        <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('home') ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-700' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
            Beranda
        </a>
        <a href="{{ route('found-items') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('found-items*') ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-700' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
            Barang Temuan
        </a>
        <a href="{{ route('lost-report') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('lost-report*') ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-700' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
            Lapor Kehilangan
        </a>
        <a href="{{ route('claim.tracking') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('claim.tracking*') ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-700' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
            Lacak Klaim
        </a>
        <a href="{{ route('search') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('search*') ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-700' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
            Cari Barang
        </a>
        <a href="{{ route('about') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('about*') ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-700' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
            Tentang Kami
        </a>
        <a href="{{ route('contact') }}" class="block px-3 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('contact*') ? 'bg-blue-50 dark:bg-blue-950/60 text-blue-700' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
            Kontak Pos Informasi
        </a>
    </div>
</header>
