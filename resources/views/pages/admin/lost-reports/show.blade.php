<x-layouts.admin title="Detail Laporan Kehilangan">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow">
            <div>
                <a href="{{ route('admin.lost-reports.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-700 mb-3">
                    <span class="material-symbols-outlined text-base">arrow_back</span>
                    Kembali ke laporan
                </a>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Detail Laporan Kehilangan</h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $report->report_code }} · Dibuat {{ $report->created_at->format('d M Y H:i') }}</p>
            </div>
            <form action="{{ route('admin.lost-reports.update-status', $report->id) }}" method="POST" class="flex items-center gap-2">
                @csrf
                @method('PUT')
                <label for="status" class="text-xs font-semibold text-slate-600 dark:text-slate-300">Status</label>
                <select id="status" name="status" class="px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white">
                    @foreach (['Menunggu Verifikasi', 'Terverifikasi', 'Selesai'] as $status)
                        <option value="{{ $status }}" @selected($report->status === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold">Simpan</button>
            </form>
        </div>

        @if (session('success'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 rounded-xl text-xs font-semibold">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="p-4 bg-red-50 dark:bg-red-950/60 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-800 rounded-xl text-xs font-semibold">{{ $errors->first() }}</div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Informasi Barang Hilang</h2>
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800">{{ $report->status }}</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div><div class="text-xs text-slate-400 mb-1">Nama Barang</div><div class="font-semibold text-slate-900 dark:text-white">{{ $report->item_name }}</div></div>
                    <div><div class="text-xs text-slate-400 mb-1">Kategori</div><div class="font-semibold text-slate-900 dark:text-white">{{ $report->category?->name ?: '-' }}</div></div>
                    <div><div class="text-xs text-slate-400 mb-1">Warna</div><div class="font-semibold text-slate-900 dark:text-white">{{ $report->color ?: '-' }}</div></div>
                    <div><div class="text-xs text-slate-400 mb-1">Merek</div><div class="font-semibold text-slate-900 dark:text-white">{{ $report->brand ?: '-' }}</div></div>
                    <div><div class="text-xs text-slate-400 mb-1">Lokasi Hilang</div><div class="font-semibold text-slate-900 dark:text-white">{{ $report->location_lost }}</div></div>
                    <div><div class="text-xs text-slate-400 mb-1">Tanggal Hilang</div><div class="font-semibold text-slate-900 dark:text-white">{{ $report->date_lost->format('d M Y H:i') }}</div></div>
                </div>
                <div class="border-t border-slate-100 dark:border-slate-800 pt-4">
                    <div class="text-xs text-slate-400 mb-1">Ciri-ciri / Deskripsi</div>
                    <p class="text-sm text-slate-700 dark:text-slate-300 whitespace-pre-line">{{ $report->distinctive_features ?: 'Tidak ada deskripsi tambahan.' }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow space-y-4">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Data Pelapor</h2>
                <div class="space-y-3 text-sm">
                    <div><div class="text-xs text-slate-400 mb-1">Nama</div><div class="font-semibold text-slate-900 dark:text-white">{{ $report->reporter_name }}</div></div>
                    <div>
                        <div class="text-xs text-slate-400 mb-1">Telepon (WhatsApp)</div>
                        <div class="font-semibold text-slate-900 dark:text-white flex items-center justify-between gap-2">
                            <span>{{ $report->reporter_phone }}</span>
                            @php
                                $rawPhone = $report->reporter_phone ?? '';
                                $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
                                if (str_starts_with($cleanPhone, '0')) {
                                    $cleanPhone = '62' . substr($cleanPhone, 1);
                                }
                            @endphp
                            <div class="flex items-center gap-1">
                                <a href="whatsapp://send?phone={{ $cleanPhone }}" class="px-2 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold shadow-xs inline-flex items-center gap-1">
                                    <span>WA App</span>
                                </a>
                                <a href="https://web.whatsapp.com/send?phone={{ $cleanPhone }}" target="_blank" rel="noopener noreferrer" class="px-2 py-1 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 rounded-lg text-xs font-semibold hover:bg-slate-200 inline-flex items-center gap-1 border border-slate-200 dark:border-slate-700">
                                    <span>Web</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @if($report->reporter_instagram)
                        <div>
                            <div class="text-xs text-slate-400 mb-1">Instagram</div>
                            <div class="font-semibold text-pink-600 dark:text-pink-400 flex items-center justify-between gap-2">
                                <span>@ {{ ltrim($report->reporter_instagram, '@') }}</span>
                                @php
                                    $defaultIgText = "Halo Kak *" . ($report->reporter_name ?? 'Pelapor') . "*! 👋✨\n\n"
                                        . "Kami dari Tim *Pos Lost & Found Terminal Tirtonadi Surakarta* menghubungi Kakak terkait Laporan Kehilangan dengan Kode Laporan: *" . ($report->report_code ?? '-') . "* (" . ($report->item_name ?? '-') . ").\n\n"
                                        . "Jika ada hal yang ingin ditanyakan, Kakak bisa langsung membalas pesan ini ya! 😊🙏\n\n"
                                        . "Salam hangat,\n"
                                        . "*Tim Petugas Lost & Found Terminal Tirtonadi* 🚌💙";
                                @endphp
                                <button type="button" onclick="copyAndOpenIg('https://ig.me/m/{{ ltrim($report->reporter_instagram, '@') }}', {{ json_encode($defaultIgText) }})" class="px-3 py-1.5 rounded-xl text-xs font-bold text-white shadow-xs hover:opacity-90 inline-flex items-center gap-1.5 transition-all hover:scale-105 cursor-pointer" style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); color: #ffffff !important;">
                                    <svg class="w-3.5 h-3.5 fill-current shrink-0 text-white" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                    <span>DM IG</span>
                                </button>
                            </div>
                        </div>
                    @endif
                    <div><div class="text-xs text-slate-400 mb-1">Identitas</div><div class="font-semibold text-slate-900 dark:text-white">{{ $report->reporter_id_type }} · {{ $report->reporter_id_number }}</div></div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow overflow-hidden">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Hasil Matching Barang Temuan</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $matches->count() }} kandidat ditemukan berdasarkan analisis AI.</p>
            </div>
            @forelse ($matches as $match)
                @if ($match->foundItem)
                    @php
                        $matchImage = $match->foundItem->image_path ?: 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=800';
                        $matchImage = str_starts_with($matchImage, 'http') ? $matchImage : asset(ltrim($matchImage, '/'));

                        $rawPhone = $report->reporter_phone ?? '';
                        $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
                        if (str_starts_with($cleanPhone, '0')) {
                            $cleanPhone = '62' . substr($cleanPhone, 1);
                        }

                        $waText = "Halo Kak *" . ($report->reporter_name ?? 'Pelapor') . "*! 👋✨\n\n"
                            . "Kabar baik! Tim *Pos Lost & Found Terminal Tirtonadi Surakarta* telah menemukan barang yang terindikasi cocok dengan barang milik Kakak yang dilaporkan hilang. 📦🎉\n\n"
                            . "📋 *Referensi Laporan Kakak:*\n"
                            . "• Kode Laporan: " . ($report->report_code ?? '-') . "\n"
                            . "• Barang Hilang: " . ($report->item_name ?? '-') . "\n\n"
                            . "📦 *Detail Barang Temuan di Pos:*\n"
                            . "• Kode Barang: " . ($match->foundItem->ref_code ?? '-') . "\n"
                            . "• Nama Barang: " . ($match->foundItem->title ?? '-') . "\n"
                            . "• Lokasi Temu: " . ($match->foundItem->location_found ?? '-') . " 📍\n"
                            . "• Tanggal Temu: " . ($match->foundItem->date_found?->format('d M Y') ?? '-') . " 📅\n\n"
                            . "Silakan mampir ke *Pos Informasi & Lost Found Terminal Tirtonadi* (Gedung Utama Lantai 1) untuk verifikasi dan pengambilan barang ya Kak! 🏢\n\n"
                            . "Jangan lupa membawa Kartu Identitas (KTP/SIM) saat verifikasi. Jika ada pertanyaan, Kakak bisa langsung membalas pesan ini. 😊🙏\n\n"
                            . "Salam hangat,\n"
                            . "*Tim Petugas Lost & Found Terminal Tirtonadi* 🚌💙";

                        $encodedText = urlencode($waText);
                        $waAppUrl = "whatsapp://send?phone=" . $cleanPhone . "&text=" . $encodedText;
                        $waWebUrl = "https://web.whatsapp.com/send?phone=" . $cleanPhone . "&text=" . $encodedText;

                        $igHandle = ltrim(trim($report->reporter_instagram ?? ''), '@');
                        $igUrl = $igHandle ? "https://ig.me/m/" . urlencode($igHandle) : null;
                    @endphp
                    <div class="p-6 border-b last:border-b-0 border-slate-100 dark:border-slate-800 space-y-4">
                        <div class="flex flex-col md:flex-row gap-4 md:items-center justify-between">
                            <div class="flex items-center gap-4">
                                <img src="{{ $matchImage }}" alt="{{ $match->foundItem->title }}" class="w-16 h-16 rounded-xl object-cover border border-slate-200 dark:border-slate-800 shrink-0">
                                <div>
                                    <div class="font-bold text-slate-900 dark:text-white">{{ $match->foundItem->title }}</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $match->foundItem->ref_code }} · {{ $match->foundItem->location_found }}</div>
                                    @if ($match->reason)<div class="text-xs text-slate-500 dark:text-slate-400 mt-1 text-slate-600 dark:text-slate-300 font-medium">{{ $match->reason }}</div>@endif
                                </div>
                            </div>
                            <div class="text-left md:text-right">
                                <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $match->score }}%</div>
                                <div class="text-xs text-slate-400">Skor kecocokan</div>
                            </div>
                        </div>

                        <!-- Notification Action Buttons -->
                        <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-slate-100 dark:border-slate-800/60 bg-slate-50/50 dark:bg-slate-800/30 p-3 rounded-xl">
                            <span class="text-xs font-semibold text-slate-600 dark:text-slate-400 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm text-indigo-500">send</span>
                                Kirim Notifikasi Cocok ({{ $match->score }}%):
                            </span>
                            <div class="flex flex-wrap items-center gap-2">
                                <a href="{{ $waAppUrl }}" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg shadow-xs flex items-center gap-1.5 transition-all">
                                    <span class="material-symbols-outlined text-sm">chat</span>
                                    <span>Buka WA App</span>
                                </a>
                                <a href="{{ $waWebUrl }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 bg-white dark:bg-slate-800 hover:bg-slate-100 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 font-semibold text-xs rounded-lg transition-all flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">open_in_new</span>
                                    <span>WA Web</span>
                                </a>
                                @if($igUrl)
                                    <button type="button" onclick="copyAndOpenIg('{{ $igUrl }}', {{ json_encode($waText) }})" class="px-3.5 py-1.5 rounded-lg font-bold text-xs shadow-xs flex items-center gap-1.5 transition-all hover:scale-105 cursor-pointer" style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); color: #ffffff !important;">
                                        <svg class="w-3.5 h-3.5 fill-current shrink-0 text-white" viewBox="0 0 24 24">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                        </svg>
                                        <span>DM IG ({{ '@' . $igHandle }})</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="p-10 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada hasil matching untuk laporan ini.</div>
            @endforelse
        </div>
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
</x-layouts.admin>
