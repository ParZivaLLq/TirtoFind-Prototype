<x-layouts.guest title="Lacak Klaim">
    <main class="max-w-xl mx-auto px-4 md:px-6 py-8 md:py-12">
        <div class="text-center mb-6">
            <span class="px-2.5 py-0.5 bg-blue-100/80 text-blue-700 text-[11px] font-bold rounded-full uppercase tracking-wider border border-blue-200">Tracking Status</span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-2">Lacak Status Klaim</h1>
            <p class="text-xs md:text-sm text-slate-500 mt-1">Masukkan nomor tiket klaim Anda untuk melihat progres verifikasi.</p>
        </div>

        <form method="get" class="flex gap-2 mb-8 bg-white p-2 border border-slate-200/80 rounded-2xl soft-shadow">
            <input name="claim_code" value="{{ request('claim_code') }}" required class="flex-1 border-none focus:outline-none focus:ring-0 px-3.5 py-2 text-xs md:text-sm text-slate-900 placeholder:text-slate-400 bg-transparent" placeholder="Contoh: #CL-2026-0001">
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition-all shadow-xs cursor-pointer">Lacak Tiket</button>
        </form>

        @if(request('claim_code'))
            @if($claim)
                <section class="border border-slate-200/80 rounded-2xl p-5 bg-white soft-shadow space-y-3">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Nomor Tiket Klaim</p>
                            <p class="text-sm font-bold text-slate-900">{{ $claim->claim_code }}</p>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-xs font-bold border border-amber-200">{{ $claim->status }}</span>
                    </div>
                    <div class="text-xs text-slate-600 space-y-1">
                        <p><strong class="text-slate-900">Barang:</strong> {{ $claim->foundItem?->title ?? 'Tidak tersedia' }}</p>
                        <p class="text-slate-500">Diajukan pada {{ $claim->created_at?->translatedFormat('d F Y, H:i') }} WIB</p>
                    </div>
                </section>
            @else
                <div class="rounded-xl bg-red-50 text-red-700 border border-red-200 px-4 py-3 text-xs font-semibold text-center flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-base">error</span>
                    <span>Kode tiket klaim tidak ditemukan. Silakan periksa kembali nomor tiket Anda.</span>
                </div>
            @endif
        @endif
    </main>
</x-layouts.guest>
