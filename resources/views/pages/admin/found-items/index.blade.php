<x-layouts.admin title="Found Item Management">
    <div x-data="{ addModalOpen: false, editModalOpen: false, deleteModalOpen: false, selectedItem: null }" class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Manajemen Inventaris Barang Temuan</h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola data barang temuan di Terminal Tirtonadi. Tambah, edit, atau perbarui status barang.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.ai-auto-desc.index') }}" class="px-4 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">auto_awesome</span>
                    <span>AI Auto Desc</span>
                </a>
                <button @click="addModalOpen = true" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-2 cursor-pointer">
                    <span class="material-symbols-outlined text-base">add</span>
                    <span>Tambah Barang Temuan</span>
                </button>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <form action="{{ route('admin.found-items.index') }}" method="GET" class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow flex flex-wrap gap-4 items-center justify-between">
            <div class="flex flex-wrap gap-3 flex-1 min-w-[280px]">
                <div class="relative flex-1 min-w-[200px]">
                    <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-lg">search</span>
                    <input name="q" value="{{ $queryStr }}" type="text" placeholder="Cari nama, kode ref, atau lokasi..." class="w-full pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-600 transition-all">
                </div>
                <select name="category" class="px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-600">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->name }}" @selected($categoryFilter === $category->name)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <select name="status" class="px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-600">
                    <option value="">Semua Status</option>
                    <option value="Disimpan (Brankas)" @selected($statusFilter === 'Disimpan (Brankas)')>Disimpan (Brankas)</option>
                    <option value="Dikembalikan (Claimed)" @selected($statusFilter === 'Dikembalikan (Claimed)')>Dikembalikan (Claimed)</option>
                    <option value="Diarsipkan" @selected($statusFilter === 'Diarsipkan')>Diarsipkan</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-semibold hover:bg-slate-700">Terapkan</button>
            </div>
            <div class="text-xs text-slate-500 dark:text-slate-400">Total <span class="font-bold text-slate-900 dark:text-white">{{ $items->total() }}</span> Barang</div>
        </form>

        <!-- Main Data Table -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs md:text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 uppercase text-[11px] font-bold border-b border-slate-200 dark:border-slate-800">
                        <tr>
                            <th class="px-6 py-3.5">Kode Ref</th>
                            <th class="px-6 py-3.5">Barang</th>
                            <th class="px-6 py-3.5">Kategori</th>
                            <th class="px-6 py-3.5">Lokasi Penemuan</th>
                            <th class="px-6 py-3.5">Tanggal & Waktu</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($items as $item)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-blue-600 dark:text-blue-400">{{ $item->ref_code }}</td>
                                <td class="px-6 py-4 flex items-center gap-3">
                                    @php
                                        $imageUrl = $item->image_path ?: 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=800';
                                        $imageUrl = str_starts_with($imageUrl, 'http') ? $imageUrl : asset(ltrim($imageUrl, '/'));
                                    @endphp
                                    <img src="{{ $imageUrl }}" class="w-10 h-10 rounded-lg object-cover border border-slate-200 dark:border-slate-800" alt="{{ $item->title }}"/>
                                    <div><div class="font-bold text-slate-900 dark:text-white">{{ $item->title }}</div><div class="text-xs text-slate-400">{{ $item->color ?: 'Warna tidak dicatat' }}{{ $item->brand ? ' - '.$item->brand : '' }}</div></div>
                                </td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $item->category?->name ?: '-' }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $item->location_found }}</td>
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $item->date_found->format('d M Y (H:i)') }}</td>
                                <td class="px-6 py-4"><span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $item->status === 'claimed' ? 'bg-blue-50 text-blue-700 border-blue-200' : ($item->status === 'archived' ? 'bg-slate-100 text-slate-700 border-slate-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200') }} border">{{ $item->status === 'claimed' ? 'Dikembalikan (Claimed)' : ($item->status === 'archived' ? 'Diarsipkan' : 'Disimpan (Brankas)') }}</span></td>
                                <td class="px-6 py-4 text-right space-x-1">
                                    <button @click="selectedItem = {{ $item->loadMissing('category')->toJson() }}; editModalOpen = true" class="p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg" title="Edit Data"><span class="material-symbols-outlined text-lg">edit</span></button>
                                    <button @click="selectedItem = {{ $item->toJson() }}; deleteModalOpen = true" class="p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg" title="Hapus Barang"><span class="material-symbols-outlined text-lg">delete</span></button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-6 py-12 text-center text-slate-500">Belum ada barang temuan yang sesuai.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-slate-100 dark:border-slate-800 flex justify-between items-center text-xs text-slate-500 dark:text-slate-400">
                <div>Menampilkan {{ $items->firstItem() ?: 0 }} - {{ $items->lastItem() ?: 0 }} dari {{ $items->total() }} barang</div>
                <div>{{ $items->appends(request()->query())->links() }}</div>
            </div>
        </div>

        <!-- Add Item Modal -->
        <div x-show="addModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="addModalOpen = false"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-2xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-6 z-10">
                    <div class="flex justify-between items-center border-b border-slate-100 dark:border-slate-800 pb-4">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Tambah Barang Temuan Baru</h3>
                        <button @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600 p-1">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <form action="{{ route('admin.found-items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Nama Barang</label>
                                <input type="text" name="title" placeholder="Contoh: Helm NHK Merah" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-600" required/>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Kategori</label>
                                <select name="category_id" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-600" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Lokasi Penemuan</label>
                                <input type="text" name="location_found" placeholder="Platform 2 Terminal" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-600" required/>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Tanggal Ditemukan</label>
                                <input type="datetime-local" name="date_found" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-600" required/>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Unggah Foto Barang</label>
                            <div class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl p-4 text-center hover:border-blue-600 transition-colors bg-slate-50 dark:bg-slate-800/50 cursor-pointer">
                                <span class="material-symbols-outlined text-3xl text-blue-600">cloud_upload</span>
                                <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="block w-full text-xs text-slate-500 mb-2"/>
                                <p class="text-xs font-bold text-slate-700 dark:text-slate-300">Tarik Foto atau Klik Upload</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input type="text" name="color" placeholder="Warna" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm"/>
                            <input type="text" name="brand" placeholder="Merek" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm"/>
                            <input type="text" name="storage_location" placeholder="Lokasi penyimpanan" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm"/>
                        </div>

                        <textarea name="description" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm" placeholder="Deskripsi barang" required></textarea>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                            <button type="button" @click="addModalOpen = false" class="px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">Batal</button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700">Simpan Barang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Item Modal -->
        <div x-show="editModalOpen && selectedItem" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="editModalOpen = false"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-2xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-6 z-10">
                    <div class="flex justify-between items-center border-b border-slate-100 dark:border-slate-800 pb-4">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Edit Barang Temuan</h3>
                        <button @click="editModalOpen = false" type="button" class="text-slate-400 hover:text-slate-600 p-1"><span class="material-symbols-outlined">close</span></button>
                    </div>
                    <form x-bind:action="'{{ url('admin/found-items') }}/' + selectedItem.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="title" x-model="selectedItem.title" placeholder="Nama Barang" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm" required/>
                            <select name="category_id" x-model="selectedItem.category_id" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm" required>
                                @foreach ($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach
                            </select>
                            <input type="text" name="location_found" x-model="selectedItem.location_found" placeholder="Lokasi Penemuan" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm" required/>
                            <input type="datetime-local" name="date_found" x-bind:value="selectedItem.date_found ? selectedItem.date_found.replace(' ', 'T').slice(0, 16) : ''" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm" required/>
                            <input type="text" name="color" x-model="selectedItem.color" placeholder="Warna" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm"/>
                            <input type="text" name="brand" x-model="selectedItem.brand" placeholder="Merek" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm"/>
                            <input type="text" name="storage_location" x-model="selectedItem.storage_location" placeholder="Lokasi penyimpanan" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm"/>
                            <select name="status" x-model="selectedItem.status" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm" required>
                                <option value="active">Disimpan (Brankas)</option><option value="claimed">Dikembalikan (Claimed)</option><option value="archived">Diarsipkan</option>
                            </select>
                        </div>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="block w-full text-xs text-slate-500"/>
                        <textarea name="description" x-model="selectedItem.description" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm" placeholder="Deskripsi barang" required></textarea>
                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                            <button type="button" @click="editModalOpen = false" class="px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-xl text-sm">Batal</button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="deleteModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="deleteModalOpen = false"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4 z-10 text-center">
                    <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-950/60 text-red-600 flex items-center justify-center mx-auto">
                        <span class="material-symbols-outlined text-2xl">warning</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Konfirmasi Hapus Data Barang</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Apakah Anda yakin ingin menghapus data barang temuan ini? Tindakan ini tidak dapat dibatalkan.</p>
                    <div class="flex justify-center gap-3 pt-2">
                        <button @click="deleteModalOpen = false" class="px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">Batal</button>
                        <form x-bind:action="'{{ url('admin/found-items') }}/' + selectedItem.id" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-5 py-2 bg-red-600 text-white rounded-xl text-sm font-semibold hover:bg-red-700">Hapus Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
