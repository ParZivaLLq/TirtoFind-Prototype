<x-layouts.admin title="Claim Management">
    <div x-data="{ verifyModalOpen: false, approved: false }" class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Manajemen & Verifikasi Klaim Barang</h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">Verifikasi dokumen bukti kepemilikan dan atur persetujuan klaim barang penumpang Terminal Tirtonadi.</p>
            </div>
            <a href="{{ route('admin.return-report.index') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-base">description</span>
                <span>Berita Acara Pengembalian</span>
            </a>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow overflow-hidden">
            <div class="p-4 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center text-xs text-slate-500 dark:text-slate-400">
                <span>Daftar Permohonan Klaim Masuk</span>
                <span class="font-bold text-slate-900 dark:text-white">5 Perlu Review</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs md:text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 uppercase text-[11px] font-bold border-b border-slate-200 dark:border-slate-800">
                        <tr>
                            <th class="px-6 py-3.5">Kode Klaim</th>
                            <th class="px-6 py-3.5">Pemohon</th>
                            <th class="px-6 py-3.5">Target Barang</th>
                            <th class="px-6 py-3.5">Bukti Upload</th>
                            <th class="px-6 py-3.5">Tanggal Pengajuan</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-slate-900 dark:text-white">#CLM-2024-4401</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 dark:text-white">Budi Santoso</div>
                                <div class="text-xs text-slate-400">KTP: 337201xxxxxxxxx</div>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-800 dark:text-slate-200">Dompet Kulit Imperial Horse (#TF-8912)</td>
                            <td class="px-6 py-4 text-blue-600 dark:text-blue-400 font-semibold flex items-center gap-1">
                                <span class="material-symbols-outlined text-base">attachment</span> KTP & Nota.jpg
                            </td>
                            <td class="px-6 py-4 text-slate-500 dark:text-slate-400">24 Oct 2024 (15:00)</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800">Pending Review</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button @click="verifyModalOpen = true" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold text-xs transition-all shadow-xs cursor-pointer">Verifikasi Berkas</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Verification Modal -->
        <div x-show="verifyModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="verifyModalOpen = false"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-2xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4 z-10">
                    <div class="flex justify-between items-center border-b border-slate-100 dark:border-slate-800 pb-3">
                        <h3 class="font-bold text-slate-900 dark:text-white">Verifikasi Klaim #CLM-2024-4401</h3>
                        <button @click="verifyModalOpen = false" class="text-slate-400">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div class="space-y-2 p-3 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-800">
                            <h4 class="font-bold text-slate-900 dark:text-white">Dokumen KTP Pemohon</h4>
                            <img src="https://images.unsplash.com/photo-1554415707-6e8cfc93fe23?w=300" class="w-full h-32 object-cover rounded-lg border border-slate-300 dark:border-slate-700"/>
                        </div>
                        <div class="space-y-2 p-3 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-800">
                            <h4 class="font-bold text-slate-900 dark:text-white">Bukti Nota / Kepemilikan</h4>
                            <img src="https://images.unsplash.com/photo-1606813907291-d86efa9b94db?w=300" class="w-full h-32 object-cover rounded-lg border border-slate-300 dark:border-slate-700"/>
                        </div>
                    </div>

                    <div x-show="approved" class="p-3 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 rounded-xl text-xs font-semibold flex items-center justify-between">
                        <span>Klaim Disetujui! Berita Acara siap dicetak.</span>
                        <a href="{{ route('admin.return-report.index') }}" class="px-3 py-1 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">Cetak Berita Acara</a>
                    </div>

                    <div class="flex justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                        <button @click="verifyModalOpen = false" class="px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300">Batal</button>
                        <button @click="verifyModalOpen = false" class="px-4 py-2 bg-red-600 text-white rounded-xl text-xs font-semibold hover:bg-red-700">Tolak Klaim</button>
                        <button @click="approved = true" class="px-5 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 shadow-xs cursor-pointer">Setujui Klaim (Approve)</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
