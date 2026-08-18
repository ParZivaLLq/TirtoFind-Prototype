<x-layouts.admin title="System Settings">
    <div class="max-w-3xl space-y-6">
        <!-- Page Header -->
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow">
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Pengaturan & Tema Sistem</h1>
            <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">Pilih tema tampilan antarmuka admin (Gelap/Terang) dan atur parameter Vision AI.</p>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 md:p-8 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow space-y-8">
            
            <!-- Section 1: Theme Switcher (Dark Mode / Light Mode) -->
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <span class="material-symbols-outlined text-blue-600">palette</span>
                            <span>Tema Tampilan Antarmuka (Light / Dark Mode)</span>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Sesuaikan kenyamanan visual Anda saat bekerja di Admin Console.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <!-- Light Mode Card Option -->
                    <button type="button" 
                            @click="$store.theme.setLight()"
                            :class="!$store.theme.darkMode ? 'border-blue-600 ring-2 ring-blue-500/20 bg-blue-50/50' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800/40'"
                            class="p-4 rounded-2xl border text-left flex items-start gap-3 transition-all cursor-pointer">
                        <div class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-600 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined">light_mode</span>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                                <span>Light Mode (Terang)</span>
                                <template x-if="!$store.theme.darkMode">
                                    <span class="material-symbols-outlined text-sm text-blue-600">check_circle</span>
                                </template>
                            </div>
                            <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                Tampilan putih bersih dan terang, cocok untuk penggunaan di siang hari.
                            </div>
                        </div>
                    </button>

                    <!-- Dark Mode Card Option -->
                    <button type="button" 
                            @click="$store.theme.setDark()"
                            :class="$store.theme.darkMode ? 'border-blue-600 ring-2 ring-blue-500/20 bg-blue-950/40' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800/40'"
                            class="p-4 rounded-2xl border text-left flex items-start gap-3 transition-all cursor-pointer">
                        <div class="w-9 h-9 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined">dark_mode</span>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-1.5">
                                <span>Dark Mode (Gelap)</span>
                                <template x-if="$store.theme.darkMode">
                                    <span class="material-symbols-outlined text-sm text-blue-600">check_circle</span>
                                </template>
                            </div>
                            <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                Tampilan gelap elegan dengan kontras lembut untuk mengurangi kelelahan mata.
                            </div>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Section 2: AI Vision Engine Config -->
            <div class="space-y-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600">psychology</span>
                    <span>Konfigurasi AI Vision Engine (OpenRouter)</span>
                </h3>
                
                <div class="flex items-center justify-between p-3.5 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-200 dark:border-slate-800">
                    <div>
                        <div class="text-xs font-bold text-slate-900 dark:text-white">Auto Scan High Confidence Match</div>
                        <div class="text-[11px] text-slate-500 dark:text-slate-400">Kirim notifikasi otomatis jika similarity score di atas 90%</div>
                    </div>
                    <input type="checkbox" checked class="w-5 h-5 text-blue-600 rounded cursor-pointer"/>
                </div>

                <div class="flex items-center justify-between p-3.5 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-200 dark:border-slate-800">
                    <div>
                        <div class="text-xs font-bold text-slate-900 dark:text-white">Minimum Similarity Threshold</div>
                        <div class="text-[11px] text-slate-500 dark:text-slate-400">Ambang batas kecocokan AI untuk ditampilkan ke petugas</div>
                    </div>
                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/60 text-blue-800 dark:text-blue-300 text-xs font-bold rounded-lg">85%</span>
                </div>
            </div>

            <!-- Section 3: Retention Policy -->
            <div class="space-y-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600">schedule</span>
                    <span>Masa Retensi Storage Barang</span>
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Masa Simpan Barang Temuan (Hari)</label>
                        <input type="number" value="90" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-sm text-slate-900 dark:text-white"/>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Warning Notifikasi Expired (Hari)</label>
                        <input type="number" value="7" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-800 dark:bg-slate-800 rounded-xl text-sm text-slate-900 dark:text-white"/>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100 dark:border-slate-800">
                <button type="button" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs shadow-xs transition-all cursor-pointer">
                    Simpan Konfigurasi
                </button>
            </div>
        </div>
    </div>
</x-layouts.admin>
