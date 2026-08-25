<x-layouts.admin title="Lost Report Management">
    <div class="space-y-6">
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
            <form action="{{ route('admin.lost-reports.index') }}" method="GET" class="p-4 border-b border-slate-100 dark:border-slate-800 flex flex-wrap gap-3 items-center justify-between">
                <div class="flex flex-wrap gap-3">
                    <input name="q" value="{{ $queryStr }}" type="text" placeholder="Cari nama, kode, barang, atau lokasi..." class="px-4 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white w-72 focus:outline-none focus:border-blue-600"/>
                    <select name="category" class="px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->name }}" @selected($categoryFilter === $category->name)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <select name="status" class="px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white">
                        <option value="">Semua Status</option>
                        @foreach (['Menunggu Verifikasi', 'Terverifikasi', 'Selesai'] as $status)
                            <option value="{{ $status }}" @selected($statusFilter === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-xl text-xs font-semibold hover:bg-slate-700">Terapkan</button>
                </div>
                <span class="text-xs text-slate-500 dark:text-slate-400">{{ $reports->total() }} Laporan</span>
            </form>

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
                        @forelse ($reports as $report)
                            @php
                                $topMatch = $report->aiMatchingLogs->first();
                                $statusClass = $report->status === 'Terverifikasi' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : ($report->status === 'Selesai' ? 'bg-blue-50 text-blue-700 border-blue-200' : 'bg-amber-50 text-amber-700 border-amber-200');
                            @endphp
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-slate-900 dark:text-white">{{ $report->report_code }}</td>
                                <td class="px-6 py-4"><div class="font-bold text-slate-900 dark:text-white">{{ $report->reporter_name }}</div><div class="text-xs text-slate-400">{{ $report->reporter_phone }}</div></td>
                                <td class="px-6 py-4 font-medium text-slate-800 dark:text-slate-200">{{ $report->item_name }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $report->location_lost }}</td>
                                <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $report->date_lost->format('d M Y') }}</td>
                                <td class="px-6 py-4"><div><span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusClass }} border">{{ $report->status }}</span></div><div class="text-xs text-indigo-600 mt-1">{{ $topMatch ? 'AI Match '.$topMatch->score.'%' : 'Belum dipindai' }}</div></td>
                                <td class="px-6 py-4 text-right"><a href="{{ route('admin.lost-reports.show', $report->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 rounded-lg font-bold hover:bg-blue-100 text-xs border border-blue-200 dark:border-blue-800"><span class="material-symbols-outlined text-sm">fact_check</span>Detail & Verifikasi</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-6 py-12 text-center text-sm text-slate-500">Belum ada laporan kehilangan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-slate-100 dark:border-slate-800 flex justify-between items-center text-xs text-slate-500 dark:text-slate-400">
                <span>Menampilkan {{ $reports->firstItem() ?: 0 }} - {{ $reports->lastItem() ?: 0 }} dari {{ $reports->total() }} laporan</span>
                <span>{{ $reports->appends(request()->query())->links() }}</span>
            </div>
        </div>
    </div>
</x-layouts.admin>
