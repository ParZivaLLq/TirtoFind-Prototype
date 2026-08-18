<header x-data="{ mobileMenuOpen: false }" class="sticky top-0 w-full z-50 bg-white/95 backdrop-blur-md border-b border-slate-200 h-16 transition-all duration-200 shadow-xs">
    <div class="max-w-[1280px] mx-auto px-4 md:px-6 h-full flex justify-between items-center">
        <!-- Brand Logo & Main Nav -->
        <div class="flex items-center gap-8 md:gap-12">
            <a href="{{ route('home') }}" class="text-xl font-bold text-blue-700 flex items-center gap-2 hover:opacity-90 transition-opacity">
                <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-2xl">location_searching</span>
                </div>
                <div class="flex flex-col leading-none">
                    <span class="text-lg font-extrabold tracking-tight text-slate-900">Tirto<span class="text-blue-600">Find</span></span>
                    <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Terminal Tirtonadi</span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden md:flex gap-6 items-center">
                <a href="{{ route('found-items') }}" class="text-sm font-medium {{ request()->routeIs('found-items*') ? 'nav-active' : 'text-slate-600 hover:text-blue-600' }} transition-colors">
                    Barang Temuan
                </a>
                <a href="{{ route('lost-report') }}" class="text-sm font-medium {{ request()->routeIs('lost-report*') ? 'nav-active' : 'text-slate-600 hover:text-blue-600' }} transition-colors">
                    Lapor Kehilangan
                </a>
                <a href="{{ route('search') }}" class="text-sm font-medium {{ request()->routeIs('search*') ? 'nav-active' : 'text-slate-600 hover:text-blue-600' }} transition-colors">
                    Cari Barang
                </a>
                <a href="{{ route('about') }}" class="text-sm font-medium {{ request()->routeIs('about*') ? 'nav-active' : 'text-slate-600 hover:text-blue-600' }} transition-colors">
                    Tentang Kami
                </a>
                <a href="{{ route('contact') }}" class="text-sm font-medium {{ request()->routeIs('contact*') ? 'nav-active' : 'text-slate-600 hover:text-blue-600' }} transition-colors">
                    Kontak & Pos
                </a>
            </nav>
        </div>

        <!-- Right Side: Mobile Menu Toggle -->
        <div class="flex items-center gap-3">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
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
         class="md:hidden bg-white border-b border-slate-200 px-4 py-4 space-y-2 shadow-lg">
        <a href="{{ route('home') }}" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
            Beranda
        </a>
        <a href="{{ route('found-items') }}" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('found-items*') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
            Galeri Barang Temuan
        </a>
        <a href="{{ route('lost-report') }}" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('lost-report*') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
            Buat Laporan Kehilangan
        </a>
        <a href="{{ route('search') }}" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('search*') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
            Pencocokan & Cari Barang
        </a>
        <a href="{{ route('about') }}" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('about*') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
            Tentang TirtoFind
        </a>
        <a href="{{ route('contact') }}" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('contact*') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
            Kontak Pos Informasi
        </a>
    </div>
</header>
