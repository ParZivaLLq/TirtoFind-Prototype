<x-layouts.guest title="Lacak Status Laporan & Klaim">
    <div class="max-w-3xl mx-auto px-4 md:px-6 py-6 md:py-10">
        <!-- Header -->
        <div class="text-center mb-8 max-w-xl mx-auto">
            <span class="px-2.5 py-0.5 bg-blue-100/80 text-blue-800 text-[11px] font-bold rounded-full uppercase tracking-wider border border-blue-200">Pelacakan Real-time</span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-2">Lacak Status Laporan & Klaim</h1>
            <p class="text-xs md:text-sm text-slate-600 mt-1">
                Masukkan Kode Tiket Klaim (#CL-), Kode Laporan Kehilangan (#LR-), Nomor HP, atau Email untuk mengecek perkembangan verifikasi barang Anda.
            </p>
        </div>

        <!-- Search Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 soft-shadow p-4 md:p-6 mb-8">
            <form method="GET" action="{{ route('claim.tracking') }}" class="flex flex-col sm:flex-row gap-2.5">
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
                    <input 
                        type="text" 
                        name="claim_code" 
                        value="{{ request('claim_code', $searchKey) }}" 
                        required 
                        placeholder="Masukkan Kode Tiket (#CL- / #LR-), No. HP, atau Instagram" 
                        class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl text-xs md:text-sm focus:outline-none focus:border-blue-600 transition-colors"
                    >
                </div>
                <button type="submit" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl text-xs md:text-sm transition-all shadow-xs flex items-center justify-center gap-2 cursor-pointer flex-shrink-0">
                    <span class="material-symbols-outlined text-base">analytics</span>
                    <span>Lacak Status</span>
                </button>
            </form>
            <div class="mt-3 flex items-center gap-2 text-[11px] text-slate-500 overflow-x-auto pb-1">
                <span class="font-medium text-slate-400">Contoh format:</span>
                <a href="{{ route('claim.tracking', ['claim_code' => '#CL-2026-0001']) }}" class="px-2 py-0.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded font-mono font-medium transition-colors">#CL-2026-0001</a>
                <span class="text-slate-300">•</span>
                <a href="{{ route('claim.tracking', ['claim_code' => '#LR-2026-0004']) }}" class="px-2 py-0.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded font-mono font-medium transition-colors">#LR-2026-0004</a>
                <span class="text-slate-300">•</span>
                <span class="text-slate-400">Dapat menggunakan No. WhatsApp atau Instagram</span>
            </div>
        </div>

        @if(request()->has('claim_code') || $searchKey !== '')
            @php
                $totalResults = ($claims->count() ?? 0) + ($lostReports->count() ?? 0);
            @endphp

            @if($totalResults > 0)
                <!-- Multiple Results Selector (if search returned > 1 item) -->
                @if($totalResults > 1)
                    <div class="mb-6 bg-slate-50 p-3.5 rounded-2xl border border-slate-200">
                        <p class="text-xs font-bold text-slate-700 mb-2">Ditemukan {{ $totalResults }} data terkait pencarian ini:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($claims as $itemClaim)
                                @php
                                    $isSelected = ($claim && $claim->id === $itemClaim->id && request('type', 'claim') === 'claim');
                                @endphp
                                <a href="{{ route('claim.tracking', ['claim_code' => $searchKey, 'type' => 'claim', 'selected_id' => $itemClaim->id]) }}" 
                                   class="px-3 py-1.5 rounded-xl text-xs font-medium border transition-all flex items-center gap-2 {{ $isSelected ? 'bg-blue-600 text-white border-blue-600 font-bold shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100' }}">
                                    <span class="px-1.5 py-0.5 bg-blue-100 text-blue-800 text-[10px] rounded font-bold uppercase">Klaim</span>
                                    <span class="font-mono">{{ $itemClaim->claim_code }}</span>
                                </a>
                            @endforeach

                            @foreach($lostReports as $itemReport)
                                @php
                                    $isSelected = ($lostReport && $lostReport->id === $itemReport->id && (request('type') === 'lost_report' || (!$claim && $lostReport)));
                                @endphp
                                <a href="{{ route('claim.tracking', ['claim_code' => $searchKey, 'type' => 'lost_report', 'selected_id' => $itemReport->id]) }}" 
                                   class="px-3 py-1.5 rounded-xl text-xs font-medium border transition-all flex items-center gap-2 {{ $isSelected ? 'bg-amber-600 text-white border-amber-600 font-bold shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100' }}">
                                    <span class="px-1.5 py-0.5 bg-amber-100 text-amber-800 text-[10px] rounded font-bold uppercase">Laporan</span>
                                    <span class="font-mono">{{ $itemReport->report_code }}</span>
                                    <span class="text-[10px] opacity-80">({{ Str::limit($itemReport->item_name, 15) }})</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Render Lost Report Card if Lost Report active -->
                @if(($lostReport && request('type') === 'lost_report') || ($lostReport && !$claim))
                    <div class="bg-white rounded-2xl border border-slate-200/80 soft-shadow overflow-hidden mb-8">
                        <!-- Top Status Header -->
                        <div class="p-5 md:p-6 bg-slate-900 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Laporan Kehilangan</span>
                                    <span class="text-[10px] px-2 py-0.5 bg-slate-800 text-slate-300 rounded font-mono">{{ $lostReport->created_at?->translatedFormat('d M Y, H:i') }}</span>
                                </div>
                                <h2 class="text-xl md:text-2xl font-mono font-black text-amber-400 flex items-center gap-2">
                                    <span>{{ $lostReport->report_code }}</span>
                                </h2>
                            </div>
                            <div>
                                @php
                                    $reportBadgeClass = match($lostReport->status) {
                                        'Terverifikasi' => 'bg-blue-500/20 text-blue-300 border-blue-500/40',
                                        'Selesai' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40',
                                        default => 'bg-amber-500/20 text-amber-300 border-amber-500/40',
                                    };
                                    $reportIconName = match($lostReport->status) {
                                        'Terverifikasi' => 'verified',
                                        'Selesai' => 'task_alt',
                                        default => 'hourglass_top',
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold border {{ $reportBadgeClass }}">
                                    <span class="material-symbols-outlined text-base">{{ $reportIconName }}</span>
                                    <span>{{ $lostReport->status }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Content Details & Reported Item Info -->
                        <div class="p-5 md:p-6 space-y-6">
                            <!-- Reported Item Details Box -->
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/80 space-y-3">
                                <div class="flex items-start gap-4">
                                    @if($lostReport->image_path)
                                        <img src="{{ asset(ltrim($lostReport->image_path, '/')) }}" alt="{{ $lostReport->item_name }}" class="w-16 h-16 object-cover rounded-xl border border-slate-200 flex-shrink-0"/>
                                    @else
                                        <div class="w-14 h-14 bg-amber-100/80 text-amber-700 rounded-xl border border-amber-200 flex items-center justify-center flex-shrink-0">
                                            <span class="material-symbols-outlined text-2xl">search_hands_free</span>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="text-[10px] font-bold text-amber-700 uppercase tracking-wider bg-amber-100 px-2 py-0.5 rounded border border-amber-200">
                                                {{ $lostReport->category?->name ?? 'Barang Hilang' }}
                                            </span>
                                            <span class="text-xs text-slate-400 font-medium">• {{ $lostReport->date_lost?->translatedFormat('d M Y') }}</span>
                                        </div>
                                        <h3 class="text-base font-extrabold text-slate-900 mt-1 truncate">{{ $lostReport->item_name }}</h3>
                                        <p class="text-xs text-slate-600 mt-0.5">
                                            <span class="font-semibold text-slate-700">Pelapor:</span> {{ $lostReport->reporter_name }} ({{ $lostReport->reporter_phone }})
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs pt-2 border-t border-slate-200/60 text-slate-600">
                                    <div><span class="font-bold text-slate-700">Lokasi Hilang:</span> {{ $lostReport->location_lost }}</div>
                                    <div><span class="font-bold text-slate-700">Warna / Merek:</span> {{ $lostReport->color ?? '-' }} / {{ $lostReport->brand ?? '-' }}</div>
                                    @if($lostReport->distinctive_features)
                                        <div class="sm:col-span-2"><span class="font-bold text-slate-700">Ciri Khusus:</span> {{ $lostReport->distinctive_features }}</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Stepper Progress Timeline for Lost Report -->
                            <div class="space-y-3 pt-1">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Tahapan Proses Laporan Kehilangan</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    @php
                                        $reportStepIndex = match($lostReport->status) {
                                            'Selesai' => 3,
                                            'Terverifikasi' => 2,
                                            default => 1,
                                        };
                                    @endphp

                                    <!-- Step 1 -->
                                    <div class="p-3 rounded-xl border flex items-center gap-3 {{ $reportStepIndex >= 1 ? 'bg-emerald-50/60 border-emerald-200 text-emerald-900' : 'bg-slate-50 border-slate-200 text-slate-400' }}">
                                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 {{ $reportStepIndex >= 1 ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500' }}">
                                            <span class="material-symbols-outlined text-sm">check</span>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold leading-tight">Laporan Masuk</p>
                                            <p class="text-[10px] mt-0.5 opacity-80">Terdaftar di sistem</p>
                                        </div>
                                    </div>

                                    <!-- Step 2 -->
                                    <div class="p-3 rounded-xl border flex items-center gap-3 {{ $reportStepIndex >= 2 ? 'bg-emerald-50/60 border-emerald-200 text-emerald-900' : ($reportStepIndex === 1 ? 'bg-amber-50 border-amber-300 text-amber-900 ring-2 ring-amber-500/20' : 'bg-slate-50 border-slate-200 text-slate-400') }}">
                                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 {{ $reportStepIndex >= 2 ? 'bg-emerald-600 text-white' : ($reportStepIndex === 1 ? 'bg-amber-600 text-white' : 'bg-slate-200 text-slate-500') }}">
                                            @if($reportStepIndex >= 2) <span class="material-symbols-outlined text-sm">check</span> @else 2 @endif
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold leading-tight">Smart AI Scan & Verifikasi</p>
                                            <p class="text-[10px] mt-0.5 opacity-80">Pencocokan sistem</p>
                                        </div>
                                    </div>

                                    <!-- Step 3 -->
                                    <div class="p-3 rounded-xl border flex items-center gap-3 {{ $reportStepIndex >= 3 ? 'bg-emerald-50/60 border-emerald-200 text-emerald-900' : 'bg-slate-50 border-slate-200 text-slate-400' }}">
                                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 {{ $reportStepIndex >= 3 ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500' }}">
                                            @if($reportStepIndex >= 3) <span class="material-symbols-outlined text-sm">check</span> @else 3 @endif
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold leading-tight">Barang Diklaim / Selesai</p>
                                            <p class="text-[10px] mt-0.5 opacity-80">Pengembalian ke pemilik</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- AI Matching Results Section -->
                            @php
                                $matchedLogs = $lostReport->aiMatchingLogs ?? collect();
                            @endphp

                            <div class="pt-3 border-t border-slate-100">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-indigo-600 text-xl">psychology</span>
                                        <h3 class="text-sm font-extrabold text-slate-900">Hasil Pemindaian Smart AI Match</h3>
                                    </div>
                                    @if($matchedLogs->isNotEmpty())
                                        <span class="px-2.5 py-0.5 bg-indigo-100 text-indigo-800 text-[11px] font-bold rounded-full border border-indigo-200">
                                            {{ $matchedLogs->count() }} Barang Ditemukan
                                        </span>
                                    @endif
                                </div>

                                @if($matchedLogs->isNotEmpty())
                                    <div class="space-y-3">
                                        @foreach($matchedLogs as $log)
                                            @if($log->foundItem)
                                                @php
                                                    $foundItem = $log->foundItem;
                                                    $matchScore = $log->score;
                                                    $scoreBadgeColor = $matchScore >= 75 ? 'bg-emerald-100 text-emerald-800 border-emerald-300' : ($matchScore >= 50 ? 'bg-amber-100 text-amber-800 border-amber-300' : 'bg-slate-100 text-slate-700 border-slate-200');
                                                    $foundImg = $foundItem->image_path ?: 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=300';
                                                    $foundImg = str_starts_with($foundImg, 'http') ? $foundImg : asset(ltrim($foundImg, '/'));
                                                @endphp
                                                <div class="bg-gradient-to-r from-slate-50 to-indigo-50/40 p-4 rounded-xl border border-indigo-100/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-xs hover:border-indigo-200 transition-all">
                                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                                        <img src="{{ $foundImg }}" alt="{{ $foundItem->title }}" class="w-16 h-16 object-cover rounded-xl border border-slate-200 flex-shrink-0"/>
                                                        <div class="min-w-0 flex-1">
                                                            <div class="flex items-center gap-2">
                                                                <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded border {{ $scoreBadgeColor }} flex items-center gap-1">
                                                                    <span class="material-symbols-outlined text-xs">auto_awesome</span>
                                                                    <span>{{ $matchScore }}% Match</span>
                                                                </span>
                                                                <span class="text-[11px] font-mono text-slate-400 font-semibold">{{ $foundItem->ref_code }}</span>
                                                            </div>
                                                            <h4 class="text-sm font-extrabold text-slate-900 mt-1 truncate">{{ $foundItem->title }}</h4>
                                                            <p class="text-xs text-slate-500 truncate">
                                                                Ditemukan di: <span class="font-medium text-slate-700">{{ $foundItem->location_found }}</span>
                                                                @if($foundItem->description)
                                                                    • {{ Str::limit($foundItem->description, 45) }}
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2 w-full sm:w-auto flex-shrink-0 justify-end">
                                                        <a href="{{ route('item-detail', $foundItem->id) }}" target="_blank" class="px-3 py-2 bg-white hover:bg-slate-100 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors flex items-center gap-1">
                                                            <span>Lihat Detail</span>
                                                        </a>
                                                        <a href="{{ route('claim', ['id' => $foundItem->id, 'lost_report_code' => $lostReport->report_code]) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-colors shadow-xs flex items-center gap-1.5">
                                                            <span class="material-symbols-outlined text-base">verified_user</span>
                                                            <span>Klaim Barang Ini</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 text-center text-xs text-slate-500">
                                        <span class="material-symbols-outlined text-slate-400 text-2xl mb-1">hourglass_empty</span>
                                        <p class="font-semibold text-slate-700">Pencarian Smart AI Masih Berjalan</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">Sistem secara otomatis akan memberitahu Anda jika ditemukan barang temuan yang cocok di area Terminal Tirtonadi.</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Attached Claims -->
                            @if($lostReport->claims && $lostReport->claims->isNotEmpty())
                                <div class="pt-3 border-t border-slate-100 space-y-2">
                                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Pengajuan Klaim Terkait Laporan Ini</h3>
                                    <div class="space-y-2">
                                        @foreach($lostReport->claims as $attClaim)
                                            <div class="p-3 bg-blue-50/60 rounded-xl border border-blue-100 flex items-center justify-between text-xs">
                                                <div class="flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-blue-600 text-sm">confirmation_number</span>
                                                    <span class="font-mono font-bold text-slate-900">{{ $attClaim->claim_code }}</span>
                                                    <span class="text-slate-500">({{ $attClaim->foundItem?->title ?? 'Barang' }})</span>
                                                </div>
                                                <a href="{{ route('claim.tracking', ['claim_code' => $attClaim->claim_code, 'type' => 'claim', 'selected_id' => $attClaim->id]) }}" class="text-blue-600 font-bold hover:underline flex items-center gap-1 text-[11px]">
                                                    <span>Lacak Tiket Klaim</span>
                                                    <span class="material-symbols-outlined text-xs">arrow_forward</span>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- WhatsApp Contact Helpdesk -->
                            <div class="border-t border-slate-100 pt-4 flex flex-col sm:flex-row items-center justify-between gap-3 bg-amber-50/50 p-4 rounded-xl border border-amber-100">
                                <div class="text-xs text-amber-900">
                                    <p class="font-bold">Ada pertanyaan mengenai Laporan Kehilangan {{ $lostReport->report_code }}?</p>
                                    <p class="text-[11px] text-amber-700 mt-0.5">Petugas Pos Lost & Found Siap membantu mengecek secara fisik barang Anda.</p>
                                </div>
                                @php
                                    $lrMsg = "Halo Kak CS TirtoFind Terminal Tirtonadi 👋✨\n\nSaya mau menanyakan update Laporan Kehilangan saya nih:\n• Kode Laporan: {$lostReport->report_code}\n• Nama Pelapor: {$lostReport->reporter_name}\n• Barang Hilang: {$lostReport->item_name}\n\nMohon bantuannya Kak untuk diproses. Terima kasih! 🙏";
                                    $waReportUrl = "https://wa.me/{$csPhone}?text=" . urlencode($lrMsg);
                                @endphp
                                <a href="{{ $waReportUrl }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition-all flex items-center gap-1.5 flex-shrink-0">
                                    <span class="material-symbols-outlined text-base">chat</span>
                                    <span>Tanya CS WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @elseif($claim)
                    <!-- Main Claim Detail Card -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 soft-shadow overflow-hidden mb-8">
                        <!-- Top Status Header -->
                        <div class="p-5 md:p-6 bg-slate-900 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tiket Klaim</span>
                                    <span class="text-[10px] px-2 py-0.5 bg-slate-800 text-slate-300 rounded font-mono">{{ $claim->created_at?->translatedFormat('d M Y, H:i') }}</span>
                                </div>
                                <h2 class="text-xl md:text-2xl font-mono font-black text-emerald-400 flex items-center gap-2">
                                    <span>{{ $claim->claim_code }}</span>
                                </h2>
                            </div>
                            <div>
                                @php
                                    $badgeClass = match($claim->status) {
                                        'Disetujui' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40',
                                        'Ditolak' => 'bg-red-500/20 text-red-300 border-red-500/40',
                                        default => 'bg-amber-500/20 text-amber-300 border-amber-500/40',
                                    };
                                    $iconName = match($claim->status) {
                                        'Disetujui' => 'check_circle',
                                        'Ditolak' => 'cancel',
                                        default => 'hourglass_top',
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold border {{ $badgeClass }}">
                                    <span class="material-symbols-outlined text-base">{{ $iconName }}</span>
                                    <span>{{ $claim->status }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Content Details & Item Info -->
                        <div class="p-5 md:p-6 space-y-6">
                            <!-- Target Item Info Box -->
                            @if($claim->foundItem)
                                @php
                                    $imageUrl = $claim->foundItem->image_path ?: 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=300';
                                    $imageUrl = str_starts_with($imageUrl, 'http') ? $imageUrl : asset(ltrim($imageUrl, '/'));
                                @endphp
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/80 flex items-center gap-4">
                                    <img src="{{ $imageUrl }}" alt="{{ $claim->foundItem->title }}" class="w-16 h-16 object-cover rounded-xl border border-slate-200 flex-shrink-0"/>
                                    <div class="flex-1 min-w-0">
                                        <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Barang Diklaim</span>
                                        <h3 class="text-sm font-bold text-slate-900 truncate">{{ $claim->foundItem->title }}</h3>
                                        <p class="text-xs text-slate-500 truncate">Ref: <span class="font-mono font-semibold">{{ $claim->foundItem->ref_code }}</span> • Ditemukan di {{ $claim->foundItem->location_found }}</p>
                                    </div>
                                    <a href="{{ route('item-detail', $claim->foundItem->id) }}" target="_blank" class="px-3 py-1.5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 text-xs font-bold rounded-lg transition-colors flex items-center gap-1 flex-shrink-0">
                                        <span>Lihat</span>
                                        <span class="material-symbols-outlined text-xs">open_in_new</span>
                                    </a>
                                </div>
                            @endif

                            <!-- Status Explanation Alert -->
                            <div class="p-4 rounded-xl text-xs md:text-sm leading-relaxed border {{ $claim->status === 'Disetujui' ? 'bg-emerald-50 text-emerald-900 border-emerald-200' : ($claim->status === 'Ditolak' ? 'bg-red-50 text-red-900 border-red-200' : 'bg-amber-50 text-amber-900 border-amber-200') }}">
                                <div class="font-bold mb-1 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-base">info</span>
                                    <span>Keterangan Status Verifikasi:</span>
                                </div>
                                <p>{{ $claim->statusMessage() }}</p>
                            </div>

                            <!-- Stepper Progress Timeline -->
                            <div class="space-y-3 pt-2">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Progres Verifikasi Tiket</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                                    @php
                                        $steps = $claim->statusSteps();
                                        $currentStepIndex = match($claim->status) {
                                            'Disetujui' => 2, // Reached Decision (Approved)
                                            'Ditolak' => 2,   // Reached Decision (Rejected)
                                            default => 1,     // In Verification
                                        };
                                    @endphp

                                    @foreach($steps as $idx => $stepName)
                                        @php
                                            $isCompleted = $idx < $currentStepIndex || ($idx === 2 && $claim->status === 'Disetujui');
                                            $isCurrent = $idx === $currentStepIndex && $claim->status === 'Menunggu Verifikasi';
                                            $isRejectedStep = $idx === 2 && $claim->status === 'Ditolak';
                                        @endphp
                                        <div class="p-3 rounded-xl border flex sm:flex-col items-center sm:items-start gap-3 transition-all {{ $isCompleted ? 'bg-emerald-50/60 border-emerald-200 text-emerald-900' : ($isRejectedStep ? 'bg-red-50/60 border-red-200 text-red-900' : ($isCurrent ? 'bg-blue-50 border-blue-300 text-blue-900 ring-2 ring-blue-500/20' : 'bg-slate-50 border-slate-200 text-slate-400')) }}">
                                            <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 {{ $isCompleted ? 'bg-emerald-600 text-white' : ($isRejectedStep ? 'bg-red-600 text-white' : ($isCurrent ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-500')) }}">
                                                @if($isCompleted)
                                                    <span class="material-symbols-outlined text-sm">check</span>
                                                @elseif($isRejectedStep)
                                                    <span class="material-symbols-outlined text-sm">close</span>
                                                @else
                                                    {{ $idx + 1 }}
                                                @endif
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold leading-tight">{{ $stepName }}</p>
                                                <p class="text-[10px] mt-0.5 opacity-80">
                                                    @if($idx === 0) Data diterima
                                                    @elseif($idx === 1) Pemeriksaan ciri
                                                    @elseif($idx === 2) {{ $claim->status }}
                                                    @elseif($idx === 3) Pos Tirtonadi
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Contextual Actions & WhatsApp Appointment Generator -->
                            @if($claim->status === 'Disetujui')
                                <div class="border-t border-slate-100 pt-5 space-y-4">
                                    <div>
                                        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-emerald-600">event_available</span>
                                            <span>Jadwalkan Pengambilan Barang di Pos</span>
                                        </h3>
                                        <p class="text-xs text-slate-500 mt-0.5">Pilih tanggal dan jam rencana kedatangan Anda ke Pos Lost & Found Terminal Tirtonadi.</p>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 bg-slate-50 p-4 rounded-xl border border-slate-200/80">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Rencana Tanggal Pengambilan</label>
                                            <input id="pickup-date" type="date" min="{{ now()->format('Y-m-d') }}" value="{{ now()->format('Y-m-d') }}" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs md:text-sm bg-white focus:outline-none focus:border-emerald-600">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-1">Rencana Jam Pengambilan</label>
                                            <input id="pickup-time" type="time" value="10:00" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs md:text-sm bg-white focus:outline-none focus:border-emerald-600">
                                        </div>
                                    </div>

                                    @php
                                        $initialMsg = "Halo Kak CS TirtoFind Terminal Tirtonadi 👋✨\n\nSaya mau konfirmasi rencana jadwal pengambilan barang yang sudah disetujui nih:\n• Kode Klaim: {$claim->claim_code}\n• Nama Pemohon: {$claim->claimant_name}\n• Barang: " . ($claim->foundItem?->title ?? 'Barang Temuan') . "\n• Rencana Pengambilan: " . now()->format('d M Y') . " (Jam 10:00 WIB) ⏰\n\nMohon bantuannya ya Kak. Terima kasih banyak! 😊🙏";
                                        $waInitialUrl = "https://wa.me/{$csPhone}?text=" . urlencode($initialMsg);
                                    @endphp

                                    <div class="flex flex-col sm:flex-row gap-3 pt-1">
                                        <a id="schedule-link" href="{{ $waInitialUrl }}" target="_blank" rel="noopener noreferrer" class="px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs md:text-sm transition-all shadow-xs flex items-center justify-center gap-2 flex-1">
                                            <span class="material-symbols-outlined text-base">chat</span>
                                            <span>Konfirmasi Jadwal via WhatsApp CS</span>
                                        </a>
                                    </div>
                                </div>
                            @elseif($claim->status === 'Ditolak')
                                <div class="border-t border-slate-100 pt-4 flex flex-col sm:flex-row items-center justify-between gap-3 bg-red-50/50 p-4 rounded-xl border border-red-100">
                                    <div class="text-xs text-red-900">
                                        <p class="font-bold">Butuh klarifikasi mengenai penolakan klaim ini?</p>
                                        <p class="text-[11px] text-red-700 mt-0.5">Hubungi Petugas Helpdesk untuk menyampaikan dokumen tambahan atau info ciri khusus lainnya.</p>
                                    </div>
                                    @php
                                        $rejectMsg = "Halo Kak CS TirtoFind 👋\n\nSaya mau minta bantuan & penjelasan mengenai status klaim saya yang ditolak nih:\n• Kode Klaim: {$claim->claim_code}\n• Nama: {$claim->claimant_name}\n\nSaya ada info / bukti tambahan yang ingin disampaikan Kak. Mohon bantuannya ya. Terima kasih! 🙏";
                                        $waRejectUrl = "https://wa.me/{$csPhone}?text=" . urlencode($rejectMsg);
                                    @endphp
                                    <a href="{{ $waRejectUrl }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-xs transition-all flex items-center gap-1.5 flex-shrink-0">
                                        <span class="material-symbols-outlined text-base">chat</span>
                                        <span>Hubungi Helpdesk WA</span>
                                    </a>
                                </div>
                            @else
                                <div class="border-t border-slate-100 pt-4 flex flex-col sm:flex-row items-center justify-between gap-3 bg-blue-50/50 p-4 rounded-xl border border-blue-100">
                                    <div class="text-xs text-blue-900">
                                        <p class="font-bold">Permohonan klaim Anda sedang diproses</p>
                                        <p class="text-[11px] text-blue-700 mt-0.5">Proses verifikasi membutuhkan waktu maksimal 1x24 jam kerja.</p>
                                    </div>
                                    @php
                                        $pendingMsg = "Halo Kak CS TirtoFind 👋✨\n\nSaya mau menanyakan progres verifikasi klaim barang saya nih Kak:\n• Kode Klaim: {$claim->claim_code}\n• Nama: {$claim->claimant_name}\n\nKira-kira sudah sejauh mana ya Kak statusnya? Terima kasih banyak! 😊";
                                        $waPendingUrl = "https://wa.me/{$csPhone}?text=" . urlencode($pendingMsg);
                                    @endphp
                                    <a href="{{ $waPendingUrl }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition-all flex items-center gap-1.5 flex-shrink-0">
                                        <span class="material-symbols-outlined text-base">chat</span>
                                        <span>Tanya CS WhatsApp</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @else
                <!-- Not Found State -->
                <div class="bg-white rounded-2xl border border-slate-200/80 p-8 text-center space-y-4 soft-shadow">
                    <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto border border-red-100">
                        <span class="material-symbols-outlined text-3xl">search_off</span>
                    </div>
                    <div class="max-w-md mx-auto">
                        <h2 class="text-base md:text-lg font-extrabold text-slate-900">Data Tiket / Laporan Tidak Ditemukan</h2>
                        <p class="text-xs md:text-sm text-slate-500 mt-1">
                            Kode tiket <span class="font-mono font-bold text-slate-700">"{{ request('claim_code', $searchKey) }}"</span> tidak terdaftar di sistem kami.
                        </p>
                    </div>
                    <div class="pt-2 flex flex-col sm:flex-row gap-2.5 justify-center">
                        <a href="{{ route('found-items') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors">
                            Cari Barang Temuan
                        </a>
                        <a href="{{ route('lost-report') }}" class="px-4 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold transition-colors">
                            Buat Laporan Kehilangan
                        </a>
                        <a href="{{ route('contact') }}" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-colors">
                            Hubungi Pos Informasi
                        </a>
                    </div>
                </div>
            @endif
        @endif
    </div>

    @if (isset($claim) && $claim?->status === 'Disetujui')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const dateInput = document.getElementById('pickup-date');
                const timeInput = document.getElementById('pickup-time');
                const scheduleLink = document.getElementById('schedule-link');
                
                if (dateInput && timeInput && scheduleLink) {
                    const csPhone = @json($csPhone ?? '6281234567890');
                    const claimCode = @json($claim->claim_code);
                    const claimantName = @json($claim->claimant_name);
                    const itemTitle = @json($claim->foundItem?->title ?? 'Barang Temuan');

                    const updateScheduleLink = () => {
                        const date = dateInput.value || '-';
                        const time = timeInput.value || '-';
                        const message = `Halo CS TirtoFind Terminal Tirtonadi,\n\nSaya ingin mengonfirmasi jadwal pengambilan barang yang telah disetujui:\n- Kode Tiket Klaim: ${claimCode}\n- Nama Pemohon: ${claimantName}\n- Barang: ${itemTitle}\n- Tanggal Pengambilan: ${date}\n- Jam Rencana: ${time} WIB\n\nMohon konfirmasi ketersediaannya. Terima kasih.`;
                        scheduleLink.href = `https://wa.me/${csPhone}?text=${encodeURIComponent(message)}`;
                    };

                    dateInput.addEventListener('change', updateScheduleLink);
                    timeInput.addEventListener('change', updateScheduleLink);
                }
            });
        </script>
    @endif
</x-layouts.guest>
