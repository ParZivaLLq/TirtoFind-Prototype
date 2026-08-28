<x-layouts.guest title="Buat Laporan Kehilangan">
    <div x-data="{
        step: 1,
        submitted: false,
        errorMessage: '',
        form: {
            name: '',
            phone: '',
            item_name: '',
            category: '{{ $categories->first()->id ?? '' }}',
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
    }" class="w-full max-w-3xl mx-auto px-4 md:px-6 py-6 md:py-10">

        <!-- Page Header -->
        <div class="text-center max-w-xl mx-auto mb-6">
            <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 text-[11px] font-bold rounded-full uppercase tracking-wider border border-amber-200 mb-2">Laporan Resmi</span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900">Lapor Kehilangan Barang</h1>
            <p class="text-xs md:text-sm text-slate-600 mt-1.5 leading-relaxed">
                Lengkapi formulir berikut. Vision AI akan mencocokkan data Anda dengan inventaris barang temuan secara otomatis.
            </p>
        </div>

        <!-- Progress Header & Step Pills -->
        <div class="mb-6 bg-slate-50 border border-slate-200/80 rounded-2xl p-4 soft-shadow">
            <div class="flex justify-between items-center gap-3 mb-2.5">
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-blue-700 bg-blue-100/80 px-2 py-0.5 rounded border border-blue-200">Langkah <span x-text="step"></span> / 4</span>
                    <h2 class="text-sm font-bold text-slate-900 mt-0.5" x-text="step === 1 ? '1. Identitas Pelapor' : (step === 2 ? '2. Rincian Barang' : (step === 3 ? '3. Lokasi & Waktu' : '4. Ringkasan & Konfirmasi'))"></h2>
                </div>
                <div class="text-xs font-semibold text-slate-500">
                    Kemajuan: <span class="font-bold text-blue-600" x-text="(step * 25) + '%'"></span>
                </div>
            </div>
            
            <!-- Progress Bar Line -->
            <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden mb-3">
                <div class="h-full bg-blue-600 transition-all duration-300 rounded-full" :style="'width: ' + (step * 25) + '%'"></div>
            </div>

            <!-- Step Pills Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                <button type="button" @click="goToStep(1)" :class="step >= 1 ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100'" class="px-2.5 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 shadow-2xs cursor-pointer">
                    <span class="w-4 h-4 rounded-full bg-white/20 text-current flex items-center justify-center text-[10px] font-extrabold">1</span>
                    <span>Pelapor</span>
                </button>
                <button type="button" @click="goToStep(2)" :class="step >= 2 ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100'" class="px-2.5 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 shadow-2xs cursor-pointer">
                    <span class="w-4 h-4 rounded-full bg-white/20 text-current flex items-center justify-center text-[10px] font-extrabold">2</span>
                    <span>Detail</span>
                </button>
                <button type="button" @click="goToStep(3)" :class="step >= 3 ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100'" class="px-2.5 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 shadow-2xs cursor-pointer">
                    <span class="w-4 h-4 rounded-full bg-white/20 text-current flex items-center justify-center text-[10px] font-extrabold">3</span>
                    <span>Lokasi</span>
                </button>
                <button type="button" @click="goToStep(4)" :class="step >= 4 ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-100'" class="px-2.5 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 shadow-2xs cursor-pointer">
                    <span class="w-4 h-4 rounded-full bg-white/20 text-current flex items-center justify-center text-[10px] font-extrabold">4</span>
                    <span>Ringkasan</span>
                </button>
            </div>
        </div>

        <!-- Validation Error Box -->
        <div x-show="errorMessage" x-transition class="mb-5 p-3 bg-red-50 text-red-700 border border-red-200 rounded-xl text-xs font-semibold flex items-center gap-2">
            <span class="material-symbols-outlined text-base text-red-600">error</span>
            <span x-text="errorMessage"></span>
        </div>

        <!-- Form Card Container -->
        <div class="w-full bg-white rounded-2xl border border-slate-200/80 soft-shadow p-5 md:p-7">
            <form action="{{ route('lost-report.store') }}" method="POST" enctype="multipart/form-data" @submit="if (!validateStep1() || !validateStep2() || !validateStep3()) { $event.preventDefault(); }">
                @csrf
                <!-- Step 1: Data Pelapor -->
                <div x-show="step === 1" class="space-y-5">
                    <div class="border-b border-slate-100 pb-2.5">
                        <h3 class="text-base font-bold text-slate-900">Identitas Pelapor</h3>
                        <p class="text-xs text-slate-500">Isi nama lengkap dan kontak aktif Anda.</p>
                    </div>

                    <div class="space-y-3.5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Pelapor <span class="text-red-500">*</span></label>
                            <input type="text" name="reporter_name" x-model="form.name" placeholder="Masukkan nama lengkap Anda" class="w-full px-3.5 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all" required/>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp / Telepon Aktif <span class="text-red-500">*</span></label>
                            <input type="tel" name="reporter_phone" x-model="form.phone" placeholder="Contoh: 08123456789" class="w-full px-3.5 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all" required/>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Identitas (KTP/SIM/Paspor) <span class="text-red-500">*</span></label>
                            <input type="text" name="reporter_id_number" placeholder="Nomor KTP/SIM/Paspor" class="w-full px-3.5 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-all" required/>
                            <input type="hidden" name="reporter_id_type" value="KTP"/>
                        </div>
                    </div>

                    <div class="flex justify-end pt-3 border-t border-slate-100">
                        <button type="button" @click="nextFromStep1()" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs md:text-sm transition-all shadow-xs flex items-center gap-1.5 cursor-pointer">
                            <span>Lanjut ke Detail Barang</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </button>
                    </div>
                </div>

                <!-- Step 2: Detail Barang -->
                <div x-show="step === 2" class="space-y-5">
                    <div class="border-b border-slate-100 pb-2.5">
                        <h3 class="text-base font-bold text-slate-900">Rincian Barang Hilang</h3>
                        <p class="text-xs text-slate-500">Jelaskan ciri-ciri barang secara spesifik.</p>
                    </div>

                    <div class="space-y-3.5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama / Judul Barang <span class="text-red-500">*</span></label>
                            <input type="text" name="item_name" x-model="form.item_name" placeholder="Contoh: Dompet Kulit Pria Hitam Imperial Horse" class="w-full px-3.5 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition-all" required/>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Barang</label>
                                <select name="category_id" x-model="form.category" class="w-full px-3.5 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 bg-white" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Warna Dominan</label>
                                <input type="text" name="color" x-model="form.color" placeholder="Hitam, Biru, Cokelat..." class="w-full px-3.5 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition-all"/>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Ciri-Ciri Khusus / Deskripsi Rinci</label>
                            <textarea name="distinctive_features" x-model="form.description" rows="3" placeholder="Sebutkan ciri khusus (stiker, goresan, merk, isi di dalam dompet/tas)..." class="w-full px-3.5 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 transition-all"></textarea>
                        </div>
                    </div>

                    <div class="flex justify-between pt-3 border-t border-slate-100">
                        <button type="button" @click="step = 1" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs md:text-sm cursor-pointer">Kembali</button>
                        <button type="button" @click="nextFromStep2()" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs md:text-sm transition-all shadow-xs flex items-center gap-1.5 cursor-pointer">
                            <span>Lanjut ke Lokasi & Foto</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </button>
                    </div>
                </div>

                <!-- Step 3: Lokasi & Foto -->
                <div x-show="step === 3" class="space-y-5">
                    <div class="border-b border-slate-100 pb-2.5">
                        <h3 class="text-base font-bold text-slate-900">Lokasi & Perkiraan Waktu</h3>
                        <p class="text-xs text-slate-500">Tentukan area kejadian dan waktu perkiraan hilang.</p>
                    </div>

                    <div class="space-y-3.5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Perkiraan Lokasi Hilang <span class="text-red-500">*</span></label>
                                <input type="text" name="location_lost" x-model="form.location" placeholder="Contoh: Ruang Tunggu Zone B" maxlength="255" class="w-full px-3.5 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 bg-white" required/>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Perkiraan Tanggal & Waktu Hilang <span class="text-red-500">*</span></label>
                                <input type="datetime-local" name="date_lost" x-model="form.time" class="w-full px-3.5 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 bg-white transition-all" required/>
                            </div>
                        </div>

                        <!-- Photo Upload -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Unggah Foto Contoh Barang (Opsional)</label>
                            <div class="border-2 border-dashed border-slate-300 rounded-xl p-5 text-center hover:border-blue-600 transition-colors cursor-pointer bg-slate-50">
                                <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="block w-full text-xs text-slate-500 mb-2"/>
                                <span class="material-symbols-outlined text-3xl text-blue-600 mb-1">cloud_upload</span>
                                <p class="text-xs font-bold text-slate-700">Pilih Foto atau Tarik File ke Sini</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">PNG, JPG, WEBP (Maks. 5MB)</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between pt-3 border-t border-slate-100">
                        <button type="button" @click="step = 2" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs md:text-sm cursor-pointer">Kembali</button>
                        <button type="button" @click="nextFromStep3()" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs md:text-sm transition-all shadow-xs flex items-center gap-1.5 cursor-pointer">
                            <span>Lanjut ke Ringkasan</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </button>
                    </div>
                </div>

                <!-- Step 4: Ringkasan & Konfirmasi -->
                <div x-show="step === 4" class="space-y-5">
                    <div class="border-b border-slate-100 pb-2.5">
                        <h3 class="text-base font-bold text-slate-900">Ringkasan Laporan</h3>
                        <p class="text-xs text-slate-500">Periksa kembali data sebelum mengirim laporan.</p>
                    </div>

                    <!-- Summary Box -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-2.5 text-xs md:text-sm">
                        <div class="flex justify-between border-b border-slate-200 pb-1.5">
                            <span class="text-slate-500">Nama Pelapor:</span>
                            <span class="font-bold text-slate-900" x-text="form.name"></span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 pb-1.5">
                            <span class="text-slate-500">No. WhatsApp:</span>
                            <span class="font-bold text-slate-900" x-text="form.phone"></span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 pb-1.5">
                            <span class="text-slate-500">Barang Hilang:</span>
                            <span class="font-bold text-blue-700" x-text="form.item_name"></span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 pb-1.5">
                            <span class="text-slate-500">Kategori & Warna:</span>
                            <span class="font-bold text-slate-900" x-text="form.category + (form.color ? ' (' + form.color + ')' : '')"></span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 pb-1.5">
                            <span class="text-slate-500">Lokasi & Waktu:</span>
                            <span class="font-bold text-slate-900" x-text="form.location + ' • ' + form.time"></span>
                        </div>
                        <div class="flex justify-between pt-0.5">
                            <span class="text-slate-500">Pencocokan AI:</span>
                            <span class="font-bold text-emerald-600 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">auto_awesome</span> Vision AI Matching Aktif
                            </span>
                        </div>
                    </div>

                    <!-- Success Alert Message -->
                    <div x-show="submitted" x-transition class="p-3 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-xl text-xs leading-relaxed flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-emerald-600 text-xl">check_circle</span>
                        <div>
                            <strong>Laporan Kehilangan Berhasil Dikirim!</strong> Nomor Tiket: <span class="font-mono font-bold">#REP-2024-9902</span>. Petugas & Vision AI akan segera memproses laporan Anda.
                        </div>
                    </div>

                    <div class="flex justify-between pt-3 border-t border-slate-100">
                        <button type="button" @click="step = 3" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs md:text-sm cursor-pointer">Kembali Edit</button>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs md:text-sm transition-all shadow-sm flex items-center gap-1.5 cursor-pointer">
                            <span class="material-symbols-outlined text-base">send</span>
                            <span>Kirim Laporan Resmi</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.guest>
