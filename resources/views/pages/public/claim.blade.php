<x-layouts.guest title="Form Klaim Barang">
    <div x-data="{ success: false }" class="max-w-3xl mx-auto px-4 md:px-6 py-8 md:py-12">
        <div class="text-center mb-8">
            <span class="px-3 py-1 bg-emerald-500/10 text-emerald-700 text-xs font-semibold rounded-full uppercase tracking-wider">Verifikasi Hak Milik</span>
            <h1 class="text-3xl font-bold text-on-background mt-3">Formulir Pengajuan Klaim Barang</h1>
            <p class="text-sm text-on-surface-variant max-w-xl mx-auto mt-2">
                Unggah bukti kepemilikan sah Anda untuk memverifikasi bahwa barang temuan ini adalah benar milik Anda.
            </p>
        </div>

        <!-- Target Item Preview Box -->
        <div class="bg-surface-container-low p-4 rounded-2xl border border-border-subtle flex items-center gap-4 mb-8">
            <img src="https://images.unsplash.com/photo-1627123424574-724758594e93?w=300" class="w-20 h-20 object-cover rounded-xl border border-border-subtle flex-shrink-0"/>
            <div>
                <span class="text-[10px] font-bold text-primary uppercase">Target Barang Klaim</span>
                <h3 class="text-base font-bold text-on-background">Black Leather Wallet Imperial Horse</h3>
                <p class="text-xs text-outline">Kode Ref: #TF-2024-8912 • Ditemukan di Platform 4 Terminal Tirtonadi</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-border-subtle soft-shadow p-6 md:p-8 space-y-6">
            <form @submit.prevent="success = true" class="space-y-6">
                <!-- Reporter Info -->
                <div class="space-y-4">
                    <h3 class="text-base font-bold text-on-background border-b border-border-subtle pb-2">1. Data Pemohon Klaim</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-on-surface mb-1">Nama Lengkap Sesuai KTP</label>
                            <input type="text" value="Budi Santoso" class="w-full px-4 py-2.5 border border-border-subtle rounded-xl text-sm focus:outline-none focus:border-primary" required/>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-on-surface mb-1">Nomor WhatsApp Aktif</label>
                            <input type="tel" value="08123456789" class="w-full px-4 py-2.5 border border-border-subtle rounded-xl text-sm focus:outline-none focus:border-primary" required/>
                        </div>
                    </div>
                </div>

                <!-- Proof Documents Upload -->
                <div class="space-y-4">
                    <h3 class="text-base font-bold text-on-background border-b border-border-subtle pb-2">2. Bukti Kepemilikan (Wajib)</h3>
                    <div>
                        <label class="block text-xs font-semibold text-on-surface mb-1">Unggah Foto Kartu Identitas (KTP / SIM / Paspor)</label>
                        <div class="border-2 border-dashed border-border-subtle rounded-xl p-4 text-center hover:border-primary transition-colors cursor-pointer bg-surface-container-low">
                            <span class="material-symbols-outlined text-3xl text-primary mb-1">badge</span>
                            <p class="text-xs font-bold text-on-background">Upload Foto KTP / Kartu Identitas</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-on-surface mb-1">Unggah Bukti Pendukung (Nota Pembelian, Kardus, Serial Number, Foto Lama)</label>
                        <div class="border-2 border-dashed border-border-subtle rounded-xl p-4 text-center hover:border-primary transition-colors cursor-pointer bg-surface-container-low">
                            <span class="material-symbols-outlined text-3xl text-primary mb-1">receipt_long</span>
                            <p class="text-xs font-bold text-on-background">Upload Nota / Foto Bukti Kepemilikan</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-on-surface mb-1">Catatan Verifikasi Tambahan</label>
                        <textarea rows="3" placeholder="Sebutkan rincian tersembunyi yang hanya diketahui oleh pemilik (misal: isi uang dalam dompet, jumlah kartu, PIN, dll)..." class="w-full px-4 py-2.5 border border-border-subtle rounded-xl text-sm focus:outline-none focus:border-primary"></textarea>
                    </div>
                </div>

                <!-- Success Alert -->
                <div x-show="success" class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-xs space-y-1">
                    <div class="font-bold text-sm flex items-center gap-1.5"><span class="material-symbols-outlined text-base">check_circle</span> Pengajuan Klaim Berhasil Dikirim!</div>
                    <p>Tim verifikator Terminal Tirtonadi akan memeriksa berkas Anda dalam waktu 1x24 jam. Tiket Klaim Anda: <span class="font-mono font-bold">#CLM-2024-4401</span>.</p>
                </div>

                <div class="pt-4 border-t border-border-subtle">
                    <button type="submit" class="w-full py-3.5 bg-emerald-600 text-white font-bold rounded-xl text-sm hover:bg-emerald-700 transition-all shadow-md flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">verified</span>
                        <span>Kirim Permohonan Klaim Resmi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.guest>
