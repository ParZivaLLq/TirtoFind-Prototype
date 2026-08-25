<x-layouts.admin title="Report Analytics">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Laporan & Analitik Statistik</h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">Laporan performa penanganan barang hilang & tren pengembalian Terminal Tirtonadi.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.analytics.export', request()->query()) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base">download</span> Export PDF
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow text-center">
                <span class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Average Claim Time</span>
                <div class="text-3xl font-extrabold text-slate-900 dark:text-white mt-2">{{ $stats['reports_total'] }}</div>
                <span class="text-xs text-slate-500">Total laporan kehilangan</span>
            </div>
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow text-center">
                <span class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Vision AI Precision</span>
                <div class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 mt-2">{{ $stats['match_average'] }}%</div>
                <span class="text-xs text-indigo-600 dark:text-indigo-400 font-semibold">Rata-rata skor matching</span>
            </div>
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow text-center">
                <span class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Total Claims Verified</span>
                <div class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-2">{{ $stats['claims_verified'] }}</div>
                <span class="text-xs text-slate-500 dark:text-slate-400">Klaim disetujui</span>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-bold text-slate-900 dark:text-white">Tren operasional</h2>
                <form class="flex gap-2 text-xs" method="get">
                    <input type="date" name="from" value="{{ optional($from)->format('Y-m-d') }}" class="border rounded-lg px-2 py-1.5" aria-label="Tanggal mulai">
                    <input type="date" name="to" value="{{ optional($to)->format('Y-m-d') }}" class="border rounded-lg px-2 py-1.5" aria-label="Tanggal akhir">
                    <button class="px-3 py-1.5 rounded-lg bg-slate-900 text-white font-semibold">Filter</button>
                </form>
            </div>
            @forelse ($trendDates as $date)
                @php($reportsCount = $trend[$date]->reports ?? 0)
                @php($claimsCount = $claimTrend[$date]->claims ?? 0)
                <div class="grid grid-cols-[90px_1fr_1fr] gap-3 items-center text-xs mb-3">
                    <span class="text-slate-500">{{ $date }}</span>
                    <div><div class="h-2 rounded bg-amber-400" style="width: {{ min(100, $reportsCount * 10) }}%"></div><span class="text-slate-500">{{ $reportsCount }} laporan</span></div>
                    <div><div class="h-2 rounded bg-emerald-500" style="width: {{ min(100, $claimsCount * 10) }}%"></div><span class="text-slate-500">{{ $claimsCount }} klaim</span></div>
                </div>
            @empty
                <p class="text-sm text-slate-500">Belum ada data pada rentang tanggal ini.</p>
            @endforelse
        </div>
    </div>
</x-layouts.admin>
