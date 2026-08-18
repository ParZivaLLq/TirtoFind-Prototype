<x-layouts.guest title="Beranda Utama">
    <!-- Hero Section -->
    <section class="relative pt-12 pb-20 md:pt-16 md:pb-24 overflow-hidden bg-gradient-to-b from-blue-50/70 via-slate-50/50 to-white">
        <div class="max-w-[1280px] mx-auto px-4 md:px-6 text-center relative z-10">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-100/80 text-blue-700 text-xs font-semibold mb-6 border border-blue-200 shadow-xs">
                <span class="material-symbols-outlined text-sm text-blue-600">auto_awesome</span>
                <span>Sistem Pengelolaan Barang Hilang Berbasis AI - Terminal Tirtonadi</span>
            </div>

            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight text-slate-900 max-w-4xl mx-auto leading-tight mb-6">
                Menghubungkan Kembali Barang Hilang Anda
            </h1>
            <p class="text-base md:text-lg text-slate-600 max-w-2xl mx-auto mb-10 leading-relaxed font-normal">
                TirtoFind menggunakan kecerdasan buatan (Vision AI) untuk membantu Anda menemukan barang yang tertinggal di Terminal Tirtonadi Surakarta secara cepat, tepat, dan aman.
            </p>

            <!-- Search Bar -->
            <form action="{{ route('found-items') }}" method="GET" class="max-w-2xl mx-auto bg-white p-2 rounded-2xl soft-shadow border border-slate-200 flex items-center gap-2 focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-600 transition-all">
                <span class="material-symbols-outlined ml-3 text-slate-400 text-2xl">search</span>
                <input class="flex-grow border-none focus:outline-none focus:ring-0 text-sm md:text-base px-2 py-2 text-slate-900 placeholder:text-slate-400 bg-transparent" placeholder="Cari barang hilang Anda (contoh: Dompet Kulit Hitam, HP Samsung)..." type="text" name="q"/>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all shadow-sm flex items-center gap-2">
                    <span>Cari Barang</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </form>

            <!-- Popular Search Tags -->
            <div class="mt-5 text-xs md:text-sm text-slate-500 flex flex-wrap justify-center items-center gap-2">
                <span class="font-medium">Pencarian Populer:</span>
                <a href="{{ route('found-items', ['q' => 'Dompet']) }}" class="px-3 py-1 bg-slate-100 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors">Dompet Kulit</a>
                <a href="{{ route('found-items', ['q' => 'Samsung']) }}" class="px-3 py-1 bg-slate-100 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors">HP Samsung</a>
                <a href="{{ route('found-items', ['q' => 'Backpack']) }}" class="px-3 py-1 bg-slate-100 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors">Tas Ransel Eiger</a>
                <a href="{{ route('found-items', ['q' => 'Kunci']) }}" class="px-3 py-1 bg-slate-100 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors">Kunci Mobil Toyota</a>
            </div>
        </div>

        <!-- Background Atmospheric Decoration -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-200/30 rounded-full blur-3xl -z-10"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-slate-200/40 rounded-full blur-3xl -z-10"></div>
    </section>

    <!-- Statistics Section -->
    <section class="bg-slate-50 py-12 md:py-16 border-y border-slate-200">
        <div class="max-w-[1280px] mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat 1 -->
                <div class="bg-white p-6 md:p-8 rounded-2xl soft-shadow border border-slate-200 text-center hover:border-blue-500/40 transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4 border border-emerald-100">
                        <span class="material-symbols-outlined text-2xl">inventory_2</span>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Barang Temuan</p>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">4.821</h2>
                    <span class="text-xs text-emerald-600 font-semibold mt-2 inline-block">+12 barang ditambahkan hari ini</span>
                </div>

                <!-- Stat 2 -->
                <div class="bg-white p-6 md:p-8 rounded-2xl soft-shadow border border-slate-200 text-center hover:border-blue-500/40 transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4 border border-blue-100">
                        <span class="material-symbols-outlined text-2xl">verified</span>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Barang Dikembalikan</p>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-blue-600">3.942</h2>
                    <span class="text-xs text-blue-600 font-semibold mt-2 inline-block">81.7% Tingkat Pengembalian</span>
                </div>

                <!-- Stat 3 -->
                <div class="bg-white p-6 md:p-8 rounded-2xl soft-shadow border border-slate-200 text-center hover:border-blue-500/40 transition-all">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-4 border border-amber-100">
                        <span class="material-symbols-outlined text-2xl">report_problem</span>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Laporan Kehilangan</p>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">1.248</h2>
                    <span class="text-xs text-amber-600 font-semibold mt-2 inline-block">Proses Matching AI Aktif</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Found Items -->
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-[1280px] mx-auto px-4 md:px-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-10 gap-4">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900">Barang Temuan Terbaru</h2>
                    <p class="text-sm md:text-base text-slate-500 mt-1">Barang yang baru diserahkan ke Pos Informasi Terminal Tirtonadi</p>
                </div>
                <a class="text-blue-600 font-bold text-sm flex items-center gap-1 hover:gap-2 transition-all" href="{{ route('found-items') }}">
                    <span>Lihat Semua Galeri</span>
                    <span class="material-symbols-outlined text-lg">arrow_forward</span>
                </a>
            </div>

            <!-- Items Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <a href="{{ route('item-detail', 1) }}" class="bg-white border border-slate-200 rounded-2xl overflow-hidden soft-shadow group hover:border-blue-600 hover:shadow-lg transition-all duration-300">
                    <div class="h-48 overflow-hidden bg-slate-100 relative">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1627123424574-724758594e93?w=600" alt="Dompet Kulit Hitam"/>
                        <span class="absolute top-3 right-3 bg-emerald-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-xs flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                            <span>Barang Ditemukan</span>
                        </span>
                    </div>
                    <div class="p-5">
                        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Tas & Dompet</span>
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors mt-0.5">Dompet Kulit Pria Imperial Horse</h3>
                        <div class="mt-3 space-y-1.5 text-xs text-slate-500">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base text-slate-400">calendar_today</span>
                                <span>24 Oktober 2024 (14:30 WIB)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base text-slate-400">location_on</span>
                                <span>Platform 4 Bus Intercity</span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 2 -->
                <a href="{{ route('item-detail', 2) }}" class="bg-white border border-slate-200 rounded-2xl overflow-hidden soft-shadow group hover:border-blue-600 hover:shadow-lg transition-all duration-300">
                    <div class="h-48 overflow-hidden bg-slate-100 relative">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600" alt="Samsung Galaxy S23"/>
                        <span class="absolute top-3 right-3 bg-emerald-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-xs flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                            <span>Barang Ditemukan</span>
                        </span>
                    </div>
                    <div class="p-5">
                        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Elektronik & HP</span>
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors mt-0.5">Samsung Galaxy S23 Ultra - Biru</h3>
                        <div class="mt-3 space-y-1.5 text-xs text-slate-500">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base text-slate-400">calendar_today</span>
                                <span>23 Oktober 2024 (09:15 WIB)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base text-slate-400">location_on</span>
                                <span>Ruang Tunggu Utama Zone B</span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 3 -->
                <a href="{{ route('item-detail', 3) }}" class="bg-white border border-slate-200 rounded-2xl overflow-hidden soft-shadow group hover:border-blue-600 hover:shadow-lg transition-all duration-300">
                    <div class="h-48 overflow-hidden bg-slate-100 relative">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600" alt="Headphone Sony"/>
                        <span class="absolute top-3 right-3 bg-emerald-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-xs flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                            <span>Barang Ditemukan</span>
                        </span>
                    </div>
                    <div class="p-5">
                        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Aksesoris</span>
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors mt-0.5">Headphone Wireless Sony WH-1000XM4</h3>
                        <div class="mt-3 space-y-1.5 text-xs text-slate-500">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base text-slate-400">calendar_today</span>
                                <span>23 Oktober 2024 (19:40 WIB)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base text-slate-400">location_on</span>
                                <span>Area Food Court UMKM</span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 4 -->
                <a href="{{ route('item-detail', 4) }}" class="bg-white border border-slate-200 rounded-2xl overflow-hidden soft-shadow group hover:border-blue-600 hover:shadow-lg transition-all duration-300">
                    <div class="h-48 overflow-hidden bg-slate-100 relative">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600" alt="Ransel Eiger"/>
                        <span class="absolute top-3 right-3 bg-emerald-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-xs flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                            <span>Barang Ditemukan</span>
                        </span>
                    </div>
                    <div class="p-5">
                        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Tas & Dompet</span>
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors mt-0.5">Tas Ransel Eiger 30L Abu-Abu</h3>
                        <div class="mt-3 space-y-1.5 text-xs text-slate-500">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base text-slate-400">calendar_today</span>
                                <span>22 Oktober 2024 (05:20 WIB)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base text-slate-400">location_on</span>
                                <span>Pintu Kedatangan Bus Malam</span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 5 -->
                <a href="{{ route('item-detail', 5) }}" class="bg-white border border-slate-200 rounded-2xl overflow-hidden soft-shadow group hover:border-blue-600 hover:shadow-lg transition-all duration-300">
                    <div class="h-48 overflow-hidden bg-slate-100 relative">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1583485088034-697b5bc54ccd?w=600" alt="Kunci Mobil Toyota"/>
                        <span class="absolute top-3 right-3 bg-emerald-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-xs flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                            <span>Barang Ditemukan</span>
                        </span>
                    </div>
                    <div class="p-5">
                        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Kunci & Otomotif</span>
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors mt-0.5">Kunci Mobil Remote Toyota Innova</h3>
                        <div class="mt-3 space-y-1.5 text-xs text-slate-500">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base text-slate-400">calendar_today</span>
                                <span>21 Oktober 2024 (11:10 WIB)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base text-slate-400">location_on</span>
                                <span>Area Parkir Selatan Zone A</span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Card 6 -->
                <a href="{{ route('item-detail', 6) }}" class="bg-white border border-slate-200 rounded-2xl overflow-hidden soft-shadow group hover:border-blue-600 hover:shadow-lg transition-all duration-300">
                    <div class="h-48 overflow-hidden bg-slate-100 relative">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=600" alt="Jam Tangan Seiko"/>
                        <span class="absolute top-3 right-3 bg-emerald-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-xs flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                            <span>Barang Ditemukan</span>
                        </span>
                    </div>
                    <div class="p-5">
                        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Aksesoris</span>
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors mt-0.5">Jam Tangan Seiko Automatic Rantai</h3>
                        <div class="mt-3 space-y-1.5 text-xs text-slate-500">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-slate-400 text-base">calendar_today</span>
                                <span>21 Oktober 2024 (16:05 WIB)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-slate-400 text-base">location_on</span>
                                <span>Area Toilet Utama Pria</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="bg-slate-50 py-16 md:py-24 border-y border-slate-200">
        <div class="max-w-[1280px] mx-auto px-4 md:px-6">
            <div class="text-center mb-16">
                <span class="text-xs font-bold text-blue-600 tracking-wider uppercase bg-blue-100 px-3 py-1 rounded-full border border-blue-200">Prosedur Pengelolaan</span>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-3">Cara Kerja Sistem TirtoFind</h2>
                <p class="text-base text-slate-600 max-w-2xl mx-auto mt-2">Alur transparan dan terstruktur untuk mengembalikan barang milik Anda secara aman.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                <!-- Step 1 -->
                <div class="relative text-center group bg-white p-6 rounded-2xl border border-slate-200 soft-shadow hover:border-blue-600 transition-all">
                    <div class="w-14 h-14 bg-blue-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 font-extrabold text-xl shadow-md group-hover:scale-110 transition-transform">
                        1
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">1. Cari di Galeri</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Cari barang Anda di daftar inventaris barang temuan yang selalu diperbarui secara realtime.</p>
                </div>

                <!-- Step 2 -->
                <div class="relative text-center group bg-white p-6 rounded-2xl border border-slate-200 soft-shadow hover:border-blue-600 transition-all">
                    <div class="w-14 h-14 bg-blue-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 font-extrabold text-xl shadow-md group-hover:scale-110 transition-transform">
                        2
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">2. Lapor Kehilangan</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Jika belum ada di galeri, buat laporan kehilangan berisi deskripsi dan ciri khusus barang.</p>
                </div>

                <!-- Step 3 -->
                <div class="relative text-center group bg-white p-6 rounded-2xl border border-slate-200 soft-shadow hover:border-blue-600 transition-all">
                    <div class="w-14 h-14 bg-blue-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 font-extrabold text-xl shadow-md group-hover:scale-110 transition-transform">
                        3
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">3. Matching AI</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Sistem Vision AI membandingkan laporan Anda dengan seluruh foto barang temuan secara instan.</p>
                </div>

                <!-- Step 4 -->
                <div class="relative text-center group bg-white p-6 rounded-2xl border border-slate-200 soft-shadow hover:border-blue-600 transition-all">
                    <div class="w-14 h-14 bg-blue-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-4 font-extrabold text-xl shadow-md group-hover:scale-110 transition-transform">
                        4
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">4. Verifikasi & Klaim</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Lakukan verifikasi bukti kepemilikan dan ambil barang di Pos Informasi Terminal Tirtonadi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- AI Features Section -->
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-[1280px] mx-auto px-4 md:px-6">
            <div class="text-center mb-12">
                <span class="text-xs font-bold text-blue-700 tracking-wider uppercase bg-blue-100 px-3 py-1 rounded-full border border-blue-200">Teknologi Cerdas</span>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-3">Fitur Utama Vision AI TirtoFind</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- AI Feature 1 -->
                <div class="bg-white p-8 rounded-2xl border border-slate-200 soft-shadow flex flex-col sm:flex-row gap-6 items-start hover:border-blue-600 transition-all">
                    <div class="flex-shrink-0 w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center border border-blue-100">
                        <span class="material-symbols-outlined text-3xl">psychology</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">AI Smart Matching</h3>
                        <p class="text-xs md:text-sm text-slate-600 leading-relaxed">Pencocokan silang otomatis antara laporan kehilangan dan inventaris barang temuan dengan tingkat akurasi hingga 94.8% berdasarkan kemiripan visual dan teks.</p>
                    </div>
                </div>

                <!-- AI Feature 2 -->
                <div class="bg-white p-8 rounded-2xl border border-slate-200 soft-shadow flex flex-col sm:flex-row gap-6 items-start hover:border-blue-600 transition-all">
                    <div class="flex-shrink-0 w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center border border-blue-100">
                        <span class="material-symbols-outlined text-3xl">document_scanner</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">AI Auto Description</h3>
                        <p class="text-xs md:text-sm text-slate-600 leading-relaxed">Vision AI menganalisis foto barang temuan secara otomatis untuk mendeteksi warna, merek, jenis, serta menghasilkan deskripsi katalogisasi tanpa perlu pengetikan manual.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Accordion Section -->
    <section class="bg-slate-50 py-16 md:py-24 border-t border-slate-200">
        <div class="max-w-4xl mx-auto px-4 md:px-6">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900">Pertanyaan yang Sering Diajukan (FAQ)</h2>
                <p class="text-sm text-slate-600 mt-2">Informasi umum seputar layanan barang hilang Terminal Tirtonadi</p>
            </div>

            <div x-data="{ active: 1 }" class="space-y-4">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
                    <button @click="active = (active === 1 ? null : 1)" class="w-full p-5 text-left font-bold text-slate-900 flex justify-between items-center hover:bg-slate-50 transition-colors">
                        <span>Bagaimana prosedur mengklaim barang yang ditemukan di TirtoFind?</span>
                        <span class="material-symbols-outlined text-blue-600 transition-transform duration-200" :class="active === 1 ? 'rotate-180' : ''">expand_more</span>
                    </button>
                    <div x-show="active === 1" x-collapse class="px-5 pb-5 text-xs md:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Anda dapat menekan tombol "Ajukan Klaim" pada halaman detail barang, mengunggah foto KTP/SIM beserta bukti kepemilikan (seperti nota atau serial number), lalu mengambil barang di Pos Informasi Terminal Tirtonadi dengan mencetak Berita Acara resmi.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
                    <button @click="active = (active === 2 ? null : 2)" class="w-full p-5 text-left font-bold text-slate-900 flex justify-between items-center hover:bg-slate-50 transition-colors">
                        <span>Di mana lokasi Pos Informasi barang temuan di Terminal Tirtonadi?</span>
                        <span class="material-symbols-outlined text-blue-600 transition-transform duration-200" :class="active === 2 ? 'rotate-180' : ''">expand_more</span>
                    </button>
                    <div x-show="active === 2" x-collapse class="px-5 pb-5 text-xs md:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Pos Pelayanan Lost & Found terletak di Gedung Utama Lantai 1, persis di samping Ruang Informasi Utama Terminal Tirtonadi Surakarta. Petugas kami siaga 24 jam setiap hari.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
                    <button @click="active = (active === 3 ? null : 3)" class="w-full p-5 text-left font-bold text-slate-900 flex justify-between items-center hover:bg-slate-50 transition-colors">
                        <span>Berapa lama batas waktu penyimpanan barang temuan?</span>
                        <span class="material-symbols-outlined text-blue-600 transition-transform duration-200" :class="active === 3 ? 'rotate-180' : ''">expand_more</span>
                    </button>
                    <div x-show="active === 3" x-collapse class="px-5 pb-5 text-xs md:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Sesuai SOP Kementerian Perhubungan, barang temuan disimpan secara aman di brankas inventaris selama 90 hari kalender sebelum dilakukan proses penanganan tahap berikutnya sesuai regulasi.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Immediate Assistance Banner -->
    <section class="bg-blue-700 text-white py-12">
        <div class="max-w-[1280px] mx-auto px-4 md:px-6 text-center">
            <h2 class="text-xl md:text-2xl font-bold mb-2">Butuh Bantuan Langsung di Terminal Tirtonadi?</h2>
            <p class="text-xs md:text-sm text-blue-100 mb-6">Petugas Pos Pelayanan Informasi siap membantu Anda di lokasi 24 jam nonstop.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="tel:+62271716356" class="px-6 py-3 bg-white text-blue-700 rounded-xl font-bold text-xs md:text-sm hover:bg-slate-100 transition-all flex items-center gap-2 shadow-md">
                    <span class="material-symbols-outlined text-base">call</span>
                    <span>+62 271 716 356</span>
                </a>
                <a href="{{ route('contact') }}" class="px-6 py-3 bg-blue-800 hover:bg-blue-900 text-white rounded-xl font-bold text-xs md:text-sm transition-all border border-blue-600 flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">location_on</span>
                    <span>Peta Pos Informasi Tirtonadi</span>
                </a>
            </div>
        </div>
    </section>
</x-layouts.guest>
