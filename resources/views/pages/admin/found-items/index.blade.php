<x-layouts.admin title="Found Item Management">
    <div x-data="{ addModalOpen: false, editModalOpen: false, deleteModalOpen: false, search: '' }" class="space-y-6">
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
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow flex flex-wrap gap-4 items-center justify-between">
            <div class="flex flex-wrap gap-3 flex-1 min-w-[280px]">
                <div class="relative flex-1 min-w-[200px]">
                    <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-lg">search</span>
                    <input x-model="search" type="text" placeholder="Cari nama, kode ref, atau lokasi..." class="w-full pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-600 transition-all">
                </div>
                <select class="px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-600">
                    <option value="">Semua Kategori</option>
                    <option>Tas & Dompet</option>
                    <option>Elektronik</option>
                    <option>Aksesoris</option>
                </select>
                <select class="px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-600">
                    <option value="">Semua Status</option>
                    <option>Disimpan (Brankas)</option>
                    <option>Dikembalikan (Claimed)</option>
                </select>
            </div>
            <div class="text-xs text-slate-500 dark:text-slate-400">Total <span class="font-bold text-slate-900 dark:text-white">4,821</span> Barang</div>
        </div>

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
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-blue-600 dark:text-blue-400">#TF-2024-8912</td>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1627123424574-724758594e93?w=100" class="w-10 h-10 rounded-lg object-cover border border-slate-200 dark:border-slate-800"/>
                                <div>
                                    <div class="font-bold text-slate-900 dark:text-white">Dompet Kulit Pria Imperial Horse</div>
                                    <div class="text-xs text-slate-400">Warna Hitam Pekat - Kartu E-Money & Cash</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">Tas & Dompet</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">Platform 4 Terminal Tirtonadi</td>
                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400">24 Oct 2024 (14:30)</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">Tersimpan Brankas 1</span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-1">
                                <button @click="editModalOpen = true" class="p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg" title="Edit Data">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </button>
                                <button @click="deleteModalOpen = true" class="p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg" title="Hapus Barang">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </td>
                        </tr>

                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-blue-600 dark:text-blue-400">#TF-2024-8911</td>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=100" class="w-10 h-10 rounded-lg object-cover border border-slate-200 dark:border-slate-800"/>
                                <div>
                                    <div class="font-bold text-slate-900 dark:text-white">Samsung Galaxy S23 Ultra</div>
                                    <div class="text-xs text-slate-400">Warna Biru - Casing Transparan</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">Elektronik & HP</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">Ruang Tunggu Zone B</td>
                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400">23 Oct 2024 (09:15)</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800">Dikembalikan (Claimed)</span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-1">
                                <button @click="editModalOpen = true" class="p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg" title="Edit Data">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </button>
                                <button @click="deleteModalOpen = true" class="p-1.5 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg" title="Hapus Barang">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-slate-100 dark:border-slate-800 flex justify-between items-center text-xs text-slate-500 dark:text-slate-400">
                <div>Menampilkan 1 - 2 dari 4,821 barang</div>
                <div class="flex gap-2">
                    <button class="px-3 py-1.5 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-400" disabled>Previous</button>
                    <button class="px-3 py-1.5 bg-blue-600 text-white font-bold rounded-lg">1</button>
                    <button class="px-3 py-1.5 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800">Next</button>
                </div>
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

                    <form @submit.prevent="addModalOpen = false" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Nama Barang</label>
                                <input type="text" placeholder="Contoh: Helm NHK Merah" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-600" required/>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Kategori</label>
                                <select class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-600">
                                    <option>Tas & Dompet</option>
                                    <option>Elektronik & HP</option>
                                    <option>Aksesoris</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Lokasi Penemuan</label>
                                <input type="text" placeholder="Platform 2 Terminal" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-600" required/>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Tanggal Ditemukan</label>
                                <input type="datetime-local" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-600"/>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Unggah Foto Barang</label>
                            <div class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-xl p-4 text-center hover:border-blue-600 transition-colors bg-slate-50 dark:bg-slate-800/50 cursor-pointer">
                                <span class="material-symbols-outlined text-3xl text-blue-600">cloud_upload</span>
                                <p class="text-xs font-bold text-slate-700 dark:text-slate-300">Tarik Foto atau Klik Upload</p>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                            <button type="button" @click="addModalOpen = false" class="px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">Batal</button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700">Simpan Barang</button>
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
                        <button @click="deleteModalOpen = false" class="px-5 py-2 bg-red-600 text-white rounded-xl text-sm font-semibold hover:bg-red-700">Hapus Sekarang</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
