<x-layouts.admin title="Dashboard Console">
    <!-- Section 1: KPI Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Stat 1 -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow">
            <p class="text-[11px] font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider mb-2">Total Found Items</p>
            <div class="flex items-end justify-between">
                <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ number_format($stats['total_found']) }}</h3>
                <span class="text-emerald-700 dark:text-emerald-400 text-xs font-bold flex items-center bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 px-2 py-0.5 rounded-lg">
                    <span class="material-symbols-outlined text-sm mr-0.5">trending_up</span> 12%
                </span>
            </div>
        </div>

        <!-- Stat 2 -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow">
            <p class="text-[11px] font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider mb-2">Active Lost Reports</p>
            <div class="flex items-end justify-between">
                <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ number_format($stats['pending_lost']) }}</h3>
                <span class="text-amber-700 dark:text-amber-400 text-xs font-bold flex items-center bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800 px-2 py-0.5 rounded-lg">
                    <span class="material-symbols-outlined text-sm mr-0.5">trending_down</span> 5%
                </span>
            </div>
        </div>

        <!-- Stat 3 -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow">
            <p class="text-[11px] font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider mb-2">Pending Claims</p>
            <div class="flex items-end justify-between">
                <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ number_format($stats['pending_claims']) }}</h3>
                <span class="text-red-700 dark:text-red-400 text-xs font-bold flex items-center bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-800 px-2 py-0.5 rounded-lg">
                    <span class="material-symbols-outlined text-sm mr-0.5">priority_high</span> 8 Urgent
                </span>
            </div>
        </div>

        <!-- Stat 4 -->
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow">
            <p class="text-[11px] font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider mb-2">Successfully Returned</p>
            <div class="flex items-end justify-between">
                <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ number_format($stats['claimed_found']) }}</h3>
                <span class="text-blue-700 dark:text-blue-400 text-xs font-bold flex items-center bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800 px-2 py-0.5 rounded-lg">
                    <span class="material-symbols-outlined text-sm mr-0.5">check_circle</span> 82% Rate
                </span>
            </div>
        </div>
    </div>

    <!-- Section 2: Recent Claims Table & Latest Found Items -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left 2 Columns: Recent Claims Table -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow flex flex-col overflow-hidden">
            <div class="p-5 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/30">
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Recent Claims</h3>
                <a href="{{ route('admin.claims.index') }}" class="text-xs text-blue-600 dark:text-blue-400 font-semibold hover:underline">View all</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <tr>
                            <th class="px-5 py-3">Item Name</th>
                            <th class="px-5 py-3">Claimant</th>
                            <th class="px-5 py-3">Date</th>
                            <th class="px-5 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($recentClaims as $claim)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-5 py-3.5 font-bold text-slate-900 dark:text-white">{{ $claim->foundItem?->title ?? '-' }}</td>
                                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-300">{{ $claim->claimant_name }}</td>
                                <td class="px-5 py-3.5 text-slate-500 dark:text-slate-400">{{ $claim->created_at?->format('d M Y') }}</td>
                                <td class="px-5 py-3.5">
                                    <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-amber-100/70 dark:bg-amber-900/40 text-amber-800 dark:text-amber-300">{{ $claim->status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-5 py-8 text-center text-slate-500">Belum ada pengajuan klaim.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Column: Latest Found Items -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow flex flex-col overflow-hidden">
            <div class="p-5 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/30">
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Latest Lost Reports</h3>
            </div>

            <div class="p-4 space-y-3 flex-1">
                @forelse ($recentLost as $report)
                    <a href="{{ route('admin.lost-reports.show', $report->id) }}" class="block p-3 rounded-xl border border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $report->item_name }}</h4>
                                <p class="text-[11px] text-slate-400 truncate">{{ $report->report_code }} · {{ $report->reporter_name }}</p>
                            </div>
                            <span class="text-[10px] text-slate-400 font-medium whitespace-nowrap">{{ $report->created_at?->format('d M Y') }}</span>
                        </div>
                        <span class="inline-block mt-2 text-[10px] font-semibold text-amber-700 dark:text-amber-300">{{ $report->status }}</span>
                    </a>
                @empty
                    <p class="py-8 text-center text-xs text-slate-500">Belum ada laporan kehilangan.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Section 3: Monthly Activity Chart & AI Smart Match Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left 2 Columns: Monthly Activity -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 soft-shadow flex flex-col justify-between">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Monthly Activity</h3>
                <div class="flex items-center gap-4 text-xs font-semibold">
                    <span class="flex items-center gap-1.5 text-slate-600 dark:text-slate-300">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span> Found
                    </span>
                    <span class="flex items-center gap-1.5 text-slate-600 dark:text-slate-300">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Returned
                    </span>
                </div>
            </div>

            <!-- Simulated Responsive SVG Bar Chart -->
            <div class="h-64 w-full flex items-end justify-between gap-4 pt-8 px-2 border-b border-slate-200 dark:border-slate-800">
                <!-- May -->
                <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                    <div class="w-full flex justify-center items-end gap-1.5 h-full">
                        <div class="w-4 bg-blue-600 rounded-t-md h-[45%] group-hover:bg-blue-500 transition-all"></div>
                        <div class="w-4 bg-emerald-500 rounded-t-md h-[38%] group-hover:bg-emerald-400 transition-all"></div>
                    </div>
                    <span class="text-[11px] font-medium text-slate-400">May</span>
                </div>

                <!-- Jun -->
                <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                    <div class="w-full flex justify-center items-end gap-1.5 h-full">
                        <div class="w-4 bg-blue-600 rounded-t-md h-[60%] group-hover:bg-blue-500 transition-all"></div>
                        <div class="w-4 bg-emerald-500 rounded-t-md h-[52%] group-hover:bg-emerald-400 transition-all"></div>
                    </div>
                    <span class="text-[11px] font-medium text-slate-400">Jun</span>
                </div>

                <!-- Jul -->
                <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                    <div class="w-full flex justify-center items-end gap-1.5 h-full">
                        <div class="w-4 bg-blue-600 rounded-t-md h-[75%] group-hover:bg-blue-500 transition-all"></div>
                        <div class="w-4 bg-emerald-500 rounded-t-md h-[68%] group-hover:bg-emerald-400 transition-all"></div>
                    </div>
                    <span class="text-[11px] font-medium text-slate-400">Jul</span>
                </div>

                <!-- Aug -->
                <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                    <div class="w-full flex justify-center items-end gap-1.5 h-full">
                        <div class="w-4 bg-blue-600 rounded-t-md h-[55%] group-hover:bg-blue-500 transition-all"></div>
                        <div class="w-4 bg-emerald-500 rounded-t-md h-[48%] group-hover:bg-emerald-400 transition-all"></div>
                    </div>
                    <span class="text-[11px] font-medium text-slate-400">Aug</span>
                </div>

                <!-- Sep -->
                <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                    <div class="w-full flex justify-center items-end gap-1.5 h-full">
                        <div class="w-4 bg-blue-600 rounded-t-md h-[85%] group-hover:bg-blue-500 transition-all"></div>
                        <div class="w-4 bg-emerald-500 rounded-t-md h-[78%] group-hover:bg-emerald-400 transition-all"></div>
                    </div>
                    <span class="text-[11px] font-medium text-slate-400">Sep</span>
                </div>

                <!-- Oct -->
                <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                    <div class="w-full flex justify-center items-end gap-1.5 h-full">
                        <div class="w-4 bg-blue-600 rounded-t-md h-[95%] group-hover:bg-blue-500 transition-all"></div>
                        <div class="w-4 bg-emerald-500 rounded-t-md h-[88%] group-hover:bg-emerald-400 transition-all"></div>
                    </div>
                    <span class="text-[11px] font-medium text-slate-400">Oct</span>
                </div>
            </div>
        </div>

        <!-- Right Column: AI Smart Match Card -->
        <div class="bg-blue-600 dark:bg-blue-700 text-white rounded-2xl p-6 soft-shadow flex flex-col justify-between relative overflow-hidden">
            <!-- Decorative Glow Background -->
            <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>

            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-2xl text-blue-200">auto_awesome</span>
                    <div>
                        <h3 class="text-base font-bold text-white leading-none">AI Smart Match</h3>
                        <p class="text-xs text-blue-100 mt-1">3 new matches found today</p>
                    </div>
                </div>

                <!-- Recommendation Cards List -->
                <div class="space-y-3 mt-4">
                    <!-- Match 1 -->
                    <div class="p-3 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-blue-200 uppercase">Match Score: 98%</span>
                            <div class="text-xs font-semibold text-white mt-0.5">iPhone 14 (Lost) ↔ iPhone (Found)</div>
                        </div>
                        <a href="{{ route('admin.ai-matching.index') }}" class="px-3 py-1 bg-white text-blue-700 font-bold rounded-lg text-xs hover:bg-blue-50 transition-colors shadow-xs">
                            Review
                        </a>
                    </div>

                    <!-- Match 2 -->
                    <div class="p-3 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-blue-200 uppercase">Match Score: 92%</span>
                            <div class="text-xs font-semibold text-white mt-0.5">Blue Suitcase ↔ Samsonite Bag</div>
                        </div>
                        <a href="{{ route('admin.ai-matching.index') }}" class="px-3 py-1 bg-white text-blue-700 font-bold rounded-lg text-xs hover:bg-blue-50 transition-colors shadow-xs">
                            Review
                        </a>
                    </div>

                    <!-- Match 3 -->
                    <div class="p-3 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] font-bold text-blue-200 uppercase">Match Score: 85%</span>
                            <div class="text-xs font-semibold text-white mt-0.5">Car Keys (Toyota) ↔ Silver Keys</div>
                        </div>
                        <a href="{{ route('admin.ai-matching.index') }}" class="px-3 py-1 bg-white text-blue-700 font-bold rounded-lg text-xs hover:bg-blue-50 transition-colors shadow-xs">
                            Review
                        </a>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.ai-matching.index') }}" class="mt-6 w-full py-2.5 bg-white/20 hover:bg-white/30 text-white font-bold rounded-xl text-xs text-center transition-all border border-white/30 block">
                View all recommended matches
            </a>
        </div>
    </div>
</x-layouts.admin>
