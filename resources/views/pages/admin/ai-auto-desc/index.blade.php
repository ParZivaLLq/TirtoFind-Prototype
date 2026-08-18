<x-layouts.admin title="AI Auto Description Generator">
    @php
        $aiData = session('aiData', [
            'description' => 'Dompet pria berbahan kulit asli warna hitam merek Imperial Horse. Dilengkapi dengan slot kartu identitas, kompartemen uang tunai, serta kartu e-money mandiri. Kondisi fisik sangat baik tanpa goresan signifikan. Ditemukan di area peron perlintasan bus 4.',
            'detected_category' => 'Tas & Dompet',
            'detected_color' => 'Hitam',
            'detected_brand' => 'Imperial Horse',
        ]);
    @endphp

    <div x-data="{ loading: false, description: @js($aiData['description']) }" class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50 dark:bg-sky-950/60 text-sky-700 dark:text-sky-300 text-xs font-semibold rounded-full mb-2">
                    <span class="material-symbols-outlined text-sm">document_scanner</span>
                    <span>Vision AI Cataloging Engine v3.2</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">AI Auto Description Generator</h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-0.5">Masukkan rincian atau foto barang temuan, dan AI akan mendeteksi atribut warna, merek, jenis, serta membuat deskripsi terstruktur secara otomatis.</p>
            </div>
        </div>

        <!-- Success Toast Alert -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 rounded-xl text-xs font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-base">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left: Input & Options Form (5 Cols) -->
            <div class="lg:col-span-5 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow space-y-5">
                <h3 class="text-base font-bold text-slate-900 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-3">1. Parameter Input Barang Temuan</h3>

                <form action="{{ route('admin.ai-auto-desc.generate') }}" method="POST" @submit="loading = true" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Nama Barang / Judul</label>
                        <input type="text" name="title" value="Dompet Kulit Pria Imperial Horse" required class="w-full px-3.5 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:border-sky-500"/>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Kategori Barang</label>
                            <select name="category" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white bg-white">
                                <option value="Tas & Dompet">Tas & Dompet</option>
                                <option value="Elektronik & HP">Elektronik & HP</option>
                                <option value="Aksesoris">Aksesoris</option>
                                <option value="Kunci & Otomotif">Kunci & Otomotif</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Warna Utama</label>
                            <input type="text" name="color" value="Hitam Pekat" class="w-full px-3.5 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:border-sky-500"/>
                        </div>
                    </div>

                    <!-- Prompt Format Selector -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Gaya Format Deskripsi</label>
                        <select name="style" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white bg-white">
                            <option value="Standar Katalog TirtoFind">Standar Katalog TirtoFind (Rekomendasi)</option>
                            <option value="Format Detail Berita Acara Legal">Format Detail Berita Acara Legal</option>
                            <option value="Format Ringkas Publikasi Sosmed">Format Ringkas Publikasi Sosmed</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-3 bg-sky-600 hover:bg-sky-700 text-white font-bold rounded-xl text-xs shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <template x-if="!loading">
                            <span class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-base">auto_awesome</span>
                                <span>Generate Deskripsi via OpenRouter AI</span>
                            </span>
                        </template>
                        <template x-if="loading">
                            <span class="flex items-center gap-2">
                                <span class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                                <span>Memproses AI...</span>
                            </span>
                        </template>
                    </button>
                </form>
            </div>

            <!-- Right: Result Textarea & Metadata (7 Cols) -->
            <div class="lg:col-span-7 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow space-y-5">
                <div class="flex justify-between items-center border-b border-slate-100 dark:border-slate-800 pb-3">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">2. Hasil Ekstraksi Vision AI</h3>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                        OpenRouter Connected
                    </span>
                </div>

                <!-- Detected Tags Matrix -->
                <div class="grid grid-cols-3 gap-3">
                    <div class="p-3 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-800 text-center">
                        <span class="text-[10px] text-slate-400 block uppercase font-bold">Kategori AI</span>
                        <span class="text-xs font-bold text-slate-900 dark:text-white">{{ $aiData['detected_category'] }}</span>
                    </div>
                    <div class="p-3 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-800 text-center">
                        <span class="text-[10px] text-slate-400 block uppercase font-bold">Warna AI</span>
                        <span class="text-xs font-bold text-slate-900 dark:text-white">{{ $aiData['detected_color'] }}</span>
                    </div>
                    <div class="p-3 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-200 dark:border-slate-800 text-center">
                        <span class="text-[10px] text-slate-400 block uppercase font-bold">Merek AI</span>
                        <span class="text-xs font-bold text-slate-900 dark:text-white">{{ $aiData['detected_brand'] }}</span>
                    </div>
                </div>

                <!-- Editable Textarea -->
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300">Teks Deskripsi Hasil AI (Dapat Diedit Manual)</label>
                        <span class="text-[11px] text-slate-400">Petugas dapat mengedit langsung</span>
                    </div>
                    <textarea x-model="description" rows="6" placeholder="Hasil deskripsi otomatis AI akan muncul di sini..." class="w-full p-4 border border-slate-200 dark:border-slate-800 dark:bg-slate-800/60 rounded-xl text-xs md:text-sm leading-relaxed text-slate-900 dark:text-white focus:outline-none focus:border-sky-600"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2 border-t border-slate-100 dark:border-slate-800">
                    <a href="{{ route('admin.found-items.index') }}" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-xs flex items-center gap-1.5 cursor-pointer">
                        <span class="material-symbols-outlined text-base">save</span>
                        <span>Gunakan di Katalog Barang Temuan</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
