<x-layouts.guest title="Pencarian Barang">
    <div class="max-w-[1280px] mx-auto px-4 md:px-6 py-6 md:py-10">
        <div class="mb-6 text-center max-w-xl mx-auto">
            <span class="text-[11px] font-bold text-blue-700 uppercase tracking-wider bg-blue-100/80 px-2.5 py-0.5 rounded-full border border-blue-200">Pencarian Lanjut</span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-2">Pencarian Barang Hilang & Temuan</h1>
            <p class="text-xs md:text-sm text-slate-600 mt-1">
                Gunakan filter di bawah untuk menemukan barang tertinggal di kawasan Terminal Tirtonadi.
            </p>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('search') }}" method="GET" class="bg-white p-5 rounded-2xl border border-slate-200/80 soft-shadow mb-8 space-y-4 max-w-3xl mx-auto">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3.5 top-3 text-slate-400 text-xl">search</span>
                <input name="q" value="{{ $q }}" type="text" placeholder="Masukkan kata kunci nama barang, merek, atau ciri fisik..." class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-xs md:text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all">
            </div>

            <!-- Filters Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Kategori Barang</label>
                    <select name="category" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-600 bg-white">
                        <option value="all">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->slug }}" @selected($categorySlug === $category->slug || $categorySlug === $category->name)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Lokasi Kejadian</label>
                    <select name="location" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-600 bg-white">
                        <option value="all">Semua Lokasi Terminal</option>
                        <option value="Platform">Platform Bus</option>
                        <option value="Ruang Tunggu">Ruang Tunggu</option>
                        <option value="Food Court">Foodcourt</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Tanggal</label>
                    <input name="date" value="{{ $date }}" type="date" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-600 bg-white">
                </div>
            </div>
            <div class="flex justify-end pt-1">
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-xs cursor-pointer">
                    <span>Cari Barang</span>
                </button>
            </div>
        </form>

        <!-- Results Grid -->
        <div class="space-y-4">
            <h2 class="text-base font-bold text-slate-900">Hasil Pencarian ({{ $items->count() }} barang)</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @forelse ($items as $item)
                    @php
                        $imageUrl = $item->image_path ?: 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=800';
                        $imageUrl = str_starts_with($imageUrl, 'http') ? $imageUrl : asset(ltrim($imageUrl, '/'));
                    @endphp
                    <a href="{{ route('item-detail', $item->id) }}" class="bg-white border border-slate-200/80 rounded-2xl p-3.5 soft-shadow hover:border-blue-600 transition-all flex gap-3.5 group">
                        <img src="{{ $imageUrl }}" alt="{{ $item->title }}" class="w-20 h-20 object-cover rounded-xl flex-shrink-0 group-hover:scale-105 transition-transform"/>
                        <div class="flex flex-col justify-center">
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">{{ $item->category?->name ?: 'Barang Temuan' }}</span>
                            <h3 class="text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-1">{{ $item->title }}</h3>
                            <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ $item->location_found }}</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">{{ $item->date_found->format('d M Y') }}</p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-8">
                        <x-ui.empty-state 
                            title="Barang Tidak Ditemukan" 
                            description="Maaf, tidak ada barang temuan yang sesuai dengan pencarian Anda." 
                            icon="search_off">
                        </x-ui.empty-state>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.guest>
