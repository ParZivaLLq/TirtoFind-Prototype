<x-layouts.admin title="AI Auto Description Generator">
    @php
        $aiData = session('aiData', [
            'description' => $draftItem?->description ?? '',
            'detected_category' => $draftItem?->category?->name ?? '-',
            'detected_color' => $draftItem?->color ?? '-',
            'detected_brand' => $draftItem?->brand ?? '-',
        ]);
        $draftItem = $draftItem ?? null;
        $draftItemId = $draftItem?->id;
        $categoryId = old('category_id', $draftItem?->category_id);
        $imageUrl = $draftItem?->image_path;
        $itemsList = $itemsList ?? [];
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
            
            <!-- Quick Item Selector -->
            @if(count($itemsList) > 0)
                <div class="w-full sm:w-auto">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase mb-1">Pilih Barang dari Inventaris:</label>
                    <select onchange="if(this.value) window.location.href='{{ route('admin.ai-auto-desc.index') }}?id=' + this.value; else window.location.href='{{ route('admin.ai-auto-desc.index') }}';" class="px-3 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-900 dark:text-white focus:outline-none">
                        <option value="">+ Input Barang Temuan Baru</option>
                        @foreach($itemsList as $itemOpt)
                            <option value="{{ $itemOpt->id }}" @selected($draftItemId === $itemOpt->id)>
                                {{ $itemOpt->ref_code }} — {{ $itemOpt->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        <!-- Success Toast Alert -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 rounded-xl text-xs font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-base">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="p-4 bg-red-50 dark:bg-red-950/40 text-red-800 dark:text-red-300 border border-red-200 dark:border-red-800 rounded-xl text-xs font-semibold">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left: Input & Options Form (5 Cols) -->
            <div class="lg:col-span-5 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow space-y-5">
                <div class="flex justify-between items-center border-b border-slate-100 dark:border-slate-800 pb-3">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">1. Parameter Input Barang</h3>
                    @if($draftItem)
                        <span class="text-xs font-bold text-sky-600 bg-sky-50 dark:bg-sky-950/60 px-2.5 py-0.5 rounded-full border border-sky-200">{{ $draftItem->ref_code }}</span>
                    @endif
                </div>

                <form action="{{ route('admin.ai-auto-desc.generate') }}" method="POST" enctype="multipart/form-data" @submit="loading = true" class="space-y-4">
                    @csrf
                    @if($draftItemId)
                        <input type="hidden" name="found_item_id" value="{{ $draftItemId }}">
                    @endif

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Nama Barang / Judul</label>
                        <input type="text" name="title" value="{{ old('title', $draftItem?->title) }}" required placeholder="cth: Helm KYT DJ Maxi / Samsung S23" class="w-full px-3.5 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:border-sky-500"/>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Kategori Barang</label>
                            <select name="category_id" required class="w-full px-3 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white bg-white dark:bg-slate-800">
                                @foreach ($categories as $categoryOption)
                                    <option value="{{ $categoryOption->id }}" @selected((int) $categoryId === $categoryOption->id)>{{ $categoryOption->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Warna Utama</label>
                            <input type="text" name="color" value="{{ old('color', $draftItem?->color) }}" placeholder="cth: Merah Maroon" class="w-full px-3.5 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:border-sky-500"/>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Merek / Brand</label>
                            <input type="text" name="brand" value="{{ old('brand', $draftItem?->brand) }}" placeholder="Merek (opsional)" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Lokasi Temu</label>
                            <input type="text" name="location_found" value="{{ old('location_found', $draftItem?->location_found ?: 'Terminal Tirtonadi') }}" placeholder="Lokasi penemuan" required class="w-full px-3 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Waktu Temu</label>
                            <input type="datetime-local" name="date_found" value="{{ old('date_found', $draftItem?->date_found?->format('Y-m-d\\TH:i') ?: date('Y-m-d\\TH:i')) }}" required class="w-full px-3 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Lokasi Simpan</label>
                            <input type="text" name="storage_location" value="{{ old('storage_location', $draftItem?->storage_location ?: 'Brankas Inventaris Pos 1') }}" placeholder="Lokasi penyimpanan" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Gambar Referensi AI (maks. 5 MB)</label>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-xs text-slate-700 dark:text-slate-200"/>
                        @if ($imageUrl)
                            <div class="mt-2 flex items-center gap-3">
                                <img src="{{ str_starts_with($imageUrl, 'http') ? $imageUrl : asset($imageUrl) }}" alt="Gambar barang" class="w-20 h-20 object-cover rounded-xl border border-slate-200 dark:border-slate-800">
                                <span class="text-[11px] text-slate-500">Gambar yang digunakan untuk analisis Vision AI</span>
                            </div>
                        @endif
                    </div>

                    <!-- Prompt Format Selector -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Gaya Format Deskripsi</label>
                        <select name="style" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white bg-white dark:bg-slate-800">
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
                                <span>Memproses Vision AI...</span>
                            </span>
                        </template>
                    </button>
                </form>
            </div>

            <!-- Right: Result Textarea & Metadata (7 Cols) -->
            <form action="{{ route('admin.ai-auto-desc.save') }}" method="POST" class="lg:col-span-7 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow space-y-5">
                @csrf
                <input type="hidden" name="found_item_id" value="{{ $draftItemId }}">
                
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Judul Katalog</label>
                    <input type="text" name="title" value="{{ old('title', $draftItem?->title) }}" required placeholder="Judul barang" class="w-full px-3.5 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-xs font-bold text-slate-900 dark:text-white">
                </div>

                <div class="flex justify-between items-center border-b border-slate-100 dark:border-slate-800 pb-3">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">2. Hasil Ekstraksi Vision AI</h3>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>OpenRouter AI Ready</span>
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
                    <textarea name="description" x-model="description" rows="7" required placeholder="Hasil deskripsi otomatis AI akan muncul di sini..." class="w-full p-4 border border-slate-200 dark:border-slate-800 dark:bg-slate-800/60 rounded-xl text-xs md:text-sm leading-relaxed text-slate-900 dark:text-white focus:outline-none focus:border-sky-600">{{ old('description', $aiData['description']) }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-500 mb-1">Kategori Final</label>
                        <select name="category_id" required class="w-full px-3 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white">
                            @foreach ($categories as $categoryOption)
                                <option value="{{ $categoryOption->id }}" @selected((int) $categoryId === $categoryOption->id)>{{ $categoryOption->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-500 mb-1">Warna Final</label>
                        <input type="text" name="color" value="{{ old('color', $draftItem?->color) }}" placeholder="Warna" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-500 mb-1">Merek Final</label>
                        <input type="text" name="brand" value="{{ old('brand', $draftItem?->brand) }}" placeholder="Merek" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-xs text-slate-900 dark:text-white">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button type="submit" @disabled(!$draftItemId) class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 disabled:bg-slate-400 text-white rounded-xl text-xs font-bold shadow-xs flex items-center gap-1.5 cursor-pointer disabled:cursor-not-allowed">
                        <span class="material-symbols-outlined text-base">save</span>
                        <span>Simpan ke Katalog Barang Temuan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>

