<footer class="w-full py-8 px-4 mt-auto flex flex-col items-center gap-3 bg-slate-900 dark:bg-slate-950 text-slate-100 border-t border-slate-800 dark:border-slate-800">
    <div class="flex items-center gap-2 text-lg font-bold text-white">
        <div class="w-7 h-7 rounded-lg bg-blue-600 flex items-center justify-center text-white shadow-xs">
            <span class="material-symbols-outlined text-lg">location_searching</span>
        </div>
        <span>Tirto<span class="text-blue-400">Find</span></span>
    </div>
    <div class="flex flex-wrap justify-center gap-5 text-xs text-slate-400">
        <a class="hover:text-white transition-colors" href="{{ route('about') }}">Tentang Kami</a>
        <a class="hover:text-white transition-colors" href="{{ route('found-items') }}">Barang Temuan</a>
        <a class="hover:text-white transition-colors" href="{{ route('lost-report') }}">Lapor Kehilangan</a>
        <a class="hover:text-white transition-colors" href="{{ route('claim.tracking') }}">Lacak Klaim</a>
        <a class="hover:text-white transition-colors" href="{{ route('contact') }}">Kontak & Pos</a>
        <a class="hover:text-white transition-colors" href="https://hubdat.dephub.go.id" target="_blank" rel="noopener">Kemenhub RI</a>
    </div>
    <div class="flex flex-col items-center gap-1.5 text-[11px] text-slate-500 mt-1 text-center">
        <div>© {{ date('Y') }} Kementerian Perhubungan RI — Terminal Tipe A Tirtonadi Surakarta.</div>
        <div class="pt-2 border-t border-slate-800/60 w-full max-w-xs text-center">
            <a href="{{ route('login') }}" class="text-[11px] text-slate-400 hover:text-blue-400 transition-colors flex items-center justify-center gap-1">
                <span class="material-symbols-outlined text-sm">admin_panel_settings</span>
                <span>Portal Login Petugas Admin</span>
            </a>
        </div>
    </div>
</footer>
