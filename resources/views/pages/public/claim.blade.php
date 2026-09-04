<x-layouts.guest title="Form Klaim Barang">
    <div class="max-w-2xl mx-auto px-4 md:px-6 py-6 md:py-10">
        <!-- Header -->
        <div class="text-center mb-6 max-w-xl mx-auto">
            <span class="px-2.5 py-0.5 bg-emerald-100/80 text-emerald-800 text-[11px] font-bold rounded-full uppercase tracking-wider border border-emerald-200">Verifikasi Hak Milik</span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-2">Formulir Klaim Barang</h1>
            <p class="text-xs md:text-sm text-slate-600 mt-1">
                Unggah bukti kepemilikan sah untuk memverifikasi barang temuan.
            </p>
        </div>

        @if(session('success'))
            <!-- Success Confirmation Card -->
            <div class="bg-emerald-50/90 border border-emerald-200 rounded-2xl p-6 mb-6 soft-shadow text-center space-y-4">
                <div class="w-14 h-14 bg-emerald-600 text-white rounded-full flex items-center justify-center mx-auto shadow-sm">
                    <span class="material-symbols-outlined text-3xl">task_alt</span>
                </div>
                <div>
                    <h2 class="text-lg md:text-xl font-extrabold text-slate-900">Permohonan Klaim Berhasil Dikirim!</h2>
                    <p class="text-xs md:text-sm text-slate-600 mt-1">Tim verifikator Terminal Tirtonadi akan memeriksa permohonan Anda dalam 1x24 jam.</p>
                </div>

                @if(session('claimCode'))
                    <div class="bg-white border border-emerald-200 rounded-xl p-4 max-w-md mx-auto space-y-1">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kode Tiket Klaim Anda</span>
                        <div class="text-xl md:text-2xl font-mono font-black text-emerald-700 select-all">
                            {{ session('claimCode') }}
                        </div>
                        <p class="text-[11px] text-slate-500">Simpan nomor tiket ini untuk mengecek progres verifikasi.</p>
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row gap-3 justify-center pt-2">
                    @if(session('claimCode'))
                        <a href="{{ route('claim.tracking', ['claim_code' => session('claimCode')]) }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs md:text-sm transition-all shadow-xs flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-base">analytics</span>
                            <span>Lacak Status Klaim</span>
                        </a>
                    @endif
                    @if(session('waUrl'))
                        <a href="{{ session('waUrl') }}" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs md:text-sm transition-all shadow-xs flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-base">chat</span>
                            <span>Konfirmasi Helpdesk WA</span>
                        </a>
                    @endif
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-xs font-semibold mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-base">error</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Target Item Preview Box -->
        @php
            $imageUrl = $item->image_path ?: 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=300';
            $imageUrl = str_starts_with($imageUrl, 'http') ? $imageUrl : asset(ltrim($imageUrl, '/'));
        @endphp
        <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-200/80 flex items-center gap-3.5 mb-6 soft-shadow">
            <img src="{{ $imageUrl }}" alt="{{ $item->title }}" class="w-16 h-16 object-cover rounded-xl border border-slate-200 flex-shrink-0"/>
            <div>
                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">Barang yang Diklaim</span>
                <h3 class="text-sm font-bold text-slate-900 line-clamp-1">{{ $item->title }}</h3>
                <p class="text-xs text-slate-500">Ref: {{ $item->ref_code }} • Ditemukan di {{ $item->location_found }}</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 soft-shadow p-5 md:p-7 space-y-5">
            <form action="{{ route('claim.store', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <input type="hidden" name="found_item_id" value="{{ $item->id }}">
                
                <!-- Claimant Info -->
                <div class="space-y-3.5">
                    <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2">1. Data Pemohon Klaim</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap (KTP)</label>
                            <input type="text" name="claimant_name" value="{{ old('claimant_name') }}" placeholder="Nama lengkap Anda" class="w-full px-3.5 py-2 border border-slate-200 rounded-xl text-xs md:text-sm focus:outline-none focus:border-blue-600" required/>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp Aktif</label>
                            <input type="tel" name="claimant_phone" value="{{ old('claimant_phone') }}" placeholder="08123456789" class="w-full px-3.5 py-2 border border-slate-200 rounded-xl text-xs md:text-sm focus:outline-none focus:border-blue-600" required/>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Email (opsional)</label>
                            <input type="email" name="claimant_email" value="{{ old('claimant_email') }}" placeholder="email@domain.com" class="w-full px-3.5 py-2 border border-slate-200 rounded-xl text-xs md:text-sm focus:outline-none focus:border-blue-600"/>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Identitas (KTP/SIM)</label>
                            <input type="text" name="claimant_id_number" value="{{ old('claimant_id_number') }}" placeholder="Nomor KTP/SIM" class="w-full px-3.5 py-2 border border-slate-200 rounded-xl text-xs md:text-sm focus:outline-none focus:border-blue-600" required/>
                        </div>
                    </div>
                </div>

                <!-- Proof Documents Upload -->
                <div class="space-y-3.5">
                    <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2">2. Bukti Kepemilikan</h3>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Unggah Foto Kartu Identitas (KTP / SIM / Paspor)</label>
                        <div class="border-2 border-dashed border-slate-300 rounded-xl p-3.5 text-center hover:border-blue-600 transition-colors cursor-pointer bg-slate-50">
                            <input type="file" name="supporting_document" accept="image/jpeg,image/png,application/pdf" class="block w-full text-xs text-slate-500 mb-1.5">
                            <p class="text-xs font-bold text-slate-700">Upload Foto KTP / SIM</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Ciri Khusus Tambahan</label>
                        <textarea name="distinctive_features" rows="3" placeholder="Sebutkan ciri khusus tersembunyi yang hanya diketahui pemilik..." class="w-full px-3.5 py-2 border border-slate-200 rounded-xl text-xs md:text-sm focus:outline-none focus:border-blue-600">{{ old('distinctive_features') }}</textarea>
                        <input type="hidden" name="relationship" value="Pemilik">
                        <input type="hidden" name="reason" value="Pengajuan klaim melalui formulir resmi TirtoFind">
                        <input type="hidden" name="lost_report_code" value="{{ old('lost_report_code') }}">
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100">
                    <button type="submit" class="w-full py-3 bg-emerald-600 text-white font-bold rounded-xl text-xs md:text-sm hover:bg-emerald-700 transition-all shadow-xs flex items-center justify-center gap-1.5 cursor-pointer">
                        <span class="material-symbols-outlined text-base">verified</span>
                        <span>Kirim Permohonan Klaim Resmi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.guest>
