<x-layouts.admin title="Category Management">
    <div x-data="{ modalOpen: false }" class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Manajemen Kategori Barang</h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola taksonomi kategori barang untuk mempermudah filter dan pelatihan AI Vision.</p>
            </div>
            <button @click="modalOpen = true" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-2 cursor-pointer">
                <span class="material-symbols-outlined text-base">add</span>
                <span>Tambah Kategori Baru</span>
            </button>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow overflow-hidden">
            <table class="w-full text-left text-xs md:text-sm">
                <thead class="bg-slate-50 dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 uppercase text-[11px] font-bold border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="px-6 py-3.5">Nama Kategori</th>
                        <th class="px-6 py-3.5">Slug</th>
                        <th class="px-6 py-3.5">Jumlah Barang</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900 dark:text-white flex items-center gap-3">
                            <span class="p-2 bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 rounded-xl material-symbols-outlined text-base">wallet</span>
                            <span>Tas & Dompet</span>
                        </td>
                        <td class="px-6 py-4 font-mono text-slate-500 dark:text-slate-400">tas-dompet</td>
                        <td class="px-6 py-4"><span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">1,420 items</span></td>
                        <td class="px-6 py-4 text-right space-x-1">
                            <button @click="modalOpen = true" class="p-1.5 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg"><span class="material-symbols-outlined text-base">edit</span></button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900 dark:text-white flex items-center gap-3">
                            <span class="p-2 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 rounded-xl material-symbols-outlined text-base">smartphone</span>
                            <span>Elektronik & HP</span>
                        </td>
                        <td class="px-6 py-4 font-mono text-slate-500 dark:text-slate-400">elektronik-hp</td>
                        <td class="px-6 py-4"><span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">980 items</span></td>
                        <td class="px-6 py-4 text-right space-x-1">
                            <button @click="modalOpen = true" class="p-1.5 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg"><span class="material-symbols-outlined text-base">edit</span></button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900 dark:text-white flex items-center gap-3">
                            <span class="p-2 bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 rounded-xl material-symbols-outlined text-base">watch</span>
                            <span>Aksesoris</span>
                        </td>
                        <td class="px-6 py-4 font-mono text-slate-500 dark:text-slate-400">aksesoris</td>
                        <td class="px-6 py-4"><span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800">740 items</span></td>
                        <td class="px-6 py-4 text-right space-x-1">
                            <button @click="modalOpen = true" class="p-1.5 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg"><span class="material-symbols-outlined text-base">edit</span></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Category Modal -->
        <div x-show="modalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="modalOpen = false"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4 z-10">
                    <div class="flex justify-between items-center border-b border-slate-100 dark:border-slate-800 pb-3">
                        <h3 class="font-bold text-slate-900 dark:text-white">Tambah Kategori Baru</h3>
                        <button @click="modalOpen = false" class="text-slate-400">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <form @submit.prevent="modalOpen = false" class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Nama Kategori</label>
                            <input type="text" placeholder="Contoh: Kunci & Otomotif" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-600" required/>
                        </div>

                        <div class="flex justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                            <button type="button" @click="modalOpen = false" class="px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300">Batal</button>
                            <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold hover:bg-blue-700">Simpan Kategori</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
