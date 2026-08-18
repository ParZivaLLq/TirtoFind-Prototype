<x-layouts.admin title="Report Analytics">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Laporan & Analitik Statistik</h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">Laporan performa penanganan barang hilang & tren pengembalian Terminal Tirtonadi.</p>
            </div>
            <div class="flex gap-3">
                <button onclick="alert('Export Laporan PDF Berhasil Di-download!')" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold rounded-xl text-xs flex items-center gap-1.5 cursor-pointer">
                    <span class="material-symbols-outlined text-base">download</span> Export PDF
                </button>
                <button onclick="alert('Export Laporan Excel Berhasil Di-download!')" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs flex items-center gap-1.5 shadow-xs cursor-pointer">
                    <span class="material-symbols-outlined text-base">table_view</span> Export Excel
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow text-center">
                <span class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Average Claim Time</span>
                <div class="text-3xl font-extrabold text-slate-900 dark:text-white mt-2">1.8 Hari</div>
                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold">35% lebih cepat dibanding manual</span>
            </div>
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow text-center">
                <span class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Vision AI Precision</span>
                <div class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 mt-2">94.8%</div>
                <span class="text-xs text-indigo-600 dark:text-indigo-400 font-semibold">920 auto-matched successfully</span>
            </div>
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow text-center">
                <span class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Total Claims Verified</span>
                <div class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-2">3,942</div>
                <span class="text-xs text-slate-500 dark:text-slate-400">Official Berita Acara printed</span>
            </div>
        </div>
    </div>
</x-layouts.admin>
