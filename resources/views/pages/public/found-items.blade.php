<x-layouts.guest title="Galeri Barang Temuan">
    <div x-data="{
        search: '{{ request('q', '') }}',
        category: 'all',
        items: [
            { id: 1, title: 'Dompet Kulit Pria Imperial Horse', category: 'Tas & Dompet', desc: 'Dompet kulit warna hitam merk Imperial Horse berisi kartu E-Money.', location: 'Platform 4', image: 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=600' },
            { id: 2, title: 'Samsung Galaxy S23 Ultra', category: 'Elektronik & HP', desc: 'Smartphone Samsung warna biru dengan casing transparan.', location: 'Ruang Tunggu B', image: 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600' },
            { id: 3, title: 'Headphone Wireless Sony', category: 'Aksesoris', desc: 'Headphone bluetooth Sony WH-1000XM4 warna hitam.', location: 'Area Food Court', image: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600' },
            { id: 4, title: 'Tas Ransel Eiger 30L Abu-Abu', category: 'Tas & Dompet', desc: 'Ransel abu-abu 30L merk Eiger di pintu kedatangan.', location: 'Pintu Kedatangan', image: 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600' },
            { id: 5, title: 'Kunci Mobil Remote Toyota', category: 'Kunci & Otomotif', desc: 'Kunci mobil Toyota Innova dengan gantungan kunci kulit.', location: 'Parkir Selatan', image: 'https://images.unsplash.com/photo-1583485088034-697b5bc54ccd?w=600' },
            { id: 6, title: 'Jam Tangan Seiko Automatic', category: 'Aksesoris', desc: 'Jam tangan rantai stainless steel merk Seiko.', location: 'Toilet Utama', image: 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=600' }
        ],
        filteredItems() {
            const query = this.search.trim().toLowerCase();
            return this.items.filter(item => {
                const matchesSearch = !query || 
                    item.title.toLowerCase().includes(query) || 
                    item.desc.toLowerCase().includes(query) ||
                    item.category.toLowerCase().includes(query);
                    
                const matchesCategory = this.category === 'all' || item.category === this.category;
                return matchesSearch && matchesCategory;
            });
        }
    }" class="max-w-[1280px] mx-auto px-4 md:px-6 py-8 md:py-12">

        <!-- Page Header -->
        <div class="text-center max-w-2xl mx-auto mb-8">
            <span class="text-xs font-bold text-blue-700 uppercase tracking-wider bg-blue-100 px-3 py-1 rounded-full border border-blue-200">Katalog Barang Temuan</span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-3">Barang Temuan Terminal Tirtonadi</h1>
            <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                Daftar barang yang berhasil diamankan oleh petugas. Pilih barang yang sesuai untuk mengajukan klaim.
            </p>
        </div>

        <!-- Streamlined Search & Filter Bar -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 soft-shadow mb-10 max-w-3xl mx-auto flex flex-col sm:flex-row gap-3">
            <div class="relative flex-grow">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-lg">search</span>
                <input x-model="search" type="text" placeholder="Cari nama barang (dompet, hp, kunci)..." class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all">
            </div>

            <div class="w-full sm:w-48">
                <select x-model="category" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 bg-white transition-all">
                    <option value="all">Semua Kategori</option>
                    <option value="Tas & Dompet">Tas & Dompet</option>
                    <option value="Elektronik & HP">Elektronik & HP</option>
                    <option value="Aksesoris">Aksesoris</option>
                    <option value="Kunci & Otomotif">Kunci & Otomotif</option>
                </select>
            </div>

            <button type="button" @click="search = search.trim()" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm transition-all shadow-sm flex items-center justify-center gap-1 cursor-pointer">
                <span>Cari</span>
            </button>
        </div>

        <!-- Clean Items Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Loop filtered items -->
            <template x-for="item in filteredItems()" :key="item.id">
                <a :href="'{{ url('found-items') }}/' + item.id" class="bg-white border border-slate-200 rounded-2xl overflow-hidden soft-shadow hover:border-blue-600 hover:shadow-lg transition-all duration-300 flex flex-col group">
                    <div class="h-48 overflow-hidden bg-slate-100 relative">
                        <img :src="item.image" :alt="item.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"/>
                        <span class="absolute top-3 right-3 bg-emerald-600 text-white px-2.5 py-0.5 rounded-full text-xs font-bold shadow-xs">Ditemukan</span>
                    </div>
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider" x-text="item.category"></span>
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition-colors mt-0.5" x-text="item.title"></h3>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2" x-text="item.desc"></p>
                        </div>
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">location_on</span> <span x-text="item.location"></span></span>
                            <span class="text-blue-600 font-bold group-hover:translate-x-1 transition-transform flex items-center gap-0.5">Detail <span class="material-symbols-outlined text-sm">chevron_right</span></span>
                        </div>
                    </div>
                </a>
            </template>

            <!-- Empty State when no match -->
            <div x-show="filteredItems().length === 0" class="col-span-full py-8">
                <x-ui.empty-state 
                    title="Barang Temuan Tidak Ditemukan" 
                    description="Maaf, tidak ada barang temuan yang cocok dengan kata kunci atau kategori yang Anda cari." 
                    icon="search_off">
                    <button type="button" @click="search = ''; category = 'all'" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs shadow-sm transition-all cursor-pointer">
                        Reset Kata Kunci & Filter
                    </button>
                </x-ui.empty-state>
            </div>
        </div>
    </div>
</x-layouts.guest>
