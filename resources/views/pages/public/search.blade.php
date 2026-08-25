<x-layouts.guest title="Pencarian Barang">
    <div class="max-w-[1280px] mx-auto px-4 md:px-6 py-8 md:py-12">
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-on-background">Pencarian Barang Hilang & Temuan</h1>
            <p class="text-base text-on-surface-variant max-w-2xl mt-2">
                Gunakan filter di bawah untuk menemukan barang yang hilang di kawasan Terminal Tirtonadi Surakarta.
            </p>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('search') }}" method="GET" class="bg-white p-6 rounded-2xl border border-border-subtle soft-shadow mb-8 space-y-4">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-4 top-3.5 text-outline text-2xl">search</span>
                <input name="q" value="{{ $q }}" type="text" placeholder="Masukkan kata kunci nama barang, merek, atau ciri fisik..." class="w-full pl-12 pr-4 py-3 border border-border-subtle rounded-xl text-base focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
            </div>

            <!-- Filters Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                <div>
                    <label class="block text-xs font-semibold text-outline mb-1">Kategori Barang</label>
                    <select name="category" class="w-full px-3 py-2 border border-border-subtle rounded-xl text-sm focus:outline-none focus:border-primary">
                        <option value="all">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->slug }}" @selected($categorySlug === $category->slug || $categorySlug === $category->name)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-outline mb-1">Lokasi Kejadian</label>
                    <select name="location" class="w-full px-3 py-2 border border-border-subtle rounded-xl text-sm focus:outline-none focus:border-primary">
                        <option value="all">Semua Lokasi Terminal</option>
                        <option value="Platform">Platform Bus</option>
                        <option value="Ruang Tunggu">Ruang Tunggu</option>
                        <option value="Food Court">Foodcourt</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-outline mb-1">Rentang Tanggal</label>
                    <input name="date" value="{{ $date }}" type="date" class="w-full px-3 py-2 border border-border-subtle rounded-xl text-sm focus:outline-none focus:border-primary">
                </div>
            </div>
            <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-xl text-sm font-bold">Cari</button>
        </form>

        <!-- Results Grid -->
        <div class="space-y-4">
            <h2 class="text-lg font-bold text-on-background">Hasil Pencarian ({{ $items->count() }} barang)</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($items as $item)
                    @php
                        $imageUrl = $item->image_path ?: 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=800';
                        $imageUrl = str_starts_with($imageUrl, 'http') ? $imageUrl : asset(ltrim($imageUrl, '/'));
                    @endphp
                    <a href="{{ route('item-detail', $item->id) }}" class="bg-white border border-border-subtle rounded-xl p-4 soft-shadow hover:border-primary transition-all flex gap-4">
                        <img src="{{ $imageUrl }}" alt="{{ $item->title }}" class="w-24 h-24 object-cover rounded-lg flex-shrink-0"/>
                        <div><span class="text-[10px] font-bold text-primary uppercase">{{ $item->category?->name ?: 'Barang Temuan' }}</span><h3 class="text-sm font-bold text-on-background">{{ $item->title }}</h3><p class="text-xs text-outline mt-1">{{ $item->location_found }}</p><p class="text-xs text-outline">{{ $item->date_found->format('d M Y') }}</p></div>
                    </a>
                @empty
                    <p class="col-span-full py-8 text-center text-sm text-slate-500">Tidak ada barang temuan yang sesuai.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.guest>
