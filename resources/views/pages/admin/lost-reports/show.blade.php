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
                    <div><div class="text-xs text-slate-400 mb-1">Telepon</div><div class="font-semibold text-slate-900 dark:text-white">{{ $report->reporter_phone }}</div></div>
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
                    @endphp
                    <div class="p-6 border-b last:border-b-0 border-slate-100 dark:border-slate-800 flex flex-col md:flex-row gap-4 md:items-center justify-between">
                        <div class="flex items-center gap-4">
                            <img src="{{ $matchImage }}" alt="{{ $match->foundItem->title }}" class="w-16 h-16 rounded-xl object-cover border border-slate-200 dark:border-slate-800">
                            <div>
                                <div class="font-bold text-slate-900 dark:text-white">{{ $match->foundItem->title }}</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $match->foundItem->ref_code }} · {{ $match->foundItem->location_found }}</div>
                                @if ($match->reason)<div class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $match->reason }}</div>@endif
                            </div>
                        </div>
                        <div class="text-left md:text-right">
                            <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $match->score }}%</div>
                            <div class="text-xs text-slate-400">Skor kecocokan</div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="p-10 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada hasil matching untuk laporan ini.</div>
            @endforelse
        </div>
    </div>
</x-layouts.admin>
