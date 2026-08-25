<x-layouts.guest title="Detail Barang Temuan">
    @php
        $imageUrl = $item->image_path ?: 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=800';
        $imageUrl = str_starts_with($imageUrl, 'http') ? $imageUrl : asset(ltrim($imageUrl, '/'));
    @endphp
    <div x-data="{ activeImage: '{{ $imageUrl }}' }" class="max-w-[1280px] mx-auto px-4 md:px-6 py-8 md:py-12">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs md:text-sm text-slate-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <a href="{{ route('found-items') }}" class="hover:text-blue-600 transition-colors">Barang Temuan</a>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <span class="font-bold text-slate-900">{{ $item->title }} (Kode: {{ $item->ref_code }})</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12">
            <!-- Left Column: Gallery Preview -->
            <div class="lg:col-span-7 space-y-4">
                <div class="bg-slate-100 rounded-2xl overflow-hidden border border-slate-200 aspect-4/3 relative soft-shadow">
                    <img :src="activeImage" alt="{{ $item->title }}" class="w-full h-full object-cover transition-all duration-300"/>
                    <span class="absolute top-4 right-4 bg-emerald-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-md flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                        <span>{{ $item->storage_location ?: 'Disimpan petugas' }}</span>
                    </span>
                </div>

                <!-- Thumbnails -->
            </div>

            <!-- Right Column: Specs & CTA -->
            <div class="lg:col-span-5 space-y-6">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 bg-blue-50 text-blue-700 border border-blue-200 text-xs font-bold rounded-full">{{ $item->category?->name ?: 'Lainnya' }}</span>
                        <span class="text-xs font-mono text-slate-400 font-semibold">Ref: {{ $item->ref_code }}</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">{{ $item->title }}</h1>
                    <p class="text-xs text-slate-500 mt-1">Barang ditemukan pada {{ $item->date_found->format('d M Y H:i') }} oleh petugas Terminal Tirtonadi.</p>
                </div>

                <!-- Info Table Card -->
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
                    <div class="flex justify-between items-center text-xs md:text-sm border-b border-slate-200 pb-2.5">
                        <span class="text-slate-500 flex items-center gap-1.5"><span class="material-symbols-outlined text-base">location_on</span> Lokasi Penemuan</span>
                        <span class="font-bold text-slate-900">{{ $item->location_found }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs md:text-sm border-b border-slate-200 pb-2.5">
                        <span class="text-slate-500 flex items-center gap-1.5"><span class="material-symbols-outlined text-base">calendar_today</span> Waktu WIB</span>
                        <span class="font-bold text-slate-900">{{ $item->date_found->format('d M Y, H:i') }} WIB</span>
                    </div>
                    <div class="flex justify-between items-center text-xs md:text-sm border-b border-slate-200 pb-2.5">
                        <span class="text-slate-500 flex items-center gap-1.5"><span class="material-symbols-outlined text-base">palette</span> Warna Dominan</span>
                        <span class="font-bold text-slate-900">{{ $item->color ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs md:text-sm">
                        <span class="text-slate-500 flex items-center gap-1.5"><span class="material-symbols-outlined text-base">lock</span> Lokasi Simpan</span>
                        <span class="font-bold text-emerald-700">{{ $item->storage_location ?: 'Disimpan petugas' }}</span>
                    </div>
                </div>

                <!-- Description Text -->
                <div>
                    <h3 class="text-sm font-bold text-slate-900 mb-2">Deskripsi & Ciri Fisik Barang</h3>
                    <p class="text-xs md:text-sm text-slate-600 leading-relaxed">
                        {{ $item->description }}
                    </p>
                </div>

                <!-- Status Progress Timeline -->
                <div class="border-t border-slate-200 pt-4">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Timeline Penanganan Petugas</h3>
                    <div class="space-y-4 relative pl-6 border-l-2 border-blue-500/30">
                        <div class="relative">
                            <span class="w-3 h-3 rounded-full bg-blue-600 absolute -left-[31px] top-1 ring-4 ring-white"></span>
                            <h4 class="text-xs font-bold text-slate-900">Barang Ditemukan & Diamankan</h4>
                            <p class="text-[11px] text-slate-500">{{ $item->date_found->format('d M Y, H:i') }} WIB</p>
                        </div>
                        <div class="relative">
                            <span class="w-3 h-3 rounded-full bg-blue-600 absolute -left-[31px] top-1 ring-4 ring-white"></span>
                            <h4 class="text-xs font-bold text-slate-900">Katalogisasi Vision AI Selesai</h4>
                            <p class="text-[11px] text-slate-500">24 Oct 2024, 14:35 WIB - Auto Cataloging Active</p>
                        </div>
                        <div class="relative">
                            <span class="w-3 h-3 rounded-full bg-amber-500 absolute -left-[31px] top-1 ring-4 ring-white animate-pulse"></span>
                            <h4 class="text-xs font-bold text-amber-700">Menunggu Permohonan Klaim</h4>
                            <p class="text-[11px] text-slate-500">Masa simpan berlaku hingga 24 Januari 2025</p>
                        </div>
                    </div>
                </div>

                <!-- CTA Claim Button -->
                <div class="pt-4 border-t border-slate-200 space-y-3">
                    <a href="{{ route('claim', $id) }}" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-md flex items-center justify-center gap-2 text-center text-sm">
                        <span class="material-symbols-outlined text-xl">verified</span>
                        <span>Apakah Ini Barang Anda? Ajukan Klaim</span>
                    </a>
                    <p class="text-[11px] text-center text-slate-500">Klaim memerlukan pengunggahan foto KTP dan bukti kepemilikan sah.</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
