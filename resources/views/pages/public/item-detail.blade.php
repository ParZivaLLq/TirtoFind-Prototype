<x-layouts.guest title="Detail Barang Temuan">
    @php
        $imageUrl = $item->image_path ?: 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=800';
        $imageUrl = str_starts_with($imageUrl, 'http') ? $imageUrl : asset(ltrim($imageUrl, '/'));
    @endphp
    <div x-data="{ activeImage: '{{ $imageUrl }}' }" class="max-w-[1280px] mx-auto px-4 md:px-6 py-6 md:py-10">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-1.5 text-xs text-slate-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <a href="{{ route('found-items') }}" class="hover:text-blue-600 transition-colors">Barang Temuan</a>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <span class="font-semibold text-slate-800 line-clamp-1">{{ $item->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Image Preview -->
            <div class="lg:col-span-7 space-y-4">
                <div class="bg-slate-100 rounded-2xl overflow-hidden border border-slate-200/80 aspect-4/3 relative soft-shadow">
                    <img :src="activeImage" alt="{{ $item->title }}" class="w-full h-full object-cover transition-all duration-300"/>
                    <span class="absolute top-3 right-3 bg-emerald-600 text-white px-2.5 py-1 rounded-full text-xs font-bold shadow-xs flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                        <span>{{ $item->storage_location ?: 'Disimpan Petugas' }}</span>
                    </span>
                </div>
            </div>

            <!-- Right Column: Specs & CTA -->
            <div class="lg:col-span-5 space-y-5">
                <div>
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="px-2.5 py-0.5 bg-blue-50 text-blue-700 border border-blue-200/80 text-[11px] font-bold rounded-full">{{ $item->category?->name ?: 'Lainnya' }}</span>
                        <span class="text-xs font-mono text-slate-400 font-medium">Ref: {{ $item->ref_code }}</span>
                    </div>
                    <h1 class="text-xl md:text-2xl font-extrabold text-slate-900">{{ $item->title }}</h1>
                    <p class="text-xs text-slate-500 mt-1">Ditemukan {{ $item->date_found->format('d M Y H:i') }} WIB oleh petugas terminal.</p>
                </div>

                <!-- Info Specs Card -->
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/80 space-y-2.5 text-xs md:text-sm">
                    <div class="flex justify-between items-center border-b border-slate-200/80 pb-2">
                        <span class="text-slate-500 flex items-center gap-1"><span class="material-symbols-outlined text-base">location_on</span> Lokasi</span>
                        <span class="font-bold text-slate-900">{{ $item->location_found }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-slate-200/80 pb-2">
                        <span class="text-slate-500 flex items-center gap-1"><span class="material-symbols-outlined text-base">calendar_today</span> Tanggal & Waktu</span>
                        <span class="font-bold text-slate-900">{{ $item->date_found->format('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-slate-200/80 pb-2">
                        <span class="text-slate-500 flex items-center gap-1"><span class="material-symbols-outlined text-base">palette</span> Warna</span>
                        <span class="font-bold text-slate-900">{{ $item->color ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 flex items-center gap-1"><span class="material-symbols-outlined text-base">lock</span> Penyimpanan</span>
                        <span class="font-bold text-emerald-700">{{ $item->storage_location ?: 'Disimpan Petugas' }}</span>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-1.5">Deskripsi Barang</h3>
                    <p class="text-xs md:text-sm text-slate-600 leading-relaxed">
                        {{ $item->description }}
                    </p>
                </div>

                <!-- Status Progress Timeline -->
                <div class="border-t border-slate-200/80 pt-4">
                    <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-3">Penanganan</h3>
                    <div class="space-y-3 relative pl-5 border-l-2 border-blue-500/30 text-xs">
                        <div class="relative">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-600 absolute -left-[25px] top-1 ring-4 ring-white"></span>
                            <h4 class="font-bold text-slate-900">Barang Diamankan</h4>
                            <p class="text-[11px] text-slate-500">{{ $item->date_found->format('d M Y, H:i') }} WIB</p>
                        </div>
                        <div class="relative">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 absolute -left-[25px] top-1 ring-4 ring-white"></span>
                            <h4 class="font-bold text-amber-700">Menunggu Permohonan Klaim</h4>
                            <p class="text-[11px] text-slate-500">Masa simpan 90 hari kalender</p>
                        </div>
                    </div>
                </div>

                <!-- CTA Claim Button -->
                <div class="pt-3 border-t border-slate-200/80 space-y-2">
                    <a href="{{ route('claim', $id) }}" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-xs flex items-center justify-center gap-1.5 text-center text-xs md:text-sm">
                        <span class="material-symbols-outlined text-lg">verified</span>
                        <span>Ajukan Klaim Barang Ini</span>
                    </a>
                    <p class="text-[11px] text-center text-slate-400">Verifikasi klaim memerlukan identitas sah (KTP/SIM) & bukti kepemilikan.</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
