<x-layouts.guest title="Form Klaim Barang">
    <div class="max-w-2xl mx-auto px-4 md:px-6 py-6 md:py-10">
        <!-- Header -->
        <div class="text-center mb-6 max-w-xl mx-auto">
            <span class="px-2.5 py-0.5 bg-emerald-100/80 text-emerald-800 text-[11px] font-bold rounded-full uppercase tracking-wider border border-emerald-200">Verifikasi Hak Milik</span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-2">Formulir Klaim Barang</h1>
            <p class="text-xs md:text-sm text-slate-600 mt-1">
                Unggah bukti kepemilikan sah untuk memverifikasi dan mengklaim barang temuan.
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
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200/80 flex items-center gap-4 mb-6 soft-shadow">
            <img src="{{ $imageUrl }}" alt="{{ $item->title }}" class="w-16 h-16 object-cover rounded-xl border border-slate-200 flex-shrink-0"/>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-0.5">
                    <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider bg-blue-50 px-2 py-0.5 rounded-md border border-blue-100">Barang yang Diklaim</span>
                    @if($item->category)
                        <span class="text-[10px] font-medium text-slate-500">• {{ $item->category->name }}</span>
                    @endif
                </div>
                <h3 class="text-sm font-bold text-slate-900 truncate">{{ $item->title }}</h3>
                <p class="text-xs text-slate-500 truncate">Ref: <span class="font-mono font-bold text-slate-700">{{ $item->ref_code }}</span> • Ditemukan di {{ $item->location_found }}</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 soft-shadow p-5 md:p-7 space-y-6">
            <form action="{{ route('claim.store', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="found_item_id" value="{{ $item->id }}">
                
                <!-- Claimant Info Section -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2.5 flex items-center gap-2">
                        <span class="w-5 h-5 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center text-xs font-bold">1</span>
                        <span>Data Pemohon Klaim</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap (KTP / Identitas) <span class="text-red-500">*</span></label>
                            <input type="text" name="claimant_name" value="{{ old('claimant_name') }}" placeholder="Nama lengkap sesuai KTP" class="w-full px-3.5 py-2.5 border @error('claimant_name') border-red-400 bg-red-50/30 @else border-slate-200 @enderror rounded-xl text-xs md:text-sm focus:outline-none focus:border-blue-600 transition-colors" required/>
                            @error('claimant_name')
                                <p class="text-[11px] text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp Aktif <span class="text-red-500">*</span></label>
                            <input type="tel" name="claimant_phone" value="{{ old('claimant_phone') }}" placeholder="08123456789" class="w-full px-3.5 py-2.5 border @error('claimant_phone') border-red-400 bg-red-50/30 @else border-slate-200 @enderror rounded-xl text-xs md:text-sm focus:outline-none focus:border-blue-600 transition-colors" required/>
                            @error('claimant_phone')
                                <p class="text-[11px] text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Identitas (KTP / SIM / Paspor) <span class="text-red-500">*</span></label>
                            <input type="text" name="claimant_id_number" value="{{ old('claimant_id_number') }}" placeholder="Contoh: 337201xxxxxxx" class="w-full px-3.5 py-2.5 border @error('claimant_id_number') border-red-400 bg-red-50/30 @else border-slate-200 @enderror rounded-xl text-xs md:text-sm focus:outline-none focus:border-blue-600 transition-colors" required/>
                            @error('claimant_id_number')
                                <p class="text-[11px] text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Email Aktif (opsional)</label>
                            <input type="email" name="claimant_email" value="{{ old('claimant_email') }}" placeholder="nama@email.com" class="w-full px-3.5 py-2.5 border @error('claimant_email') border-red-400 bg-red-50/30 @else border-slate-200 @enderror rounded-xl text-xs md:text-sm focus:outline-none focus:border-blue-600 transition-colors"/>
                            @error('claimant_email')
                                <p class="text-[11px] text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Proof Documents Upload -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2.5 flex items-center gap-2">
                        <span class="w-5 h-5 bg-blue-100 text-blue-700 rounded-full flex items-center justify-center text-xs font-bold">2</span>
                        <span>Bukti Kepemilikan & Berkas Pendukung</span>
                    </h3>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Unggah Identitas / Bukti Pemilikan (KTP/SIM/Struk/Foto Barang)</label>
                        <div class="border-2 border-dashed border-slate-200 hover:border-blue-500 transition-colors rounded-xl p-4 text-center bg-slate-50 relative group">
                            <input type="file" name="supporting_document" accept="image/jpeg,image/png,application/pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="space-y-1">
                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mx-auto text-blue-600 border border-slate-200 shadow-xs group-hover:scale-105 transition-transform">
                                    <span class="material-symbols-outlined text-xl">upload_file</span>
                                </div>
                                <p class="text-xs font-bold text-slate-700">Pilih file foto atau dokumen PDF</p>
                                <p class="text-[11px] text-slate-500">Format: JPG, PNG, PDF (Maksimal 2 MB)</p>
                            </div>
                        </div>
                        @error('supporting_document')
                            <p class="text-[11px] text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Ciri Khusus Tersembunyi</label>
                        <textarea name="distinctive_features" rows="3" placeholder="Sebutkan ciri khusus spesifik yang hanya diketahui oleh pemilik sah (misal: stiker dibalik casing, retak halus di sudut kiri, isi dompet, dll)..." class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-xs md:text-sm focus:outline-none focus:border-blue-600 transition-colors">{{ old('distinctive_features') }}</textarea>
                        <input type="hidden" name="relationship" value="Pemilik">
                        <input type="hidden" name="reason" value="Pengajuan klaim melalui formulir resmi TirtoFind">
                        <input type="hidden" name="lost_report_code" value="{{ old('lost_report_code') }}">
                        @error('distinctive_features')
                            <p class="text-[11px] text-red-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="bg-amber-50/70 border border-amber-200 rounded-xl p-3.5 flex items-start gap-2.5">
                    <span class="material-symbols-outlined text-amber-600 text-lg flex-shrink-0 mt-0.5">info</span>
                    <p class="text-xs text-amber-800 leading-relaxed">
                        <strong>Penting:</strong> Pastikan data yang dimasukkan benar. Petugas akan mencocokkan identitas Anda saat penyerahan barang secara fisik di Pos Lost & Found.
                    </p>
                </div>

                <div class="pt-2 border-t border-slate-100">
                    <button type="submit" class="w-full py-3.5 bg-emerald-600 text-white font-bold rounded-xl text-xs md:text-sm hover:bg-emerald-700 transition-all shadow-sm flex items-center justify-center gap-2 cursor-pointer">
                        <span class="material-symbols-outlined text-lg">verified</span>
                        <span>Kirim Permohonan Klaim Resmi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.guest>
