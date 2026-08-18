<x-layouts.admin title="Lost Report Management">
    <div x-data="{ detailModalOpen: false }" class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Manajemen Laporan Kehilangan</h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar laporan barang hilang yang diajukan oleh penumpang Terminal Tirtonadi.</p>
            </div>
            <a href="{{ route('admin.ai-matching.index') }}" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-base">psychology</span>
                <span>Pindai AI Matching</span>
            </a>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow overflow-hidden">
            <div class="p-4 border-b border-slate-100 dark:border-slate-800 flex flex-wrap gap-3 items-center justify-between">
                <input type="text" placeholder="Cari nama pelapor atau kata kunci..." class="px-4 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white w-72 focus:outline-none focus:border-blue-600"/>
                <span class="text-xs text-slate-500 dark:text-slate-400">12 Laporan Kehilangan Aktif</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs md:text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 uppercase text-[11px] font-bold border-b border-slate-200 dark:border-slate-800">
                        <tr>
                            <th class="px-6 py-3.5">Kode Laporan</th>
                            <th class="px-6 py-3.5">Nama Pelapor</th>
                            <th class="px-6 py-3.5">Barang Hilang</th>
                            <th class="px-6 py-3.5">Perkiraan Lokasi</th>
                            <th class="px-6 py-3.5">Tanggal</th>
                            <th class="px-6 py-3.5">Status AI</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-slate-900 dark:text-white">#REP-2024-9902</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 dark:text-white">Budi Santoso</div>
                                <div class="text-xs text-slate-400">08123456789</div>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-800 dark:text-slate-200">Dompet Kulit Hitam Imperial Horse</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">Platform 4 Bus Intercity</td>
                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400">24 Oct 2024</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800">
                                    AI Match 94%
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button @click="detailModalOpen = true" class="px-3 py-1.5 bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 rounded-lg font-bold hover:bg-blue-100 text-xs border border-blue-200 dark:border-blue-800 cursor-pointer">Detail & Match</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Detail Modal -->
        <div x-show="detailModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="detailModalOpen = false"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4 z-10">
                    <div class="flex justify-between items-center border-b border-slate-100 dark:border-slate-800 pb-3">
                        <h3 class="font-bold text-slate-900 dark:text-white">Detail Laporan Kehilangan #REP-9902</h3>
                        <button @click="detailModalOpen = false" class="text-slate-400">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    <div class="space-y-2 text-xs text-slate-600 dark:text-slate-300">
                        <div><strong class="text-slate-900 dark:text-white">Pelapor:</strong> Budi Santoso (NIK: 337201xxxxxxxxx)</div>
                        <div><strong class="text-slate-900 dark:text-white">Telepon:</strong> 08123456789</div>
                        <div><strong class="text-slate-900 dark:text-white">Deskripsi:</strong> Dompet kulit hitam berisi KTP dan e-money mandiri.</div>
                        <div class="p-3 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-800 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 rounded-xl font-medium mt-2">
                            ✨ OpenRouter Vision AI menemukan 1 kecocokan 94% dengan Barang Temuan #TF-2024-8912!
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                        <button @click="detailModalOpen = false" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300">Tutup</button>
                        <a href="{{ route('admin.ai-matching.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold hover:bg-indigo-700">Buka AI Matcher Console</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
