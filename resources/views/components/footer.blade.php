<footer class="w-full py-12 px-6 mt-auto flex flex-col items-center gap-4 bg-slate-900 text-slate-100 border-t border-slate-800">
    <div class="flex items-center gap-2 text-xl font-bold text-white">
        <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white">
            <span class="material-symbols-outlined text-xl">location_searching</span>
        </div>
        <span>Tirto<span class="text-blue-400">Find</span></span>
    </div>
    <div class="flex flex-wrap justify-center gap-6 text-xs md:text-sm text-slate-400">
        <a class="hover:text-white transition-colors" href="{{ route('about') }}">Tentang Sistem</a>
        <a class="hover:text-white transition-colors" href="{{ route('found-items') }}">Galeri Barang Temuan</a>
        <a class="hover:text-white transition-colors" href="{{ route('lost-report') }}">Lapor Kehilangan</a>
        <a class="hover:text-white transition-colors" href="{{ route('contact') }}">Kontak & Pos Informasi</a>
        <a class="hover:text-white transition-colors" href="https://hubdat.dephub.go.id" target="_blank" rel="noopener">Portal Kemenhub</a>
    </div>
    <div class="flex flex-col items-center gap-2 text-xs text-slate-500 mt-2 text-center">
        <div>© {{ date('Y') }} Kementerian Perhubungan RI — Terminal Tipe A Tirtonadi Surakarta. Hak Cipta Dilindungi.</div>
        <div class="pt-2 border-t border-slate-800/60 w-full max-w-xs text-center">
            <a href="{{ route('login') }}" class="text-[11px] text-slate-400 hover:text-blue-400 transition-colors flex items-center justify-center gap-1">
                <span class="material-symbols-outlined text-sm">admin_panel_settings</span>
                <span>Portal Login Petugas Admin</span>
            </a>
        </div>
    </div>
</footer>
