<x-layouts.guest title="Lacak Klaim">
    <main class="max-w-2xl mx-auto px-6 py-12">
        <h1 class="text-3xl font-bold text-slate-900 mb-2">Lacak status klaim</h1>
        <p class="text-slate-500 mb-8">Masukkan kode tiket klaim untuk melihat status terbaru.</p>
        <form method="get" class="flex gap-2 mb-8">
            <input name="claim_code" value="{{ request('claim_code') }}" required class="flex-1 border rounded-xl px-4 py-3" placeholder="#CL-2026-0001">
            <button class="px-5 py-3 rounded-xl bg-slate-900 text-white font-semibold">Lacak</button>
        </form>
        @if(request('claim_code'))
            @if($claim)
                <section class="border rounded-2xl p-6 bg-white shadow-sm">
                    <div class="flex justify-between gap-4 mb-4">
                        <div><p class="text-xs uppercase text-slate-500">Kode klaim</p><p class="font-bold">{{ $claim->claim_code }}</p></div>
                        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-sm font-semibold">{{ $claim->status }}</span>
                    </div>
                    <p class="text-sm text-slate-600">Barang: {{ $claim->foundItem?->title ?? 'Tidak tersedia' }}</p>
                    <p class="text-sm text-slate-500 mt-2">Diajukan {{ $claim->created_at?->translatedFormat('d F Y, H:i') }}</p>
                </section>
            @else
                <p class="rounded-xl bg-red-50 text-red-700 px-4 py-3">Kode klaim tidak ditemukan.</p>
            @endif
        @endif
    </main>
</x-layouts.guest>
