<x-layouts.guest title="Galeri Barang Temuan">
    <div class="max-w-[1280px] mx-auto px-4 md:px-6 py-8 md:py-12">

        <!-- Page Header -->
        <div class="text-center max-w-2xl mx-auto mb-8">
            <span class="text-xs font-bold text-blue-700 uppercase tracking-wider bg-blue-100 px-3 py-1 rounded-full border border-blue-200">Katalog Barang Temuan</span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-3">Barang Temuan Terminal Tirtonadi</h1>
            <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                Daftar barang yang berhasil diamankan oleh petugas. Pilih barang yang sesuai untuk mengajukan klaim.
            </p>
        </div>

        <!-- Streamlined Search & Filter Bar -->
        <form action="{{ route('found-items') }}" method="GET" class="bg-white border border-slate-200 rounded-2xl p-4 soft-shadow mb-10 max-w-3xl mx-auto flex flex-col sm:flex-row gap-3">
            <div class="relative flex-grow">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-lg">search</span>
                <input name="q" value="{{ $queryStr }}" type="text" placeholder="Cari nama barang (dompet, hp, kunci)..." class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all">
            </div>

            <div class="w-full sm:w-48">
                <select name="category" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 bg-white transition-all">
                    <option value="all">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected($categorySlug === $category->slug || $categorySlug === $category->name)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm transition-all shadow-sm flex items-center justify-center gap-1 cursor-pointer">
                <span>Cari</span>
            </button>
        </form>

        <!-- Clean Items Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($items as $item)
                @php
                    $imageUrl = $item->image_path ?: 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=800';
                    $imageUrl = str_starts_with($imageUrl, 'http') ? $imageUrl : asset(ltrim($imageUrl, '/'));
                @endphp
                <a href="{{ route('item-detail', $item->id) }}" class="bg-white border border-slate-200 rounded-2xl overflow-hidden soft-shadow hover:border-blue-600 hover:shadow-lg transition-all duration-300 flex flex-col group">
                    <div class="h-48 overflow-hidden bg-slate-100 relative">
                        <img src="{{ $imageUrl }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"/>
                        <span class="absolute top-3 right-3 bg-emerald-600 text-white px-2.5 py-0.5 rounded-full text-xs font-bold shadow-xs">Ditemukan</span>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">{{ $item->category?->name ?: 'Lainnya' }}</span>
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition-colors mt-0.5">{{ $item->title }}</h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $item->description }}</p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">location_on</span> <span>{{ $item->location_found }}</span></span>
                            <span class="text-blue-600 font-bold group-hover:translate-x-1 transition-transform flex items-center gap-0.5">Detail <span class="material-symbols-outlined text-sm">chevron_right</span></span>
                        </div>
                    </div>
                </a>
            @empty

            <!-- Empty State when no match -->
            <div class="col-span-full py-8">
                <x-ui.empty-state 
                    title="Barang Temuan Tidak Ditemukan" 
                    description="Maaf, tidak ada barang temuan yang cocok dengan kata kunci atau kategori yang Anda cari." 
                    icon="search_off">
                </x-ui.empty-state>
            </div>
            @endforelse
        </div>
    </div>
</x-layouts.guest>
