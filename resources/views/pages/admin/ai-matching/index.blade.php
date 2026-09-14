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
                        @if($selectedLostReport->reporter_instagram)
                            <div class="flex gap-2">
                                <span class="font-bold text-slate-900 dark:text-white w-28 shrink-0">Instagram:</span>
                                <a href="https://ig.me/m/{{ ltrim($selectedLostReport->reporter_instagram, '@') }}" target="_blank" rel="noopener noreferrer" class="text-pink-600 dark:text-pink-400 font-semibold hover:underline inline-flex items-center gap-1">
                                    <span>@ {{ ltrim($selectedLostReport->reporter_instagram, '@') }}</span>
                                    <span class="material-symbols-outlined text-xs">open_in_new</span>
                                </a>
                            </div>
                        @endif
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
            @php
                $rawPhone = $selectedLostReport->reporter_phone ?? '';
                $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
                if (str_starts_with($cleanPhone, '0')) {
                    $cleanPhone = '62' . substr($cleanPhone, 1);
                }
                
                $waText = "Halo Kak *" . ($selectedLostReport->reporter_name ?? 'Pelapor') . "*! 👋✨\n\n"
                    . "Kabar baik! Tim *Pos Lost & Found Terminal Tirtonadi Surakarta* telah menemukan barang yang terindikasi cocok dengan barang milik Kakak yang dilaporkan hilang. 📦🎉\n\n"
                    . "📋 *Referensi Laporan Kakak:*\n"
                    . "• Kode Laporan: " . ($selectedLostReport->report_code ?? '-') . "\n"
                    . "• Barang Hilang: " . ($selectedLostReport->item_name ?? '-') . "\n\n"
                    . "📦 *Detail Barang Temuan di Pos:*\n"
                    . "• Kode Barang: " . ($selectedFoundItem->ref_code ?? '-') . "\n"
                    . "• Nama Barang: " . ($selectedFoundItem->title ?? '-') . "\n"
                    . "• Lokasi Temu: " . ($selectedFoundItem->location_found ?? '-') . " 📍\n"
                    . "• Tanggal Temu: " . ($selectedFoundItem->date_found?->format('d M Y') ?? '-') . " 📅\n\n"
                    . "Silakan mampir ke *Pos Informasi & Lost Found Terminal Tirtonadi* (Gedung Utama Lantai 1) untuk verifikasi dan pengambilan barang ya Kak! 🏢\n\n"
                    . "Jangan lupa membawa Kartu Identitas (KTP/SIM) saat verifikasi. Jika ada pertanyaan, Kakak bisa langsung membalas pesan ini. 😊🙏\n\n"
                    . "Salam hangat,\n"
                    . "*Tim Petugas Lost & Found Terminal Tirtonadi* 🚌💙";
                    
                $encodedText = urlencode($waText);
                $waAppUrl = "whatsapp://send?phone=" . $cleanPhone . "&text=" . $encodedText;
                $waWebUrl = "https://web.whatsapp.com/send?phone=" . $cleanPhone . "&text=" . $encodedText;

                $igHandle = ltrim(trim($selectedLostReport->reporter_instagram ?? ''), '@');
                $igUrl = $igHandle ? "https://ig.me/m/" . urlencode($igHandle) : null;
            @endphp

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
                        Rekomendasi AI: 
                        <strong class="{{ $score >= 85 ? 'text-emerald-600 dark:text-emerald-400' : ($score >= 50 ? 'text-amber-600 dark:text-amber-400' : 'text-red-500') }} font-bold">
                            @if($score >= 85)
                                Auto-Match (Kecocokan Sangat Tinggi)
                            @elseif($score >= 50)
                                Manual Verification Needed (Verifikasi Manual Dulu)
                            @elseif($score >= 1)
                                Low Match / Review (Kecocokan Sangat Rendah)
                            @else
                                Reject (Diskualifikasi Mutlak - Tidak Cocok)
                            @endif
                        </strong>
                    </div>

                    @if($score >= 50)
                        <div class="flex flex-wrap items-center gap-2">
                            <!-- Direct WhatsApp App Protocol -->
                            <a href="{{ $waAppUrl }}" @click="waSent = true" class="px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md flex items-center gap-2 cursor-pointer transition-all hover:scale-105 active:scale-95">
                                <span class="material-symbols-outlined text-base">chat</span>
                                <span>Buka Aplikasi WA ({{ $score }}%)</span>
                            </a>

                            <!-- Fallback WhatsApp Web Link -->
                            <a href="{{ $waWebUrl }}" target="_blank" rel="noopener noreferrer" @click="waSent = true" class="px-3.5 py-3 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-semibold text-xs rounded-xl transition-all flex items-center gap-1.5" title="Buka via WhatsApp Web">
                                <span class="material-symbols-outlined text-xs">open_in_new</span>
                                <span>WA Web</span>
                            </a>

                            @if($igUrl)
                                <!-- Direct Instagram DM Link -->
                                <button type="button" onclick="copyAndOpenIg('{{ $igUrl }}', {{ json_encode($waText) }})" @click="waSent = true" class="px-4 py-3 rounded-xl text-xs font-bold text-white shadow-md flex items-center gap-2 cursor-pointer transition-all hover:scale-105 active:scale-95" style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); color: #ffffff !important;" title="Kirim Instagram Direct Message ke @{{ $igHandle }}">
                                    <svg class="w-4 h-4 fill-current shrink-0 text-white" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                    <span>DM IG ({{ '@' . $igHandle }})</span>
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="px-4 py-2 bg-red-50 dark:bg-red-950/60 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800 rounded-xl text-xs font-semibold flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-base text-red-500">block</span>
                            <span>Aksi Cepat WA Dinonaktifkan (Skor < 50%)</span>
                        </div>
                    @endif
                </div>

                <div x-show="waSent" x-cloak class="p-4 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 rounded-xl text-xs font-semibold flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">check_circle</span>
                    <span>Notifikasi match {{ $score }}% dikirim ke {{ $selectedLostReport->reporter_name }} ({{ $selectedLostReport->reporter_phone }}).</span>
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

    <script>
        function copyAndOpenIg(url, text) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(function() {
                    alert('📋 Template pesan notifikasi berhasil DISALIN ke clipboard!\n\nSilakan PASTE (Ctrl+V) di kolom chat Instagram DM yang baru saja terbuka. 😊');
                }).catch(function() {
                    fallbackCopy(text);
                });
            } else {
                fallbackCopy(text);
            }
            window.open(url, '_blank');
        }

        function fallbackCopy(text) {
            var el = document.createElement('textarea');
            el.value = text;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            alert('📋 Template pesan notifikasi berhasil DISALIN ke clipboard!\n\nSilakan PASTE (Ctrl+V) di kolom chat Instagram DM yang baru saja terbuka. 😊');
        }
    </script>
</x-layouts.admin>
