<x-layouts.guest title="Buat Laporan Kehilangan">
    <div x-data="{
        step: 1,
        submitted: false,
        errorMessage: '',
        form: {
            name: '',
            phone: '',
            item_name: '',
            category: 'Tas & Dompet',
            color: '',
            description: '',
            location: 'Platform 4 Bus Intercity',
            time: ''
        },
        goToStep(targetStep) {
            this.errorMessage = '';
            if (targetStep > this.step) {
                if (this.step === 1 && !this.validateStep1()) return;
                if (this.step === 2 && !this.validateStep2()) return;
                if (this.step === 3 && !this.validateStep3()) return;
            }
            this.step = targetStep;
        },
        validateStep1() {
            if (!this.form.name.trim() || !this.form.phone.trim()) {
                this.errorMessage = 'Mohon isi Nama Lengkap dan Nomor WhatsApp/Telepon sebelum melanjutkan.';
                return false;
            }
            this.errorMessage = '';
            return true;
        },
        validateStep2() {
            if (!this.form.item_name.trim()) {
                this.errorMessage = 'Mohon isi Nama / Judul Barang yang hilang.';
                return false;
            }
            this.errorMessage = '';
            return true;
        },
        validateStep3() {
            if (!this.form.location || !this.form.time) {
                this.errorMessage = 'Mohon pilih Perkiraan Lokasi dan Waktu Kejadian hilang.';
                return false;
            }
            this.errorMessage = '';
            return true;
        },
        nextFromStep1() {
            if (this.validateStep1()) {
                this.step = 2;
            }
        },
        nextFromStep2() {
            if (this.validateStep2()) {
                this.step = 3;
            }
        },
        nextFromStep3() {
            if (this.validateStep3()) {
                this.step = 4;
            }
        },
        submitForm() {
            if (this.validateStep1() && this.validateStep2() && this.validateStep3()) {
                this.submitted = true;
            }
        }
    }" class="w-full max-w-3xl mx-auto px-4 md:px-6 py-8 md:py-12">

        <!-- Page Title & Description -->
        <div class="text-center w-full max-w-2xl mx-auto mb-8">
            <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-full uppercase tracking-wider border border-amber-200 mb-3">Formulir Resmi Kehilangan</span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">Buat Laporan Kehilangan Barang</h1>
            <p class="text-sm md:text-base text-slate-600 w-full mt-2 leading-relaxed">
                Lengkapi formulir di bawah ini. Sistem Vision AI TirtoFind akan mencocokkan laporan Anda secara otomatis dengan barang temuan petugas secara realtime.
            </p>
        </div>

        <!-- Clean Progress Header & Step Pills -->
        <div class="mb-8 bg-slate-50 border border-slate-200 rounded-2xl p-4 md:p-6 soft-shadow">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-3">
                <div>
                    <span class="text-[11px] font-extrabold uppercase tracking-wider text-blue-700 bg-blue-100 px-2.5 py-0.5 rounded-md border border-blue-200">Langkah <span x-text="step"></span> dari 4</span>
                    <h2 class="text-base md:text-lg font-bold text-slate-900 mt-1" x-text="step === 1 ? '1. Identitas Pelapor' : (step === 2 ? '2. Rincian Barang Hilang' : (step === 3 ? '3. Perkiraan Lokasi & Waktu' : '4. Ringkasan & Konfirmasi'))"></h2>
                </div>
                <div class="text-xs font-semibold text-slate-500">
                    Kemajuan: <span class="font-bold text-blue-600" x-text="(step * 25) + '%'"></span>
                </div>
            </div>
            
            <!-- Progress Bar Line -->
            <div class="w-full h-2 bg-slate-200 rounded-full overflow-hidden mb-4">
                <div class="h-full bg-blue-600 transition-all duration-300 rounded-full" :style="'width: ' + (step * 25) + '%'"></div>
            </div>

            <!-- Step Pills Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                <button type="button" @click="goToStep(1)" :class="step >= 1 ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100'" class="px-3 py-2 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 shadow-xs cursor-pointer">
                    <span class="w-5 h-5 rounded-full bg-white/20 text-current flex items-center justify-center text-[10px] font-extrabold">1</span>
                    <span>Pelapor</span>
                </button>
                <button type="button" @click="goToStep(2)" :class="step >= 2 ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100'" class="px-3 py-2 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 shadow-xs cursor-pointer">
                    <span class="w-5 h-5 rounded-full bg-white/20 text-current flex items-center justify-center text-[10px] font-extrabold">2</span>
                    <span>Detail Barang</span>
                </button>
                <button type="button" @click="goToStep(3)" :class="step >= 3 ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100'" class="px-3 py-2 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 shadow-xs cursor-pointer">
                    <span class="w-5 h-5 rounded-full bg-white/20 text-current flex items-center justify-center text-[10px] font-extrabold">3</span>
                    <span>Lokasi & Foto</span>
                </button>
                <button type="button" @click="goToStep(4)" :class="step >= 4 ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100'" class="px-3 py-2 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 shadow-xs cursor-pointer">
                    <span class="w-5 h-5 rounded-full bg-white/20 text-current flex items-center justify-center text-[10px] font-extrabold">4</span>
                    <span>Konfirmasi</span>
                </button>
            </div>
        </div>

        <!-- Validation Error Box -->
        <div x-show="errorMessage" x-transition class="mb-6 p-4 bg-red-50 text-red-700 border border-red-200 rounded-xl text-xs font-semibold flex items-center gap-2">
            <span class="material-symbols-outlined text-lg text-red-600">error</span>
            <span x-text="errorMessage"></span>
        </div>

        <!-- Form Card Container -->
        <div class="w-full bg-white rounded-2xl border border-slate-200 soft-shadow p-6 md:p-8">
            <form @submit.prevent="submitForm">
                <!-- Step 1: Data Pelapor (Nama & Nomor HP Saja) -->
                <div x-show="step === 1" class="space-y-6">
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="text-base font-bold text-slate-900">Langkah 1: Identitas Pelapor</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Isi nama lengkap dan nomor telepon/WhatsApp aktif Anda.</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Pelapor <span class="text-red-500">*</span></label>
                            <input type="text" x-model="form.name" placeholder="Masukkan nama lengkap Anda" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all"/>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp / Telepon Aktif <span class="text-red-500">*</span></label>
                            <input type="tel" x-model="form.phone" placeholder="Contoh: 08123456789" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all"/>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-slate-100">
                        <button type="button" @click="nextFromStep1()" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm transition-all shadow-sm flex items-center gap-2 cursor-pointer">
                            <span>Lanjut ke Detail Barang</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </button>
                    </div>
                </div>

                <!-- Step 2: Detail Barang -->
                <div x-show="step === 2" class="space-y-6">
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="text-base font-bold text-slate-900">Langkah 2: Rincian Barang Hilang</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Jelaskan ciri-ciri barang yang tertinggal/hilang secara spesifik.</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama / Judul Barang <span class="text-red-500">*</span></label>
                            <input type="text" x-model="form.item_name" placeholder="Contoh: Dompet Kulit Pria Hitam Imperial Horse" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition-all"/>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Barang</label>
                                <select x-model="form.category" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 bg-white">
                                    <option value="Tas & Dompet">Tas & Dompet</option>
                                    <option value="Elektronik & HP">Elektronik & HP</option>
                                    <option value="Dokumen & ID">Dokumen & ID</option>
                                    <option value="Aksesoris & Perhiasan">Aksesoris & Perhiasan</option>
                                    <option value="Kunci & Otomotif">Kunci & Otomotif</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Warna Dominan</label>
                                <input type="text" x-model="form.color" placeholder="Hitam, Biru, Cokelat..." class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition-all"/>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Ciri-Ciri Khusus / Deskripsi Rinci</label>
                            <textarea x-model="form.description" rows="3" placeholder="Sebutkan ciri khusus (stiker, goresan, merk, isi di dalam dompet/tas, dsb)..." class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition-all"></textarea>
                        </div>
                    </div>

                    <div class="flex justify-between pt-4 border-t border-slate-100">
                        <button type="button" @click="step = 1" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm cursor-pointer">Kembali</button>
                        <button type="button" @click="nextFromStep2()" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm transition-all shadow-sm flex items-center gap-2 cursor-pointer">
                            <span>Lanjut ke Lokasi & Foto</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Lokasi & Foto -->
                <div x-show="step === 3" class="space-y-6">
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="text-base font-bold text-slate-900">Langkah 3: Lokasi & Perkiraan Waktu</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Tentukan area kejadian dan waktu perkiraan hilang.</p>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Perkiraan Lokasi Hilang <span class="text-red-500">*</span></label>
                                <select x-model="form.location" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 bg-white">
                                    <option value="Platform 4 Bus Intercity">Platform 4 Bus Intercity</option>
                                    <option value="Ruang Tunggu Zone B">Ruang Tunggu Zone B</option>
                                    <option value="Area Food Court UMKM">Area Food Court UMKM</option>
                                    <option value="Pintu Kedatangan Bus">Pintu Kedatangan Bus</option>
                                    <option value="Area Parkir Selatan">Area Parkir Selatan</option>
                                    <option value="Area Toilet Utama">Area Toilet Utama</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Perkiraan Tanggal & Waktu Hilang <span class="text-red-500">*</span></label>
                                <input type="datetime-local" x-model="form.time" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 bg-white transition-all"/>
                            </div>
                        </div>

                        <!-- Dropzone Photo Upload -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Unggah Foto Contoh Barang (Opsional)</label>
                            <div class="border-2 border-dashed border-slate-300 rounded-2xl p-6 text-center hover:border-blue-600 transition-colors cursor-pointer bg-slate-50">
                                <span class="material-symbols-outlined text-4xl text-blue-600 mb-1">cloud_upload</span>
                                <p class="text-xs font-bold text-slate-700">Tarik & Lepas Foto di Sini, atau Klik Upload</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">PNG, JPG, WEBP (Maksimal 5MB)</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between pt-4 border-t border-slate-100">
                        <button type="button" @click="step = 2" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm cursor-pointer">Kembali</button>
                        <button type="button" @click="nextFromStep3()" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm transition-all shadow-sm flex items-center gap-2 cursor-pointer">
                            <span>Lanjut ke Ringkasan</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </button>
                    </div>
                </div>

                <!-- Step 4: Ringkasan & Konfirmasi -->
                <div x-show="step === 4" class="space-y-6">
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="text-base font-bold text-slate-900">Langkah 4: Ringkasan Laporan</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Periksa kembali ringkasan data sebelum mengirim laporan resmi.</p>
                    </div>

                    <!-- Summary Box -->
                    <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3 text-xs md:text-sm">
                        <div class="flex justify-between border-b border-slate-200 pb-2">
                            <span class="text-slate-500">Nama Pelapor:</span>
                            <span class="font-bold text-slate-900" x-text="form.name"></span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 pb-2">
                            <span class="text-slate-500">No. WhatsApp:</span>
                            <span class="font-bold text-slate-900" x-text="form.phone"></span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 pb-2">
                            <span class="text-slate-500">Barang Hilang:</span>
                            <span class="font-bold text-blue-700" x-text="form.item_name"></span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 pb-2">
                            <span class="text-slate-500">Kategori & Warna:</span>
                            <span class="font-bold text-slate-900" x-text="form.category + (form.color ? ' (' + form.color + ')' : '')"></span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 pb-2">
                            <span class="text-slate-500">Lokasi & Waktu:</span>
                            <span class="font-bold text-slate-900" x-text="form.location + ' • ' + form.time"></span>
                        </div>
                        <div class="flex justify-between pt-1">
                            <span class="text-slate-500">Pencocokan AI:</span>
                            <span class="font-bold text-emerald-600 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">auto_awesome</span> Vision AI Matching Aktif
                            </span>
                        </div>
                    </div>

                    <!-- Success Alert Message -->
                    <div x-show="submitted" x-transition class="p-4 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-xl text-xs leading-relaxed flex items-center gap-3">
                        <span class="material-symbols-outlined text-emerald-600 text-2xl">check_circle</span>
                        <div>
                            <strong>Laporan Kehilangan Berhasil Dikirim!</strong> Nomor Tiket Laporan Anda: <span class="font-mono font-bold">#REP-2024-9902</span>. Petugas dan Vision AI akan memproses pencocokan barang secara kontinu.
                        </div>
                    </div>

                    <div class="flex justify-between pt-4 border-t border-slate-100">
                        <button type="button" @click="step = 3" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm cursor-pointer">Kembali Edit</button>
                        <button type="submit" class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm transition-all shadow-md flex items-center gap-2 cursor-pointer">
                            <span class="material-symbols-outlined text-base">send</span>
                            <span>Kirim Laporan Resmi</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.guest>
