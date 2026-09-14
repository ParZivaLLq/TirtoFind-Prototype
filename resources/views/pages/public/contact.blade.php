<x-layouts.guest title="Kontak & Lokasi">
    <div class="max-w-[1280px] mx-auto px-4 md:px-6 py-6 md:py-10">
        <!-- Header -->
        <div class="text-center max-w-xl mx-auto mb-10">
            <span class="px-2.5 py-0.5 bg-blue-100/80 text-blue-700 text-[11px] font-bold rounded-full uppercase tracking-wider border border-blue-200">Layanan Informasi</span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-2">Kontak & Lokasi Pos Pelayanan</h1>
            <p class="text-xs md:text-sm text-slate-600 mt-1">
                Petugas Pos Informasi & Lost Found Terminal Tirtonadi siap melayani Anda 24 jam setiap hari.
            </p>
        </div>

        <!-- 4 Grid Contact Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <!-- Contact Card 1: Telepon & WA -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 soft-shadow flex flex-col items-center text-center hover:border-blue-600 transition-all group">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-3.5 border border-blue-100 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-2xl">call</span>
                </div>
                <h3 class="font-bold text-base text-slate-900">Telepon & WhatsApp</h3>
                <p class="text-xs text-slate-500 mt-0.5 mb-3">Layanan Helpdesk 24/7</p>
                <div class="space-y-1.5 text-xs md:text-sm font-semibold text-blue-600 w-full">
                    <a href="tel:+62271716356" class="block p-2 bg-slate-50 hover:bg-blue-50 rounded-xl text-slate-700 hover:text-blue-700 border border-slate-200/60 transition-colors">
                        +62 271 716 356 (Kantor)
                    </a>
                    <a href="https://wa.me/6281234567890?text=Halo%20CS%20TirtoFind%20Terminal%20Tirtonadi" target="_blank" rel="noopener noreferrer" class="block p-2 bg-emerald-50 hover:bg-emerald-100 rounded-xl text-emerald-700 font-bold border border-emerald-200/60 transition-colors flex items-center justify-center gap-1.5">
                        <span class="material-symbols-outlined text-base">chat</span>
                        <span>+62 812 3456 7890 (WA)</span>
                    </a>
                </div>
            </div>

            <!-- Contact Card 2: Lokasi Pos -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 soft-shadow flex flex-col items-center text-center hover:border-blue-600 transition-all group">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-3.5 border border-emerald-100 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-2xl">location_on</span>
                </div>
                <h3 class="font-bold text-base text-slate-900">Lokasi Pos Lost & Found</h3>
                <p class="text-xs text-slate-500 mt-0.5 mb-2">Terminal Tirtonadi Surakarta</p>
                <p class="text-xs text-slate-600 leading-relaxed mb-4">
                    Gedung Utama Lantai 1 (samping Ruang Informasi Utama), Jl. Ahmad Yani, Gilingan, Banjarsari, Surakarta.
                </p>
                <a href="https://maps.google.com/?q=Terminal+Tirtonadi+Surakarta" target="_blank" rel="noopener noreferrer" class="mt-auto px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-xs transition-colors flex items-center gap-1">
                    <span>Petunjuk Arah</span>
                    <span class="material-symbols-outlined text-xs">open_in_new</span>
                </a>
            </div>

            <!-- Contact Card 3: Jam Operasional -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 soft-shadow flex flex-col items-center text-center hover:border-blue-600 transition-all group">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-3.5 border border-purple-100 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-2xl">schedule</span>
                </div>
                <h3 class="font-bold text-base text-slate-900">Jam Operasional</h3>
                <p class="text-xs text-slate-500 mt-0.5 mb-3">Setiap Hari Nonstop</p>
                <div class="space-y-2 text-xs text-slate-600 font-medium w-full">
                    <div class="p-2 bg-slate-50 rounded-xl border border-slate-200/60">
                        <span class="text-slate-500 block text-[10px]">Pos Informasi Utama</span>
                        <span class="font-bold text-emerald-700">24 Jam (Setiap Hari)</span>
                    </div>
                    <div class="p-2 bg-slate-50 rounded-xl border border-slate-200/60">
                        <span class="text-slate-500 block text-[10px]">Verifikasi Berita Acara (BA)</span>
                        <span class="font-bold text-slate-900">08:00 - 20:00 WIB</span>
                    </div>
                </div>
            </div>

            <!-- Contact Card 4: Instagram -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 soft-shadow flex flex-col items-center text-center hover:border-pink-500 transition-all group">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3.5 group-hover:scale-110 transition-transform shadow-sm" style="background-color: #fce7f3; border: 1px solid #fbcfe8;">
                    <svg class="w-6 h-6" viewBox="0 0 24 24">
                        <defs>
                            <linearGradient id="ig-contact-gradient" x1="100%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#833ab4" />
                                <stop offset="50%" stop-color="#fd1d1d" />
                                <stop offset="100%" stop-color="#fcb045" />
                            </linearGradient>
                        </defs>
                        <path fill="url(#ig-contact-gradient)" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.266.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1 1 12.324 0 6.162 6.162 0 0 1-12.324 0zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm4.965-10.322a1.44 1.44 0 1 1 2.881.001 1.44 1.44 0 0 1-2.881-.001z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-base text-slate-900">Instagram Resmi</h3>
                <p class="text-xs text-slate-500 mt-0.5 mb-3">Update & Pengumuman</p>
                <a href="https://www.instagram.com/tirtonadi.terminal" target="_blank" rel="noopener noreferrer" class="text-xs font-bold transition-colors inline-flex items-center gap-1 mb-2 hover:opacity-80" style="color: #e1306c;">
                    <span>@tirtonadi.terminal</span>
                    <span class="material-symbols-outlined text-xs">open_in_new</span>
                </a>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    Dapatkan informasi terbaru mengenai layanan bus, fasilitas terminal, dan pengumuman penemuan barang.
                </p>
            </div>
        </div>

        <!-- Interactive Map Section -->
        <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden soft-shadow mb-10">
            <div class="p-4 bg-slate-50 border-b border-slate-200/80 flex justify-between items-center">
                <h3 class="font-bold text-xs md:text-sm text-slate-900 flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600 text-base">map</span>
                    <span>Peta Lokasi Pos Lost & Found — Terminal Tirtonadi Surakarta</span>
                </h3>
                <span class="text-[11px] text-slate-400 font-medium">Google Maps</span>
            </div>
            <div class="h-80 w-full bg-slate-100 relative">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.244304882582!2d110.8164344!3d-7.5483259!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a168a3560b457%3A0xb007137f82798e4d!2sTerminal%20Tirtonadi!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" class="w-full h-full border-0" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="bg-slate-50 rounded-2xl border border-slate-200/80 p-6 md:p-8 soft-shadow">
            <div class="text-center max-w-xl mx-auto mb-6">
                <h2 class="text-lg md:text-xl font-extrabold text-slate-900">Pertanyaan Sering Diajukan (FAQ)</h2>
                <p class="text-xs text-slate-500 mt-1">Panduan umum proses klaim dan verifikasi barang temuan di Pos Lost & Found.</p>
            </div>

            <div class="max-w-3xl mx-auto space-y-3">
                <details class="bg-white rounded-xl border border-slate-200/80 p-4 [&_summary::-webkit-details-marker]:hidden group">
                    <summary class="flex items-center justify-between font-bold text-xs md:text-sm text-slate-900 cursor-pointer">
                        <span>Apa saja syarat untuk mengambil barang temuan yang sudah disetujui?</span>
                        <span class="material-symbols-outlined text-slate-400 group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <p class="text-xs text-slate-600 mt-2.5 leading-relaxed">
                        Anda wajib membawa Kartu Identitas Asli (KTP/SIM/Paspor) yang sesuai dengan nama pada permohonan klaim, serta menunjukkan Kode Tiket Klaim (`#CL-YYYY-XXXX`). Untuk barang elektronik, pastikan Anda bisa membuktikan PIN/Password/IMEI jika diminta.
                    </p>
                </details>

                <details class="bg-white rounded-xl border border-slate-200/80 p-4 [&_summary::-webkit-details-marker]:hidden group">
                    <summary class="flex items-center justify-between font-bold text-xs md:text-sm text-slate-900 cursor-pointer">
                        <span>Berapa lama proses verifikasi pengajuan klaim dilakukan?</span>
                        <span class="material-symbols-outlined text-slate-400 group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <p class="text-xs text-slate-600 mt-2.5 leading-relaxed">
                        Tim verifikator kami memproses permohonan klaim dalam waktu 1x24 jam. Anda dapat memantau status secara langsung melalui menu **Lacak Status Klaim** menggunakan kode tiket Anda.
                    </p>
                </details>

                <details class="bg-white rounded-xl border border-slate-200/80 p-4 [&_summary::-webkit-details-marker]:hidden group">
                    <summary class="flex items-center justify-between font-bold text-xs md:text-sm text-slate-900 cursor-pointer">
                        <span>Bisakah pengambilan barang diwakilkan oleh orang lain?</span>
                        <span class="material-symbols-outlined text-slate-400 group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <p class="text-xs text-slate-600 mt-2.5 leading-relaxed">
                        Bisa. Perwakilan wajib membawa Surat Kuasa bermaterai 10.000 yang ditandatangani pemilik sah, membawa KTP Asli pemilik, serta KTP Asli penerima kuasa.
                    </p>
                </details>
            </div>
        </div>
    </div>
</x-layouts.guest>
