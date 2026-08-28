<x-layouts.guest title="Kontak & Lokasi">
    <div class="max-w-[1280px] mx-auto px-4 md:px-6 py-6 md:py-10">
        <div class="text-center max-w-xl mx-auto mb-10">
            <span class="px-2.5 py-0.5 bg-blue-100/80 text-blue-700 text-[11px] font-bold rounded-full uppercase tracking-wider border border-blue-200">Layanan Informasi</span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-2">Kontak & Lokasi Pos Pelayanan</h1>
            <p class="text-xs md:text-sm text-slate-600 mt-1">
                Petugas Pos Informasi Terminal Tirtonadi siap melayani 24 jam setiap hari.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Contact Card 1 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 soft-shadow flex flex-col items-center text-center hover:border-blue-600 transition-all">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-3.5 border border-blue-100">
                    <span class="material-symbols-outlined text-2xl">call</span>
                </div>
                <h3 class="font-bold text-base text-slate-900">Telepon & WhatsApp</h3>
                <p class="text-xs text-slate-500 mt-0.5 mb-3">Layanan Cepat Tanggap 24/7</p>
                <div class="space-y-1 text-xs md:text-sm font-semibold text-blue-600">
                    <div>+62 271 716 356</div>
                    <div>+62 812 3456 7890 (WA)</div>
                </div>
            </div>

            <!-- Contact Card 2 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 soft-shadow flex flex-col items-center text-center hover:border-blue-600 transition-all">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-3.5 border border-emerald-100">
                    <span class="material-symbols-outlined text-2xl">location_on</span>
                </div>
                <h3 class="font-bold text-base text-slate-900">Lokasi Pos Lost & Found</h3>
                <p class="text-xs text-slate-500 mt-0.5 mb-2">Terminal Tirtonadi Surakarta</p>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Gedung Utama Lantai 1 (samping Ruang Informasi Utama), Jl. Ahmad Yani, Surakarta.
                </p>
            </div>

            <!-- Contact Card 3 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 soft-shadow flex flex-col items-center text-center hover:border-blue-600 transition-all">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-3.5 border border-purple-100">
                    <span class="material-symbols-outlined text-2xl">schedule</span>
                </div>
                <h3 class="font-bold text-base text-slate-900">Jam Operasional</h3>
                <p class="text-xs text-slate-500 mt-0.5 mb-3">Setiap Hari Nonstop</p>
                <div class="space-y-1 text-xs text-slate-600 font-medium">
                    <div>Pos Informasi: <span class="font-bold text-emerald-700">24 Jam</span></div>
                    <div>Verifikasi Berita Acara: <span class="font-bold text-slate-900">08:00 - 20:00 WIB</span></div>
                </div>
            </div>
        </div>

        <!-- Interactive Map Section -->
        <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden soft-shadow">
            <div class="p-3.5 bg-slate-50 border-b border-slate-200/80 flex justify-between items-center">
                <h3 class="font-bold text-xs md:text-sm text-slate-900 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-blue-600 text-base">map</span>
                    <span>Peta Lokasi Terminal Tirtonadi Surakarta</span>
                </h3>
                <span class="text-[11px] text-slate-400 font-medium">Google Maps</span>
            </div>
            <div class="h-80 w-full bg-slate-100 relative flex items-center justify-center">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.244304882582!2d110.8164344!3d-7.5483259!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a168a3560b457%3A0xb007137f82798e4d!2sTerminal%20Tirtonadi!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" class="w-full h-full border-0" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</x-layouts.guest>
