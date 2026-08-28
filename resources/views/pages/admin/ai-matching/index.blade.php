<x-layouts.admin title="AI Smart Matching">
    <div x-data="{ loading: false, waSent: false }" class="space-y-6">
        <!-- Page Header -->
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow space-y-4">
            <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 text-xs font-semibold rounded-full mb-2">
                        <span class="material-symbols-outlined text-sm">psychology</span>
                        <span>Vision AI Matching Engine v3.2</span>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">AI Smart Matching Console</h1>
                    <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">Pencocokan otomatis berbasis NLP deskripsi menggunakan OpenRouter AI antara laporan kehilangan dan inventaris barang temuan.</p>
                </div>
            </div>

            <!-- Selector Form -->
            <form action="{{ route('admin.ai-matching.scan') }}" method="POST" @submit="loading = true" class="flex flex-col sm:flex-row gap-3 items-end">
                @csrf
                <div class="flex-1">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Laporan Kehilangan</label>
                    <select name="lost_report_id" id="lost_report_id" required
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2.5 border border-slate-200 dark:border-slate-700 rounded-xl text-xs bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">
                        <option value="">Pilih laporan kehilangan</option>
                        @foreach ($lostReports as $report)
                            <option value="{{ $report->id }}" @selected($selectedLostId === $report->id)>{{ $report->report_code }} — {{ $report->item_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Barang Temuan Aktif</label>
                    <select name="found_item_id" id="found_item_id" required
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2.5 border border-slate-200 dark:border-slate-700 rounded-xl text-xs bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200">
                        <option value="">Pilih barang temuan aktif</option>
                        @foreach ($foundItems as $item)
                            <option value="{{ $item->id }}" @selected($selectedFoundId === $item->id)>{{ $item->ref_code }} — {{ $item->title }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all flex items-center gap-2 shadow-xs cursor-pointer whitespace-nowrap">
                    <template x-if="!loading">
                        <span class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base">sync</span>
                            <span>Re-Scan AI</span>
                        </span>
                    </template>
                    <template x-if="loading">
                        <span class="flex items-center gap-1.5">
                            <span class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                            <span>Memproses...</span>
                        </span>
                    </template>
                </button>
            </form>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 rounded-xl text-xs font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-base">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($selectedLostReport && $selectedFoundItem)
            @php
                $score = $matchResult['score'] ?? 0;
                $scoreColor = $score >= 80 ? 'emerald' : ($score >= 60 ? 'amber' : 'red');
                $scoreLabel = $score >= 80 ? 'High Confidence' : ($score >= 60 ? 'Medium Match' : 'Low Match');
                $isAlgorithmic = $matchResult && str_contains($matchResult['reason'] ?? '', 'algoritmik');
            @endphp

            @if ($matchResult)
            <!-- AI Score Header -->
            <div class="bg-linear-to-r from-slate-900 via-slate-900 to-indigo-950 p-6 md:p-8 rounded-2xl text-white shadow-xl flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="space-y-2 text-center md:text-left">
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 text-xs font-bold rounded-full uppercase tracking-wider">Hasil Pemindaian AI Smart Match</span>
                        @if($isAlgorithmic)
                            <span class="px-2 py-0.5 bg-amber-500/20 text-amber-300 border border-amber-500/30 text-[10px] font-bold rounded-full">Fallback Mode</span>
                        @endif
                    </div>
                    <h2 class="text-2xl md:text-3xl font-bold">Kecocokan {{ $score }}% Terdeteksi!</h2>
                    <p class="text-xs md:text-sm text-slate-300 max-w-xl leading-relaxed">
                        {{ $matchResult['reason'] }}
                    </p>
                </div>

                <!-- Score Gauge -->
                <div class="flex items-center gap-4 bg-white/10 backdrop-blur-md px-6 py-4 rounded-2xl border border-white/15">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center shadow-lg ring-4
                        {{ $scoreColor === 'emerald' ? 'bg-emerald-500 ring-emerald-500/30' : ($scoreColor === 'amber' ? 'bg-amber-500 ring-amber-500/30' : 'bg-red-500 ring-red-500/30') }}
                        text-white font-extrabold text-xl">
                        {{ $score }}%
                    </div>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider
                            {{ $scoreColor === 'emerald' ? 'text-emerald-400' : ($scoreColor === 'amber' ? 'text-amber-400' : 'text-red-400') }}">
                            {{ $scoreLabel }}
                        </div>
                        <div class="text-xs text-slate-300">{{ $isAlgorithmic ? 'Algorithmic Analysis' : 'OpenRouter NLP Analysis' }}</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Comparison Panel: Side-by-Side -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left: Lost Report Data -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow space-y-4">
                    <div class="flex justify-between items-center border-b border-slate-100 dark:border-slate-800 pb-3">
                        <span class="text-xs font-bold text-amber-700 dark:border-amber-800 text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/60 px-2.5 py-1 rounded-full border border-amber-200">
                            Laporan Kehilangan ({{ $selectedLostReport->report_code }})
                        </span>
                        <span class="text-xs text-slate-400">{{ $selectedLostReport->reporter_name }}</span>
                    </div>
                    <div class="space-y-2.5 text-xs text-slate-700 dark:text-slate-300">
                        <div class="flex gap-2"><span class="font-bold text-slate-900 dark:text-white w-28 shrink-0">Nama Barang:</span><span>{{ $selectedLostReport->item_name }}</span></div>
                        <div class="flex gap-2"><span class="font-bold text-slate-900 dark:text-white w-28 shrink-0">Kategori:</span><span>{{ $selectedLostReport->category?->name ?? '-' }}</span></div>
                        <div class="flex gap-2"><span class="font-bold text-slate-900 dark:text-white w-28 shrink-0">Warna:</span><span>{{ $selectedLostReport->color ?: '-' }}</span></div>
                        <div class="flex gap-2"><span class="font-bold text-slate-900 dark:text-white w-28 shrink-0">Merek:</span><span>{{ $selectedLostReport->brand ?: '-' }}</span></div>
                        <div class="flex gap-2"><span class="font-bold text-slate-900 dark:text-white w-28 shrink-0">Lokasi Hilang:</span><span>{{ $selectedLostReport->location_lost }}</span></div>
                        <div class="flex gap-2"><span class="font-bold text-slate-900 dark:text-white w-28 shrink-0">Waktu:</span><span>{{ $selectedLostReport->date_lost?->format('d M Y H:i') ?? '-' }}</span></div>
                        @if($selectedLostReport->distinctive_features)
                            <div class="flex gap-2"><span class="font-bold text-slate-900 dark:text-white w-28 shrink-0">Ciri Khusus:</span><span>{{ $selectedLostReport->distinctive_features }}</span></div>
                        @endif
                    </div>
                </div>

                <!-- Right: Found Item Data -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow space-y-4">
                    <div class="flex justify-between items-center border-b border-slate-100 dark:border-slate-800 pb-3">
                        <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 px-2.5 py-1 rounded-full border border-emerald-200 dark:border-emerald-800">
                            Barang Temuan ({{ $selectedFoundItem->ref_code }})
                        </span>
                        <span class="text-xs text-slate-400 capitalize">{{ $selectedFoundItem->status }}</span>
                    </div>
                    <div class="flex items-start gap-4">
                        @if ($selectedFoundItem->image_path)
                            <img src="{{ str_starts_with($selectedFoundItem->image_path, 'http') ? $selectedFoundItem->image_path : asset($selectedFoundItem->image_path) }}"
                                alt="{{ $selectedFoundItem->title }}" class="w-20 h-20 object-cover rounded-xl border border-slate-200 dark:border-slate-800 shrink-0"/>
                        @else
                            <div class="w-20 h-20 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-slate-400">image</span>
                            </div>
                        @endif
                        <div class="space-y-2 text-xs text-slate-700 dark:text-slate-300">
                            <div class="font-bold text-slate-900 dark:text-white text-sm">{{ $selectedFoundItem->title }}</div>
                            <div class="flex gap-2"><span class="font-semibold w-20 shrink-0">Kategori:</span><span>{{ $selectedFoundItem->category?->name ?? '-' }}</span></div>
                            <div class="flex gap-2"><span class="font-semibold w-20 shrink-0">Warna:</span><span>{{ $selectedFoundItem->color ?: '-' }}</span></div>
                            <div class="flex gap-2"><span class="font-semibold w-20 shrink-0">Merek:</span><span>{{ $selectedFoundItem->brand ?: '-' }}</span></div>
                            <div class="flex gap-2"><span class="font-semibold w-20 shrink-0">Lokasi Temu:</span><span>{{ $selectedFoundItem->location_found }}</span></div>
                            <div class="flex gap-2"><span class="font-semibold w-20 shrink-0">Ditemukan:</span><span>{{ $selectedFoundItem->date_found?->format('d M Y') ?? '-' }}</span></div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($matchResult)
            <!-- AI Feature Breakdown Matrix -->
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow space-y-5">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">Analisis Kriteria AI NLP Breakdown</h3>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach([
                        ['label' => 'Warna & Material', 'key' => 'color_match'],
                        ['label' => 'Merek & Tipe', 'key' => 'brand_match'],
                        ['label' => 'Kesesuaian Lokasi', 'key' => 'location_match'],
                        ['label' => 'Rentang Waktu', 'key' => 'time_match'],
                    ] as $criterion)
                        @php $val = (int)($matchResult[$criterion['key']] ?? 0); @endphp
                        <div class="p-3.5 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-800 space-y-1.5">
                            <div class="flex justify-between text-xs font-semibold">
                                <span class="text-slate-700 dark:text-slate-300">{{ $criterion['label'] }}</span>
                                <span class="{{ $val >= 75 ? 'text-emerald-600 dark:text-emerald-400' : ($val >= 50 ? 'text-amber-600 dark:text-amber-400' : 'text-red-500') }}">{{ $val }}%</span>
                            </div>
                            <div class="w-full bg-slate-200 dark:bg-slate-700 h-2 rounded-full overflow-hidden">
                                <div class="h-2 rounded-full transition-all duration-700
                                    {{ $val >= 75 ? 'bg-emerald-500' : ($val >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                                    style="width: {{ $val }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Action Bar -->
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-xs text-slate-500 dark:text-slate-400">
                        Rekomendasi AI: <strong class="{{ $score >= 75 ? 'text-emerald-700 dark:text-emerald-400' : 'text-amber-700 dark:text-amber-400' }} font-bold">{{ $score >= 75 ? 'Tinjau dan konfirmasi kecocokan' : 'Lakukan verifikasi manual terlebih dahulu' }}</strong>
                    </div>
                    <button type="button" @click="waSent = true" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md flex items-center gap-2 cursor-pointer transition-all">
                        <span class="material-symbols-outlined text-base">send</span>
                        <span>Konfirmasi Match & Kirim Notifikasi WA</span>
                    </button>
                </div>

                <div x-show="waSent" x-cloak class="p-4 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 rounded-xl text-xs font-semibold flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">check_circle</span>
                    <span>Notifikasi akan diproses untuk {{ $selectedLostReport->reporter_name }} ({{ $selectedLostReport->reporter_phone }}).</span>
                </div>
            </div>
            @endif

        @else
            <div class="p-10 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow text-center space-y-2">
                <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-700">manage_search</span>
                <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Pilih laporan kehilangan dan barang temuan untuk memulai pencocokan AI.</p>
                <p class="text-xs text-slate-400">Sistem akan otomatis memindai kecocokan saat pemilihan dilakukan.</p>
            </div>
        @endif
    </div>
</x-layouts.admin>
