<x-layouts.guest title="Lacak Status Klaim">
    <main class="max-w-3xl mx-auto px-4 md:px-6 py-8 md:py-12">
        <!-- Header -->
        <div class="text-center mb-8">
            <span class="px-3 py-1 bg-blue-100/90 dark:bg-blue-950/70 text-blue-700 dark:text-blue-300 text-[11px] font-bold rounded-full uppercase tracking-wider border border-blue-200 dark:border-blue-800">Tracking System</span>
            <h1 class="text-2xl md:text-4xl font-extrabold text-slate-900 dark:text-white mt-3">Lacak Status Klaim</h1>
            <p class="text-xs md:text-sm text-slate-600 dark:text-slate-400 mt-1.5 max-w-lg mx-auto">
                Masukkan Kode Tiket Klaim (contoh: <code class="bg-slate-100 dark:bg-slate-800 px-1.5 py-0.5 rounded font-mono text-blue-600 dark:text-blue-400">#CL-2026-0001</code> atau <code class="bg-slate-100 dark:bg-slate-800 px-1.5 py-0.5 rounded font-mono text-blue-600 dark:text-blue-400">CL-2026-0001</code>), Nomor WhatsApp, atau Email Anda.
            </p>
        </div>

        <!-- Search Form Card -->
        <div class="bg-white dark:bg-slate-900 p-2 md:p-3 border border-slate-200/80 dark:border-slate-800 rounded-2xl soft-shadow mb-8">
            <form method="GET" action="{{ route('claim.tracking') }}" class="flex flex-col sm:flex-row gap-2">
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
                    <input 
                        type="text" 
                        name="claim_code" 
                        value="{{ $searchKey ?? request('claim_code') }}" 
                        required 
                        class="w-full pl-11 pr-4 py-3 bg-transparent border-none focus:outline-none focus:ring-0 text-xs md:text-sm text-slate-900 dark:text-white placeholder:text-slate-400"
                        placeholder="Masukkan Kode Tiket (#CL-2026-XXXX) atau Nomor WhatsApp..."
                    >
                </div>
                <button type="submit" class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs md:text-sm font-bold transition-all shadow-xs flex items-center justify-center gap-2 cursor-pointer">
                    <span class="material-symbols-outlined text-lg">travel_explore</span>
                    <span>Lacak Tiket</span>
                </button>
            </form>
        </div>

        <!-- Results Section -->
        @if(!empty($searchKey))
            @php
                $matchingClaims = isset($claims) && $claims->count() > 0 ? $claims : ($claim ? collect([$claim]) : collect());
            @endphp

            @if($matchingClaims->count() > 0)
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                            Ditemukan {{ $matchingClaims->count() }} Hasil Permohonan Klaim
                        </h2>
                    </div>

                    @foreach($matchingClaims as $itemClaim)
                        @php
                            $foundItem = $itemClaim->foundItem;
                            $csPhone = (string) config('services.whatsapp.cs_phone', '6281234567890');
                            $waMessage = "Halo Helpdesk Lost & Found Terminal Tirtonadi,\n\nSaya ingin menanyakan status permohonan klaim saya dengan Kode Tiket: {$itemClaim->claim_code}. Mohon infonya. Terima kasih.";
                            $waUrl = "https://wa.me/{$csPhone}?text=" . urlencode($waMessage);

                            // Image preview
                            $imageUrl = $foundItem?->image_path ?: 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=400';
                            $imageUrl = str_starts_with($imageUrl, 'http') ? $imageUrl : asset(ltrim($imageUrl, '/'));
                        @endphp

                        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl p-5 md:p-6 soft-shadow space-y-6">
                            <!-- Card Header & Status Badge -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 dark:border-slate-800 pb-4">
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Kode Tiket Klaim</span>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <h3 class="text-lg md:text-xl font-mono font-extrabold text-slate-900 dark:text-white">{{ $itemClaim->claim_code }}</h3>
                                    </div>
                                </div>

                                <div>
                                    @if($itemClaim->status === 'Disetujui')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 text-xs font-bold border border-emerald-200 dark:border-emerald-800">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                                            <span>Klaim Disetujui (Siap Diambil)</span>
                                        </span>
                                    @elseif($itemClaim->status === 'Ditolak')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-100 dark:bg-rose-950/80 text-rose-800 dark:text-rose-300 text-xs font-bold border border-rose-200 dark:border-rose-800">
                                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                            <span>Klaim Ditolak</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 text-xs font-bold border border-amber-200 dark:border-amber-800">
                                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                            <span>Sedang Diverifikasi Petugas</span>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Progress Stepper / Timeline -->
                            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4 border border-slate-200/60 dark:border-slate-800">
                                <h4 class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-4 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">potted_plant</span>
                                    <span>Tahapan Progres Verifikasi</span>
                                </h4>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 relative">
                                    <!-- Step 1 -->
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-bold flex-shrink-0 shadow-xs">
                                            <span class="material-symbols-outlined text-sm">check</span>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-slate-900 dark:text-white">1. Permohonan Dikirim</p>
                                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">
                                                {{ $itemClaim->created_at ? $itemClaim->created_at->translatedFormat('d M Y, H:i') : '-' }} WIB
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Step 2 -->
                                    <div class="flex items-start gap-3">
                                        @if($itemClaim->status === 'Menunggu Verifikasi')
                                            <div class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center text-xs font-bold flex-shrink-0 shadow-xs ring-4 ring-amber-100 dark:ring-amber-900/40">
                                                <span class="material-symbols-outlined text-sm animate-spin">sync</span>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-amber-700 dark:text-amber-400">2. Verifikasi Berkas & Ciri</p>
                                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Proses validasi identitas & ciri barang</p>
                                            </div>
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-bold flex-shrink-0 shadow-xs">
                                                <span class="material-symbols-outlined text-sm">check</span>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-900 dark:text-white">2. Verifikasi Selesai</p>
                                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Pemeriksaan bukti kepemilikan rampung</p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Step 3 -->
                                    <div class="flex items-start gap-3">
                                        @if($itemClaim->status === 'Disetujui')
                                            <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-bold flex-shrink-0 shadow-xs">
                                                <span class="material-symbols-outlined text-sm">inventory_2</span>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-emerald-700 dark:text-emerald-400">3. Barang Siap Diambil</p>
                                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Tunjukkan KTP & Tiket ke Pos Infomasi</p>
                                            </div>
                                        @elseif($itemClaim->status === 'Ditolak')
                                            <div class="w-8 h-8 rounded-full bg-rose-600 text-white flex items-center justify-center text-xs font-bold flex-shrink-0 shadow-xs">
                                                <span class="material-symbols-outlined text-sm">close</span>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-rose-700 dark:text-rose-400">3. Klaim Ditolak</p>
                                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Bukti/ciri tidak sesuai spesifikasi</p>
                                            </div>
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 flex items-center justify-center text-xs font-bold flex-shrink-0">
                                                <span>3</span>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-400 dark:text-slate-500">3. Keputusan & Pengambilan</p>
                                                <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-0.5">Menunggu hasil verifikasi</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Found Item & Claimant Detail Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Found Item Box -->
                                <div class="border border-slate-200/80 dark:border-slate-800 rounded-xl p-3.5 flex gap-3 items-center bg-slate-50/50 dark:bg-slate-800/30">
                                    <img src="{{ $imageUrl }}" alt="{{ $foundItem?->title ?? 'Barang' }}" class="w-16 h-16 object-cover rounded-lg border border-slate-200 dark:border-slate-700 flex-shrink-0"/>
                                    <div class="text-xs space-y-1">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">Barang Temuan</span>
                                        <h5 class="font-bold text-slate-900 dark:text-white line-clamp-1">{{ $foundItem?->title ?? 'Barang Tidak Ditemukan' }}</h5>
                                        <p class="text-slate-500 dark:text-slate-400 text-[11px]">
                                            Kode Ref: <span class="font-mono font-medium text-slate-700 dark:text-slate-300">{{ $foundItem?->ref_code ?? '-' }}</span>
                                        </p>
                                        @if($foundItem?->storage_location)
                                            <p class="text-slate-600 dark:text-slate-300 text-[11px]">
                                                Pos Simpan: <strong class="text-emerald-600 dark:text-emerald-400">{{ $foundItem->storage_location }}</strong>
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Claimant Info Box -->
                                <div class="border border-slate-200/80 dark:border-slate-800 rounded-xl p-3.5 text-xs space-y-1.5 bg-slate-50/50 dark:bg-slate-800/30">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Data Pemohon</span>
                                    <div class="font-bold text-slate-900 dark:text-white">{{ $itemClaim->claimant_name }}</div>
                                    <div class="text-slate-500 dark:text-slate-400 text-[11px]">No. WhatsApp: {{ $itemClaim->claimant_phone }}</div>
                                    @if($itemClaim->claimant_email)
                                        <div class="text-slate-500 dark:text-slate-400 text-[11px]">Email: {{ $itemClaim->claimant_email }}</div>
                                    @endif
                                    <div class="text-slate-500 dark:text-slate-400 text-[11px]">Status Hubungan: {{ $itemClaim->relationship }}</div>
                                </div>
                            </div>

                            <!-- Footer Actions -->
                            <div class="flex flex-col sm:flex-row justify-between items-center gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                                <div class="text-xs text-slate-500 dark:text-slate-400 text-center sm:text-left">
                                    Ada pertanyaan terkait klaim ini? Hubungi Petugas Helpdesk Terminal Tirtonadi.
                                </div>

                                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-xs flex items-center gap-2 cursor-pointer w-full sm:w-auto justify-center">
                                    <span class="material-symbols-outlined text-base">chat</span>
                                    <span>Tanyakan via WhatsApp</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State / Not Found -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl p-8 text-center soft-shadow space-y-4 max-w-lg mx-auto">
                    <div class="w-16 h-16 bg-rose-50 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 rounded-full flex items-center justify-center mx-auto">
                        <span class="material-symbols-outlined text-3xl">search_off</span>
                    </div>

                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900 dark:text-white">Kode Tiket / Data Klaim Tidak Ditemukan</h3>
                        <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">
                            Tidak ditemukan klaim aktif untuk kata kunci: <strong class="text-slate-800 dark:text-slate-200 font-mono">"{{ $searchKey }}"</strong>
                        </p>
                    </div>

                    <div class="bg-slate-50 dark:bg-slate-800/60 p-4 rounded-xl text-xs text-slate-600 dark:text-slate-300 text-left space-y-2 border border-slate-200/60 dark:border-slate-800">
                        <div class="font-bold text-slate-800 dark:text-slate-200">Tips Pencarian:</div>
                        <ul class="list-disc pl-4 space-y-1 text-[11px] text-slate-500 dark:text-slate-400">
                            <li>Pastikan Kode Tiket lengkap (Contoh: <code class="font-mono text-blue-600 dark:text-blue-400">#CL-2026-0001</code> atau <code class="font-mono text-blue-600 dark:text-blue-400">CL-2026-0001</code>).</li>
                            <li>Coba cari menggunakan <strong>Nomor WhatsApp</strong> yang Anda daftarkan saat klaim.</li>
                            <li>Jika Anda mendaftarkan laporan kehilangan, Anda bisa mencoba kode laporan (<code class="font-mono text-blue-600 dark:text-blue-400">#LR-2026-XXXX</code>).</li>
                        </ul>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 justify-center pt-2">
                        <a href="{{ route('found-items') }}" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-base">search</span>
                            <span>Cari Barang Temuan</span>
                        </a>
                        <a href="{{ route('contact') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-200 text-xs font-bold transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-base">support_agent</span>
                            <span>Pos Informasi Helpdesk</span>
                        </a>
                    </div>
                </div>
            @endif
        @else
            <!-- Initial Search View Guide -->
            <div class="bg-blue-50/60 dark:bg-blue-950/30 border border-blue-100 dark:border-blue-900/40 rounded-2xl p-6 text-center space-y-3">
                <div class="w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center mx-auto shadow-xs">
                    <span class="material-symbols-outlined text-2xl">manage_search</span>
                </div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">Bagaimana cara melacak klaim Anda?</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 max-w-md mx-auto">
                    Ketik nomor tiket klaim yang Anda dapatkan setelah mengisi formulir klaim barang temuan. Tim Helpdesk Terminal Tirtonadi akan memperbarui status klaim Anda secara realtime.
                </p>
            </div>
        @endif
    </main>
</x-layouts.guest>

