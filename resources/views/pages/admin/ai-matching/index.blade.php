<x-layouts.admin title="AI Smart Matching">
    <div x-data="{ loading: false, waSent: false }" class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 text-xs font-semibold rounded-full mb-2">
                    <span class="material-symbols-outlined text-sm">psychology</span>
                    <span>Vision AI Matching Engine v3.2</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">AI Smart Matching Console</h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">Pencocokan otomatis berbasis vektor gambar & NLP deskripsi menggunakan OpenRouter API antara laporan kehilangan dan inventaris barang temuan.</p>
            </div>

            <form action="{{ route('admin.ai-matching.scan') }}" method="POST" @submit="loading = true" class="w-full sm:w-auto flex flex-col sm:flex-row gap-2">
                @csrf
                <select name="lost_report_id" required class="px-3 py-2.5 border border-slate-200 dark:border-slate-700 rounded-xl text-xs bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 max-w-xs">
                    <option value="">Pilih laporan kehilangan</option>
                    @foreach ($lostReports as $report)
                        <option value="{{ $report->id }}" @selected($selectedLostId === $report->id)>{{ $report->report_code }} - {{ $report->item_name }}</option>
                    @endforeach
                </select>
                <select name="found_item_id" required class="px-3 py-2.5 border border-slate-200 dark:border-slate-700 rounded-xl text-xs bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 max-w-xs">
                    <option value="">Pilih barang temuan aktif</option>
                    @foreach ($foundItems as $item)
                        <option value="{{ $item->id }}" @selected($selectedFoundId === $item->id)>{{ $item->ref_code }} - {{ $item->title }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all flex items-center gap-2 shadow-xs cursor-pointer whitespace-nowrap">
                    <template x-if="!loading">
                        <span class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base">sync</span>
                            <span>Jalankan Re-Scan OpenRouter AI</span>
                        </span>
                    </template>
                    <template x-if="loading">
                        <span class="flex items-center gap-1.5">
                            <span class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                            <span>Memproses AI...</span>
                        </span>
                    </template>
                </button>
            </form>
        </div>

        <!-- Success Toast Alert -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 rounded-xl text-xs font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-base">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($matchResult && $selectedLostReport && $selectedFoundItem)
        <!-- AI Similarity Score Header Card -->
        <div class="bg-linear-to-r from-slate-900 via-slate-900 to-indigo-950 p-6 md:p-8 rounded-2xl text-white shadow-xl flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="space-y-2 text-center md:text-left">
                <span class="px-3 py-1 bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 text-xs font-bold rounded-full uppercase tracking-wider">Hasil Pemindaian AI Smart Match</span>
                <h2 class="text-2xl md:text-3xl font-bold">Kecocokan {{ $matchResult['score'] }}% Terdeteksi!</h2>
                <p class="text-xs md:text-sm text-slate-300 max-w-xl leading-relaxed">
                    {{ $matchResult['reason'] }}
                </p>
            </div>

            <!-- Score Gauge Circle -->
            <div class="flex items-center gap-4 bg-white/10 backdrop-blur-md px-6 py-4 rounded-2xl border border-white/15">
                <div class="w-16 h-16 rounded-full bg-emerald-500 text-white font-extrabold text-2xl flex items-center justify-center shadow-lg ring-4 ring-emerald-500/30">
                    {{ $matchResult['score'] }}%
                </div>
                <div>
                    <div class="text-xs font-bold uppercase tracking-wider text-emerald-400">
                        {{ $matchResult['score'] >= 90 ? 'High Confidence' : ($matchResult['score'] >= 75 ? 'Medium Match' : 'Low Match') }}
                    </div>
                    <div class="text-xs text-slate-300">OpenRouter NLP Analysis</div>
                </div>
            </div>
        </div>

        <!-- Comparison Panel: Side-by-Side -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left: Lost Report Data -->
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 dark:border-slate-800 pb-3">
                        <span class="text-xs font-bold text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/60 px-2.5 py-1 rounded-full border border-amber-200 dark:border-amber-800">
                        Laporan Kehilangan (#{{ $selectedLostReport->report_code }})
                    </span>
                    <span class="text-xs text-slate-400">Pelapor: {{ $selectedLostReport->reporter_name }}</span>
                </div>
                <div class="space-y-3 text-xs text-slate-700 dark:text-slate-300">
                    <div><strong class="text-slate-900 dark:text-white">Nama Barang:</strong> {{ $selectedLostReport->item_name }}</div>
                    <div><strong class="text-slate-900 dark:text-white">Kategori:</strong> {{ $selectedLostReport->category?->name ?? '-' }}</div>
                    <div><strong class="text-slate-900 dark:text-white">Lokasi Hilang:</strong> {{ $selectedLostReport->location_lost }}</div>
                    <div><strong class="text-slate-900 dark:text-white">Waktu Kejadian:</strong> {{ $selectedLostReport->date_lost?->format('d M Y H:i') ?? '-' }}</div>
                    <div><strong class="text-slate-900 dark:text-white">Deskripsi Pelapor:</strong> {{ $selectedLostReport->distinctive_features ?: 'Tidak ada deskripsi tambahan.' }}</div>
                </div>
            </div>

            <!-- Right: Found Item Data -->
            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 dark:border-slate-800 pb-3">
                        <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 px-2.5 py-1 rounded-full border border-emerald-200 dark:border-emerald-800">
                        Barang Temuan (#{{ $selectedFoundItem->ref_code }})
                    </span>
                    <span class="text-xs text-slate-400">Status: {{ $selectedFoundItem->status }}</span>
                </div>
                <div class="flex items-center gap-4">
                    @if ($selectedFoundItem->image_path)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($selectedFoundItem->image_path) }}" alt="{{ $selectedFoundItem->title }}" class="w-20 h-20 object-cover rounded-xl border border-slate-200 dark:border-slate-800"/>
                    @else
                        <div class="w-20 h-20 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-slate-800 flex items-center justify-center"><span class="material-symbols-outlined text-slate-400">image</span></div>
                    @endif
                    <div class="space-y-1 text-xs text-slate-700 dark:text-slate-300">
                        <div class="font-bold text-slate-900 dark:text-white text-sm">{{ $selectedFoundItem->title }}</div>
                        <div>Lokasi Penemuan: {{ $selectedFoundItem->location_found }}</div>
                        <div>Ditemukan: {{ $selectedFoundItem->date_found?->format('d M Y H:i') ?? '-' }}</div>
                        <div>Penyimpanan: {{ $selectedFoundItem->storage_location ?: '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Feature Breakdown Matrix -->
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow space-y-5">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Analisis Kriteria AI Vision & NLP Breakdown</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-3.5 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-800 space-y-1.5">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-slate-700 dark:text-slate-300">Warna & Material</span>
                        <span class="text-emerald-600 dark:text-emerald-400">{{ $matchResult['color_match'] }}%</span>
                    </div>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $matchResult['color_match'] }}%"></div>
                    </div>
                </div>
                <div class="p-3.5 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-800 space-y-1.5">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-slate-700 dark:text-slate-300">Merek & Tipe</span>
                        <span class="text-emerald-600 dark:text-emerald-400">{{ $matchResult['brand_match'] }}%</span>
                    </div>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $matchResult['brand_match'] }}%"></div>
                    </div>
                </div>
                <div class="p-3.5 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-800 space-y-1.5">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-slate-700 dark:text-slate-300">Kesesuaian Lokasi</span>
                        <span class="text-emerald-600 dark:text-emerald-400">{{ $matchResult['location_match'] }}%</span>
                    </div>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $matchResult['location_match'] }}%"></div>
                    </div>
                </div>
                <div class="p-3.5 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-800 space-y-1.5">
                    <div class="flex justify-between text-xs font-semibold">
                        <span class="text-slate-700 dark:text-slate-300">Rentang Waktu</span>
                        <span class="text-emerald-600 dark:text-emerald-400">{{ $matchResult['time_match'] }}%</span>
                    </div>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $matchResult['time_match'] }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-xs text-slate-500 dark:text-slate-400">Rekomendasi AI: <strong class="text-emerald-700 dark:text-emerald-400 font-bold">{{ $matchResult['score'] >= 75 ? 'Tinjau dan konfirmasi kecocokan' : 'Jangan konfirmasi sebelum verifikasi manual' }}</strong></div>
                <button type="button" @click="waSent = true" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md flex items-center gap-2 cursor-pointer transition-all">
                    <span class="material-symbols-outlined text-base">send</span>
                    <span>Konfirmasi Match & Kirim Notifikasi WA</span>
                </button>
            </div>
            
            <div x-show="waSent" class="p-4 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 rounded-xl text-xs font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-base">check_circle</span>
                <span>Notifikasi akan diproses untuk {{ $selectedLostReport->reporter_name }} ({{ $selectedLostReport->reporter_phone }}).</span>
            </div>
        </div>
        @elseif ($selectedLostId || $selectedFoundId)
            <div class="p-5 bg-amber-50 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800 rounded-xl text-sm">Belum ada hasil AI untuk pasangan ini. Jalankan pemindaian untuk mendapatkan skor berdasarkan data aktual.</div>
        @else
            <div class="p-8 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow text-center text-sm text-slate-500 dark:text-slate-400">Pilih satu laporan kehilangan dan satu barang temuan aktif untuk memulai pencocokan.</div>
        @endif
    </div>
</x-layouts.admin>
