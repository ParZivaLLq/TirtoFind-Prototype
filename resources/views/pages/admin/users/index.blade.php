<x-layouts.admin title="User Management">
    <div x-data="{ modalOpen: false }" class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Manajemen Pengguna & Petugas Admin</h1>
                <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">Atur hak akses akun petugas terminal dan administrator sistem.</p>
            </div>
            <button @click="modalOpen = true" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-2 cursor-pointer">
                <span class="material-symbols-outlined text-base">person_add</span>
                <span>Tambah Petugas Baru</span>
            </button>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow overflow-hidden">
            <table class="w-full text-left text-xs md:text-sm">
                <thead class="bg-slate-50 dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 uppercase text-[11px] font-bold border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="px-6 py-3.5">Petugas / Admin</th>
                        <th class="px-6 py-3.5">NIP / Username</th>
                        <th class="px-6 py-3.5">Role</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($users as $user)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4 flex items-center gap-3">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100" class="w-9 h-9 rounded-full object-cover border border-blue-500/50"/>
                            <div>
                                <div class="font-bold text-slate-900 dark:text-white">{{ $user->name }}</div>
                                <div class="text-xs text-slate-400">{{ $user->email }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-mono text-slate-600 dark:text-slate-300">{{ $user->nip ?: '-' }}</td>
                        <td class="px-6 py-4"><span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">{{ $user->role }}</span></td>
                        <td class="px-6 py-4"><span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">{{ $user->status }}</span></td>
                        <td class="px-6 py-4 text-right space-x-1">
                            <button @click="modalOpen = true" class="p-1.5 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg"><span class="material-symbols-outlined text-base">edit</span></button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-slate-500">Belum ada pengguna.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Add User Modal -->
        <div x-show="modalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs" @click="modalOpen = false"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative w-full max-w-md bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-800 p-6 space-y-4 z-10">
                    <div class="flex justify-between items-center border-b border-slate-100 dark:border-slate-800 pb-3">
                        <h3 class="font-bold text-slate-900 dark:text-white">Tambah Petugas Admin Baru</h3>
                        <button @click="modalOpen = false" class="text-slate-400">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Nama Petugas</label>
                            <input type="text" name="name" placeholder="Contoh: Officer Eko Prasetyo" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-600" required/>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Email / NIP</label>
                            <input type="email" name="email" placeholder="petugas@tirtonadi.dephub.go.id" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-600" required/>
                        </div>
                        <input type="text" name="nip" placeholder="NIP (opsional)" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 rounded-xl text-sm">
                        <select name="role" class="w-full px-3 py-2 border rounded-xl text-sm"><option value="cs">Customer Service</option><option value="petugas">Petugas</option><option value="super_admin">Super Admin</option></select>
                        <input type="hidden" name="status" value="aktif">
                        <input type="password" name="password" placeholder="Password minimal 8 karakter" class="w-full px-3 py-2 border rounded-xl text-sm" required>

                        <div class="flex justify-end gap-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                            <button type="button" @click="modalOpen = false" class="px-4 py-2 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300">Batal</button>
                            <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold hover:bg-blue-700">Simpan Akun Petugas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
