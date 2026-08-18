<x-layouts.guest title="Kontak & Lokasi">
    <div class="max-w-[1280px] mx-auto px-4 md:px-6 py-8 md:py-12">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="px-3 py-1 bg-primary/10 text-primary text-xs font-semibold rounded-full uppercase tracking-wider">Pusat Layanan Pelanggan</span>
            <h1 class="text-3xl md:text-4xl font-bold text-on-background mt-3">Kontak & Lokasi Pos Informasi</h1>
            <p class="text-base text-on-surface-variant mt-2">
                Petugas layanan informasi Terminal Tirtonadi siap melayani pertanyaan dan verifikasi pengembalian barang temuan 24 jam setiap hari.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Contact Card 1 -->
            <div class="bg-white p-6 rounded-2xl border border-border-subtle soft-shadow flex flex-col items-center text-center hover:border-primary transition-all">
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-3xl">call</span>
                </div>
                <h3 class="font-bold text-lg text-on-background">Telepon & WhatsApp</h3>
                <p class="text-xs text-outline mt-1 mb-3">Layanan Cepat Tanggap 24/7</p>
                <div class="space-y-1 text-sm font-semibold text-primary">
                    <div>+62 271 716 356</div>
                    <div>+62 812 3456 7890 (WA Helpdesk)</div>
                </div>
            </div>

            <!-- Contact Card 2 -->
            <div class="bg-white p-6 rounded-2xl border border-border-subtle soft-shadow flex flex-col items-center text-center hover:border-primary transition-all">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-3xl">location_on</span>
                </div>
                <h3 class="font-bold text-lg text-on-background">Lokasi Pos Lost & Found</h3>
                <p class="text-xs text-outline mt-1 mb-3">Terminal Tirtonadi Surakarta</p>
                <p class="text-xs text-on-surface-variant leading-relaxed">
                    Gedung Utama Lantai 1 (Samping Ruang Informasi Utama), Jl. Ahmad Yani, Gilingan, Banjarsari, Kota Surakarta, Jawa Tengah 57134
                </p>
            </div>

            <!-- Contact Card 3 -->
            <div class="bg-white p-6 rounded-2xl border border-border-subtle soft-shadow flex flex-col items-center text-center hover:border-primary transition-all">
                <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-3xl">schedule</span>
                </div>
                <h3 class="font-bold text-lg text-on-background">Jam Operasional</h3>
                <p class="text-xs text-outline mt-1 mb-3">Setiap Hari Tanpa Libur</p>
                <div class="space-y-1 text-xs text-on-surface-variant font-medium">
                    <div>Pos Informasi: <span class="font-bold text-emerald-700">24 Jam Nonstop</span></div>
                    <div>Verifikasi Berita Acara: <span class="font-bold text-on-surface">08:00 - 20:00 WIB</span></div>
                </div>
            </div>
        </div>

        <!-- Interactive Map Mockup Section -->
        <div class="bg-white rounded-2xl border border-border-subtle overflow-hidden soft-shadow">
            <div class="p-4 bg-surface-container-low border-b border-border-subtle flex justify-between items-center">
                <h3 class="font-bold text-sm text-on-background flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">map</span>
                    <span>Peta Lokasi Terminal Tirtonadi Surakarta</span>
                </h3>
                <span class="text-xs text-outline">Google Maps Interactive Preview</span>
            </div>
            <div class="h-96 w-full bg-slate-100 relative flex items-center justify-center">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.244304882582!2d110.8164344!3d-7.5483259!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a168a3560b457%3A0xb007137f82798e4d!2sTerminal%20Tirtonadi!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" class="w-full h-full border-0" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</x-layouts.guest>
