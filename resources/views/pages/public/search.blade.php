<x-layouts.guest title="Pencarian Barang">
    <div x-data="{ query: '', category: 'all', location: 'all', date: '' }" class="max-w-[1280px] mx-auto px-4 md:px-6 py-8 md:py-12">
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-on-background">Pencarian Barang Hilang & Temuan</h1>
            <p class="text-base text-on-surface-variant max-w-2xl mt-2">
                Gunakan filter di bawah untuk menemukan barang yang hilang di kawasan Terminal Tirtonadi Surakarta.
            </p>
        </div>

        <!-- Search Bar -->
        <div class="bg-white p-6 rounded-2xl border border-border-subtle soft-shadow mb-8 space-y-4">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-4 top-3.5 text-outline text-2xl">search</span>
                <input x-model="query" type="text" placeholder="Masukkan kata kunci nama barang, merek, atau ciri fisik..." class="w-full pl-12 pr-4 py-3 border border-border-subtle rounded-xl text-base focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
            </div>

            <!-- Filters Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                <div>
                    <label class="block text-xs font-semibold text-outline mb-1">Kategori Barang</label>
                    <select x-model="category" class="w-full px-3 py-2 border border-border-subtle rounded-xl text-sm focus:outline-none focus:border-primary">
                        <option value="all">Semua Kategori</option>
                        <option value="electronics">Elektronik</option>
                        <option value="bags">Tas & Dompet</option>
                        <option value="documents">Dokumen</option>
                        <option value="accessories">Aksesoris</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-outline mb-1">Lokasi Kejadian</label>
                    <select x-model="location" class="w-full px-3 py-2 border border-border-subtle rounded-xl text-sm focus:outline-none focus:border-primary">
                        <option value="all">Semua Lokasi Terminal</option>
                        <option value="platform">Platform Bus</option>
                        <option value="waiting">Ruang Tunggu</option>
                        <option value="foodcourt">Foodcourt</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-outline mb-1">Rentang Tanggal</label>
                    <input x-model="date" type="date" class="w-full px-3 py-2 border border-border-subtle rounded-xl text-sm focus:outline-none focus:border-primary">
                </div>
            </div>
        </div>

        <!-- Results Grid -->
        <div class="space-y-4">
            <h2 class="text-lg font-bold text-on-background">Hasil Pencarian Realtime</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Search Card 1 -->
                <a href="{{ route('item-detail', 1) }}" class="bg-white border border-border-subtle rounded-xl p-4 soft-shadow hover:border-primary transition-all flex gap-4">
                    <img src="https://images.unsplash.com/photo-1627123424574-724758594e93?w=300" class="w-24 h-24 object-cover rounded-lg flex-shrink-0"/>
                    <div>
                        <span class="text-[10px] font-bold text-primary uppercase">Found Item</span>
                        <h3 class="text-sm font-bold text-on-background">Black Leather Wallet</h3>
                        <p class="text-xs text-outline mt-1">Platform 4, Terminal Tirtonadi</p>
                        <p class="text-xs text-outline">24 Oct 2024</p>
                    </div>
                </a>

                <!-- Search Card 2 -->
                <a href="{{ route('item-detail', 2) }}" class="bg-white border border-border-subtle rounded-xl p-4 soft-shadow hover:border-primary transition-all flex gap-4">
                    <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=300" class="w-24 h-24 object-cover rounded-lg flex-shrink-0"/>
                    <div>
                        <span class="text-[10px] font-bold text-primary uppercase">Found Item</span>
                        <h3 class="text-sm font-bold text-on-background">iPhone 13 - Blue</h3>
                        <p class="text-xs text-outline mt-1">Waiting Hall Zone B</p>
                        <p class="text-xs text-outline">23 Oct 2024</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-layouts.guest>
