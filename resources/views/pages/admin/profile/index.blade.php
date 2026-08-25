<x-layouts.admin title="Admin Profile">
    <div x-data="{ saved: false }" class="max-w-3xl space-y-6">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow">
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Profil Admin Petugas</h1>
            <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">Perbarui informasi profil dan kata sandi akses sistem Anda.</p>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 md:p-8 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow space-y-6">
            <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="flex items-center gap-6">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150" class="w-20 h-20 rounded-full object-cover border-2 border-blue-600 shadow-md"/>
                    <div>
                        <button type="button" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-semibold rounded-xl text-xs cursor-pointer">Ganti Avatar</button>
                        <p class="text-[11px] text-slate-400 mt-1">Format JPG atau PNG (Maks 2MB)</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-600" required/>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">NIP Petugas</label>
                        <input type="text" value="19890412 201403 1 002" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800/50 rounded-xl text-sm text-slate-500 dark:text-slate-400" readonly/>
                    </div>
                </div>

                <div class="space-y-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Ubah Kata Sandi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Kata Sandi Lama</label>
                            <input type="password" name="current_password" placeholder="Password lama" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-600"/>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Kata Sandi Baru</label>
                            <input type="password" name="password" placeholder="Password baru" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-600"/>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password baru" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-600"/>
                        </div>
                    </div>
                </div>

                <div x-show="saved" class="p-3.5 bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 rounded-xl text-xs font-semibold">
                    Profil dan kata sandi berhasil diperbarui!
                </div>

                <div class="flex justify-end pt-2 border-t border-slate-100 dark:border-slate-800">
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl text-xs hover:bg-blue-700 shadow-xs cursor-pointer">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
