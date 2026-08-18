<!DOCTYPE html>
<html class="light h-full" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login Petugas Admin | TirtoFind - Terminal Tirtonadi</title>
    
    <!-- Google Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 antialiased h-full">
    <main class="flex min-h-screen w-full" x-data="{ showPassword: false }">
        <!-- Left Column: Visual & Brand Authority (Hidden on Mobile, Visible on Large Screens) -->
        <section class="hidden lg:flex lg:w-1/2 relative flex-col justify-center items-center overflow-hidden bg-blue-700 p-12 text-white">
            <!-- Decorative Background Grid Pattern -->
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <svg height="100%" width="100%" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern height="40" id="grid" patternUnits="userSpaceOnUse" width="40">
                            <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"></path>
                        </pattern>
                    </defs>
                    <rect fill="url(#grid)" height="100%" width="100%"></rect>
                </svg>
            </div>

            <!-- Content Container -->
            <div class="relative z-10 w-full max-w-lg space-y-8">
                <div>
                    <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-1.5 rounded-full border border-white/20 mb-6">
                        <span class="material-symbols-outlined text-white text-lg">verified_user</span>
                        <span class="text-white text-xs font-bold uppercase tracking-wider">Portal Resmi Petugas</span>
                    </div>
                    <h1 class="text-4xl font-extrabold leading-tight mb-4">
                        Efisiensi Dalam Setiap <br/>
                        <span class="text-blue-200">Pengembalian Barang.</span>
                    </h1>
                    <p class="text-blue-100 text-base leading-relaxed opacity-90">
                        Kelola sistem logistik barang hilang dan temuan Terminal Tirtonadi dengan presisi profesional, transparansi, dan keamanan standar Kementerian Perhubungan.
                    </p>
                </div>

                <!-- Hero Illustration Card -->
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-3xl blur opacity-30 group-hover:opacity-50 transition-opacity"></div>
                    <div class="relative bg-white rounded-2xl overflow-hidden border border-white/20 aspect-4/3 soft-shadow">
                        <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=800" alt="Terminal Tirtonadi Admin Hub"/>
                        <div class="absolute bottom-0 inset-x-0 p-6 bg-gradient-to-t from-slate-950/80 via-slate-950/40 to-transparent">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-md">
                                    <span class="material-symbols-outlined text-xl">auto_awesome</span>
                                </div>
                                <div>
                                    <p class="text-white font-bold text-base leading-none">Vision AI Smart Matching</p>
                                    <p class="text-blue-200 text-xs mt-0.5">Sistem Katalogisasi & Pencocokan Otomatis</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ambient Decorative Glow -->
            <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
        </section>

        <!-- Right Column: Login Interface -->
        <section class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 sm:p-12 bg-white">
            <div class="w-full max-w-[420px]">
                <!-- Header / Logo Section -->
                <div class="mb-8 text-center lg:text-left">
                    <div class="flex items-center justify-center lg:justify-start gap-3 mb-6">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-90 transition-opacity">
                            <div class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-sm">
                                <span class="material-symbols-outlined text-2xl">location_searching</span>
                            </div>
                            <span class="text-2xl font-extrabold text-slate-900 tracking-tight">Tirto<span class="text-blue-600">Find</span></span>
                        </a>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">Selamat Datang Kembali</h2>
                    <p class="text-sm text-slate-500 mt-1">Masukkan kredensial akun petugas untuk masuk ke panel admin.</p>
                </div>

                <!-- Session Alert -->
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 text-red-700 border border-red-200 rounded-xl text-xs font-semibold flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg text-red-600">error</span>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5" for="email">Alamat Email / NIP</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-2.5 text-slate-400 text-lg">mail</span>
                            <input class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all" id="email" name="email" placeholder="petugas@tirtonadi.dephub.go.id" type="email" value="admin@tirtofind.go.id" required/>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1.5">
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider" for="password">Kata Sandi</label>
                            <a class="text-xs text-blue-600 font-semibold hover:underline" href="#">Lupa Kata Sandi?</a>
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-2.5 text-slate-400 text-lg">lock</span>
                            <input class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all" id="password" name="password" placeholder="••••••••" :type="showPassword ? 'text' : 'password'" value="password" required/>
                            <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
                                <span class="material-symbols-outlined text-lg" x-text="showPassword ? 'visibility_off' : 'visibility'">visibility</span>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-1">
                        <input class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500" id="remember" type="checkbox" checked/>
                        <label class="text-xs text-slate-600 font-medium cursor-pointer select-none" for="remember">Ingat sesi saya selama 30 hari</label>
                    </div>

                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm py-3 rounded-xl shadow-md hover:shadow-lg active:scale-[0.99] transition-all flex items-center justify-center gap-2 cursor-pointer" type="submit">
                        <span>Masuk ke Dashboard Admin</span>
                        <span class="material-symbols-outlined text-lg">arrow_forward</span>
                    </button>
                </form>

                <!-- Footer Links -->
                <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                    <p class="text-xs text-slate-500">
                        Belum memiliki akun petugas? 
                        <a class="text-blue-600 font-bold hover:underline ml-1" href="{{ route('contact') }}">Hubungi Administrator</a>
                    </p>
                </div>

                <!-- Government Branding Footer -->
                <div class="mt-8 flex flex-col items-center gap-2">
                    <div class="flex items-center gap-3 opacity-60 hover:opacity-100 transition-opacity">
                        <div class="w-7 h-7 bg-slate-800 text-white rounded-full flex items-center justify-center p-1">
                            <span class="material-symbols-outlined text-sm">account_balance</span>
                        </div>
                        <div class="h-4 w-[1px] bg-slate-300"></div>
                        <span class="text-[11px] font-bold text-slate-600 uppercase tracking-tight">Kementerian Perhubungan RI</span>
                    </div>
                    <p class="text-[10px] text-slate-400">© {{ date('Y') }} Terminal Tirtonadi. Hak Cipta Dilindungi.</p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
