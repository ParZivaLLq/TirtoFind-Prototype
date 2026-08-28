<x-layouts.guest title="Galeri Barang Temuan">
    <div class="max-w-[1280px] mx-auto px-4 md:px-6 py-6 md:py-10">

        <!-- Page Header -->
        <div class="text-center max-w-xl mx-auto mb-6">
            <span class="text-[11px] font-bold text-blue-700 uppercase tracking-wider bg-blue-100/80 px-2.5 py-0.5 rounded-full border border-blue-200">Inventaris Temuan</span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-2">Galeri Barang Temuan</h1>
            <p class="text-xs md:text-sm text-slate-600 mt-1">
                Daftar barang tertinggal yang diamankan di Pos Informasi Terminal Tirtonadi.
            </p>
        </div>

        <!-- Search & Filter Bar -->
        <form action="{{ route('found-items') }}" method="GET" class="bg-white border border-slate-200/80 rounded-2xl p-3.5 soft-shadow mb-8 max-w-2xl mx-auto flex flex-col sm:flex-row gap-2.5">
            <div class="relative flex-grow">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-lg">search</span>
                <input name="q" value="{{ $queryStr }}" type="text" placeholder="Cari nama barang (dompet, hp, kunci)..." class="w-full pl-9 pr-3 py-2 border border-slate-200 rounded-xl text-xs md:text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all">
            </div>

            <div class="w-full sm:w-44">
                <select name="category" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs md:text-sm focus:outline-none focus:border-blue-600 bg-white transition-all">
                    <option value="all">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected($categorySlug === $category->slug || $categorySlug === $category->name)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs md:text-sm transition-all shadow-xs flex items-center justify-center gap-1 cursor-pointer">
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
                <a href="{{ route('item-detail', $item->id) }}" class="bg-white border border-slate-200/80 rounded-2xl overflow-hidden soft-shadow hover:border-blue-600 hover:shadow-md transition-all duration-250 flex flex-col group">
                    <div class="h-44 overflow-hidden bg-slate-100 relative">
                        <img src="{{ $imageUrl }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"/>
                        <span class="absolute top-3 right-3 bg-emerald-600 text-white px-2.5 py-0.5 rounded-full text-[11px] font-bold shadow-xs">Ditemukan</span>
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between space-y-2.5">
                        <div>
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">{{ $item->category?->name ?: 'Lainnya' }}</span>
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition-colors mt-0.5 line-clamp-1">{{ $item->title }}</h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $item->description }}</p>
                        </div>
                        <div class="pt-2.5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">location_on</span> <span class="line-clamp-1">{{ $item->location_found }}</span></span>
                            <span class="text-blue-600 font-bold group-hover:translate-x-0.5 transition-transform flex items-center gap-0.5">Detail <span class="material-symbols-outlined text-sm">chevron_right</span></span>
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
