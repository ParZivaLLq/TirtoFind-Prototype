<x-layouts.guest title="Beranda Utama">
    <!-- Hero Section -->
    <section class="relative pt-12 pb-16 md:pt-20 md:pb-24 overflow-hidden bg-gradient-to-b from-blue-50/60 via-slate-50/30 to-white">
        <div class="max-w-[1280px] mx-auto px-4 md:px-6 text-center relative z-10">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-100/80 text-blue-700 text-xs font-semibold mb-6 border border-blue-200 shadow-2xs">
                <span class="material-symbols-outlined text-sm text-blue-600">auto_awesome</span>
                <span>Vision AI Lost & Found — Terminal Tirtonadi</span>
            </div>

            <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight text-slate-900 max-w-3xl mx-auto leading-tight mb-5">
                Menghubungkan Kembali Barang Hilang Anda
            </h1>
            <p class="text-sm md:text-base text-slate-600 max-w-xl mx-auto mb-8 leading-relaxed font-normal">
                Cari dan klaim barang tertinggal di Terminal Tirtonadi Surakarta secara cepat, aman, dan transparan.
            </p>

            <!-- Search Bar -->
            <form action="{{ route('found-items') }}" method="GET" class="max-w-xl mx-auto bg-white p-2 rounded-2xl soft-shadow border border-slate-200 flex items-center gap-2 focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-600 transition-all">
                <span class="material-symbols-outlined ml-3 text-slate-400 text-2xl flex-shrink-0">search</span>
                <input class="flex-grow border-none focus:outline-none focus:ring-0 text-sm md:text-base px-2 py-2 text-slate-900 placeholder:text-slate-400 bg-transparent" placeholder="Cari barang (cth: Dompet, HP, Kunci, Tas)..." type="text" name="q"/>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl transition-all shadow-sm flex items-center gap-1.5 cursor-pointer flex-shrink-0">
                    <span>Cari</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </form>

            <!-- Popular Search Tags -->
            <div class="mt-5 text-xs text-slate-500 flex flex-wrap justify-center items-center gap-2">
                <span class="font-medium">Populer:</span>
                <a href="{{ route('found-items', ['q' => 'Dompet']) }}" class="px-3 py-1 bg-slate-100 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors">Dompet</a>
                <a href="{{ route('found-items', ['q' => 'Samsung']) }}" class="px-3 py-1 bg-slate-100 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors">HP Samsung</a>
                <a href="{{ route('found-items', ['q' => 'Backpack']) }}" class="px-3 py-1 bg-slate-100 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors">Tas Ransel</a>
                <a href="{{ route('found-items', ['q' => 'Kunci']) }}" class="px-3 py-1 bg-slate-100 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors">Kunci</a>
            </div>
        </div>

        <!-- Background Atmosphere -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-200/20 rounded-full blur-3xl -z-10"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-slate-200/30 rounded-full blur-3xl -z-10"></div>
    </section>

    <!-- Statistics Section -->
    <section class="bg-slate-50 py-12 md:py-16 border-y border-slate-200">
        <div class="max-w-[1280px] mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat 1 -->
                <div class="bg-white p-6 md:p-7 rounded-2xl soft-shadow border border-slate-200/80 text-center hover:border-blue-500/40 transition-all flex flex-col justify-center items-center">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3 border border-emerald-100 shadow-2xs">
                        <span class="material-symbols-outlined text-2xl">inventory_2</span>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Barang Temuan</p>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 leading-tight">4.821</h2>
                    <span class="text-xs text-emerald-600 font-semibold mt-2 inline-block bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-100">+12 hari ini</span>
                </div>

                <!-- Stat 2 -->
                <div class="bg-white p-6 md:p-7 rounded-2xl soft-shadow border border-slate-200/80 text-center hover:border-blue-500/40 transition-all flex flex-col justify-center items-center">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-3 border border-blue-100 shadow-2xs">
                        <span class="material-symbols-outlined text-2xl">verified</span>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Barang Dikembalikan</p>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-blue-600 leading-tight">3.942</h2>
                    <span class="text-xs text-blue-600 font-semibold mt-2 inline-block bg-blue-50 px-2.5 py-0.5 rounded-full border border-blue-100">81.7% Pengembalian</span>
                </div>

                <!-- Stat 3 -->
                <div class="bg-white p-6 md:p-7 rounded-2xl soft-shadow border border-slate-200/80 text-center hover:border-blue-500/40 transition-all flex flex-col justify-center items-center">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3 border border-amber-100 shadow-2xs">
                        <span class="material-symbols-outlined text-2xl">report_problem</span>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Laporan Kehilangan</p>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 leading-tight">1.248</h2>
                    <span class="text-xs text-amber-600 font-semibold mt-2 inline-block bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-100">Matching AI Aktif</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Found Items -->
    <section class="py-14 md:py-20 bg-white">
        <div class="max-w-[1280px] mx-auto px-4 md:px-6">
            <div class="flex justify-between items-end mb-8 gap-4">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 leading-tight">Barang Temuan Terbaru</h2>
                    <p class="text-xs md:text-sm text-slate-500 mt-1 leading-relaxed">Barang yang diserahkan ke Pos Informasi Terminal Tirtonadi</p>
                </div>
                <a class="text-blue-600 font-bold text-xs md:text-sm flex items-center gap-1 hover:gap-1.5 transition-all flex-shrink-0" href="{{ route('found-items') }}">
                    <span>Lihat Semua</span>
                    <span class="material-symbols-outlined text-base">arrow_forward</span>
                </a>
            </div>

            <!-- Items Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($recentItems as $item)
                    @php
                        $imageUrl = $item->image_path ?: 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=800';
                        $imageUrl = str_starts_with($imageUrl, 'http') ? $imageUrl : asset(ltrim($imageUrl, '/'));
                    @endphp
                    <a href="{{ route('item-detail', $item->id) }}" class="bg-white border border-slate-200/80 rounded-2xl overflow-hidden soft-shadow group hover:border-blue-600 hover:shadow-md transition-all duration-250 flex flex-col">
                        <div class="h-44 overflow-hidden bg-slate-100 relative">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" src="{{ $imageUrl }}" alt="{{ $item->title }}"/>
                            <span class="absolute top-3 right-3 bg-emerald-600 text-white px-2.5 py-0.5 rounded-full text-xs font-semibold shadow-xs">Ditemukan</span>
                        </div>
                        <div class="p-5 flex-grow flex flex-col justify-between">
                            <div>
                                <span class="text-[11px] font-bold text-blue-600 uppercase tracking-wider block mb-1">{{ $item->category?->name ?: 'Lainnya' }}</span>
                                <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition-colors leading-snug line-clamp-1">{{ $item->title }}</h3>
                            </div>
                            <div class="mt-4 pt-3 border-t border-slate-100 space-y-1.5 text-xs text-slate-500 leading-relaxed">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm text-slate-400">calendar_today</span>
                                    <span>{{ $item->date_found->format('d M Y, H:i') }} WIB</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm text-slate-400">location_on</span>
                                    <span class="line-clamp-1">{{ $item->location_found }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-12 text-center bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
                        <span class="material-symbols-outlined text-4xl text-slate-300 mb-2">inventory_2</span>
                        <p class="text-sm font-medium text-slate-500">Belum ada barang temuan yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="bg-slate-50 py-14 md:py-20 border-y border-slate-200">
        <div class="max-w-[1280px] mx-auto px-4 md:px-6">
            <div class="text-center max-w-xl mx-auto mb-12">
                <span class="text-xs font-bold text-blue-600 tracking-wider uppercase bg-blue-100/80 px-3 py-1 rounded-full border border-blue-200">Alur Layanan</span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-3 leading-tight">Cara Kerja TirtoFind</h2>
                <p class="text-xs md:text-sm text-slate-600 mt-2 leading-relaxed">4 langkah praktis mengklaim kembali barang milik Anda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Step 1 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 soft-shadow text-center hover:border-blue-600 transition-all flex flex-col items-center">
                    <div class="w-12 h-12 bg-blue-600 text-white rounded-xl flex items-center justify-center mb-4 font-extrabold text-base shadow-sm">1</div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Cari Barang</h3>
                    <p class="text-xs md:text-sm text-slate-500 leading-relaxed">Cari barang Anda di galeri inventaris temuan kami.</p>
                </div>

                <!-- Step 2 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 soft-shadow text-center hover:border-blue-600 transition-all flex flex-col items-center">
                    <div class="w-12 h-12 bg-blue-600 text-white rounded-xl flex items-center justify-center mb-4 font-extrabold text-base shadow-sm">2</div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Buat Laporan</h3>
                    <p class="text-xs md:text-sm text-slate-500 leading-relaxed">Isi form laporan kehilangan beserta ciri khas barang.</p>
                </div>

                <!-- Step 3 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 soft-shadow text-center hover:border-blue-600 transition-all flex flex-col items-center">
                    <div class="w-12 h-12 bg-blue-600 text-white rounded-xl flex items-center justify-center mb-4 font-extrabold text-base shadow-sm">3</div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">AI Matching</h3>
                    <p class="text-xs md:text-sm text-slate-500 leading-relaxed">Vision AI secara otomatis memadankan laporan Anda.</p>
                </div>

                <!-- Step 4 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 soft-shadow text-center hover:border-blue-600 transition-all flex flex-col items-center">
                    <div class="w-12 h-12 bg-blue-600 text-white rounded-xl flex items-center justify-center mb-4 font-extrabold text-base shadow-sm">4</div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">Klaim & Ambil</h3>
                    <p class="text-xs md:text-sm text-slate-500 leading-relaxed">Verifikasi kepemilikan lalu ambil barang di Pos Informasi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- AI Features Section -->
    <section class="py-14 md:py-20 bg-white">
        <div class="max-w-[1280px] mx-auto px-4 md:px-6">
            <div class="text-center max-w-xl mx-auto mb-12">
                <span class="text-xs font-bold text-blue-700 tracking-wider uppercase bg-blue-100/80 px-3 py-1 rounded-full border border-blue-200">Kecerdasan Buatan</span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-3 leading-tight">Teknologi Vision AI</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- AI Feature 1 -->
                <div class="bg-white p-6 md:p-7 rounded-2xl border border-slate-200/80 soft-shadow flex items-start gap-4 hover:border-blue-600 transition-all">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center border border-blue-100 shadow-2xs mt-0.5">
                        <span class="material-symbols-outlined text-2xl">psychology</span>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-base md:text-lg font-bold text-slate-900 leading-snug">AI Smart Matching</h3>
                        <p class="text-xs md:text-sm text-slate-600 leading-relaxed">Memadankan foto dan deskripsi laporan kehilangan dengan barang temuan secara realtime berbasis kemiripan visual.</p>
                    </div>
                </div>

                <!-- AI Feature 2 -->
                <div class="bg-white p-6 md:p-7 rounded-2xl border border-slate-200/80 soft-shadow flex items-start gap-4 hover:border-blue-600 transition-all">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center border border-blue-100 shadow-2xs mt-0.5">
                        <span class="material-symbols-outlined text-2xl">document_scanner</span>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-base md:text-lg font-bold text-slate-900 leading-snug">AI Auto Description</h3>
                        <p class="text-xs md:text-sm text-slate-600 leading-relaxed">Menganalisis foto barang temuan secara otomatis untuk mengenali jenis, warna, dan merek barang tanpa input manual.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="bg-slate-50 py-14 md:py-20 border-t border-slate-200">
        <div class="max-w-3xl mx-auto px-4 md:px-6">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 leading-tight">Pertanyaan Umum (FAQ)</h2>
                <p class="text-xs md:text-sm text-slate-500 mt-2 leading-relaxed">Seputar layanan pengembalian barang Terminal Tirtonadi</p>
            </div>

            <div x-data="{ active: 1 }" class="space-y-4">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-xl border border-slate-200/80 overflow-hidden shadow-2xs">
                    <button @click="active = (active === 1 ? null : 1)" class="w-full p-4 md:p-5 text-left text-sm md:text-base font-bold text-slate-900 flex justify-between items-center hover:bg-slate-50 transition-colors gap-4">
                        <span class="leading-snug">Bagaimana cara mengklaim barang yang ditemukan?</span>
                        <span class="material-symbols-outlined text-blue-600 transition-transform duration-200 flex-shrink-0" :class="active === 1 ? 'rotate-180' : ''">expand_more</span>
                    </button>
                    <div x-show="active === 1" x-collapse class="px-4 md:px-5 pb-5 text-xs md:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Klik "Ajukan Klaim" pada detail barang, unggah identitas & bukti kepemilikan, lalu ambil barang di Pos Informasi Terminal Tirtonadi.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-xl border border-slate-200/80 overflow-hidden shadow-2xs">
                    <button @click="active = (active === 2 ? null : 2)" class="w-full p-4 md:p-5 text-left text-sm md:text-base font-bold text-slate-900 flex justify-between items-center hover:bg-slate-50 transition-colors gap-4">
                        <span class="leading-snug">Di mana lokasi Pos Informasi barang temuan?</span>
                        <span class="material-symbols-outlined text-blue-600 transition-transform duration-200 flex-shrink-0" :class="active === 2 ? 'rotate-180' : ''">expand_more</span>
                    </button>
                    <div x-show="active === 2" x-collapse class="px-4 md:px-5 pb-5 text-xs md:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Gedung Utama Lantai 1 (samping Ruang Informasi Utama Terminal Tirtonadi Surakarta). Petugas siaga 24 jam.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-xl border border-slate-200/80 overflow-hidden shadow-2xs">
                    <button @click="active = (active === 3 ? null : 3)" class="w-full p-4 md:p-5 text-left text-sm md:text-base font-bold text-slate-900 flex justify-between items-center hover:bg-slate-50 transition-colors gap-4">
                        <span class="leading-snug">Berapa lama masa penyimpanan barang temuan?</span>
                        <span class="material-symbols-outlined text-blue-600 transition-transform duration-200 flex-shrink-0" :class="active === 3 ? 'rotate-180' : ''">expand_more</span>
                    </button>
                    <div x-show="active === 3" x-collapse class="px-4 md:px-5 pb-5 text-xs md:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Sesuai regulasi Kemenhub, barang temuan disimpan aman di brankas inventaris selama 90 hari kalender.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Immediate Assistance Banner -->
    <section class="bg-blue-700 text-white py-12 md:py-14">
        <div class="max-w-[1280px] mx-auto px-4 md:px-6 text-center">
            <h2 class="text-xl md:text-2xl font-bold mb-2 leading-tight">Butuh Bantuan Langsung?</h2>
            <p class="text-xs md:text-sm text-blue-100 mb-6 leading-relaxed">Petugas Pos Pelayanan Informasi siap membantu di lokasi 24 jam nonstop.</p>
            <div class="flex flex-wrap justify-center gap-3 md:gap-4">
                <a href="tel:+62271716356" class="px-5 py-3 bg-white text-blue-700 rounded-xl font-bold text-xs md:text-sm hover:bg-slate-100 transition-all flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-base md:text-lg">call</span>
                    <span>+62 271 716 356</span>
                </a>
                <a href="{{ route('contact') }}" class="px-5 py-3 bg-blue-800 hover:bg-blue-900 text-white rounded-xl font-bold text-xs md:text-sm transition-all border border-blue-600 flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-base md:text-lg">location_on</span>
                    <span>Lokasi Pos Informasi</span>
                </a>
            </div>
        </div>
    </section>
</x-layouts.guest>

