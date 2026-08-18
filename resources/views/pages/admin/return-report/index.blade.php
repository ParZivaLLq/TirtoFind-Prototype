<x-layouts.admin title="Berita Acara Pengembalian Barang">
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Toolbar Action for Printing -->
        <div class="flex justify-between items-center bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 soft-shadow">
            <div>
                <h1 class="text-lg font-bold text-slate-900 dark:text-white">Dokumen Berita Acara Pengembalian Barang (BAPB)</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400">Nomor Dokumen: <span class="font-mono font-bold text-blue-600 dark:text-blue-400">BAPB/TF/2024/X/0049</span></p>
            </div>
            <button onclick="window.print()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold flex items-center gap-1.5 shadow-sm cursor-pointer">
                <span class="material-symbols-outlined text-base">print</span>
                <span>Cetak Dokumen Resmi</span>
            </button>
        </div>

        <!-- Official Document Paper Sheet -->
        <div class="bg-white p-8 md:p-12 rounded-2xl border border-slate-300 dark:border-slate-700 shadow-lg text-slate-900 space-y-6">
            <!-- Official Header -->
            <div class="text-center border-b-2 border-slate-900 pb-4 space-y-1">
                <h2 class="text-xs uppercase font-bold tracking-widest text-slate-700">KEMENTERIAN PERHUBUNGAN REPUBLIK INDONESIA</h2>
                <h1 class="text-lg font-extrabold uppercase tracking-wider text-slate-900">DIREKTORAT JENDERAL PERHUBUNGAN DARAT</h1>
                <h3 class="text-sm font-bold text-slate-800">BALAI PENGELOLA TRANSPORTASI DARAT KELAS II JAWA TENGAH</h3>
                <p class="text-xs font-sans text-slate-600">SATUAN PELAYANAN TERMINAL TIPE A TIRTONADI SURAKARTA</p>
                <p class="text-[11px] font-sans text-slate-500">Jl. Ahmad Yani, Gilingan, Banjarsari, Kota Surakarta, Jawa Tengah 57134</p>
            </div>

            <!-- Title -->
            <div class="text-center space-y-1 py-2">
                <h2 class="text-base font-bold uppercase underline tracking-wide">BERITA ACARA PENGEMBALIAN BARANG TEMUAN</h2>
                <p class="text-xs font-sans text-slate-600">Nomor: BAPB/TF/2024/X/0049</p>
            </div>

            <!-- Statement Paragraph -->
            <div class="text-xs font-sans leading-relaxed space-y-4">
                <p>Pada hari ini <strong>Kamis</strong> tanggal <strong>Dua Puluh Empat</strong> bulan <strong>Oktober</strong> tahun <strong>Dua Ribu Dua Puluh Empat</strong>, bertempat di Pos Pelayanan Informasi TirtoFind Terminal Tipe A Tirtonadi Surakarta, kami yang bertanda tangan di bawah ini:</p>
                
                <div class="pl-4 space-y-1 border-l-2 border-slate-300">
                    <div>1. <strong>Nama Officer / Petugas:</strong> Handoko, A.Md.Tra</div>
                    <div>   <strong>Jabatan:</strong> Petugas Pelayanan Informasi / Admin TirtoFind</div>
                    <div>   <strong>NIP / NIK:</strong> 19890412 201403 1 002</div>
                    <div class="pt-1 text-slate-600 italic">Selanjutnya disebut sebagai <strong>PIHAK PERTAMA (PETUGAS PENYERAH)</strong>.</div>
                </div>

                <div class="pl-4 space-y-1 border-l-2 border-slate-300">
                    <div>2. <strong>Nama Pemilik Sah:</strong> Budi Santoso</div>
                    <div>   <strong>NIK KTP:</strong> 3372011409880003</div>
                    <div>   <strong>Alamat:</strong> Jl. Slamet Riyadi No. 142, Surakarta</div>
                    <div>   <strong>No. WhatsApp / Telp:</strong> 08123456789</div>
                    <div class="pt-1 text-slate-600 italic">Selanjutnya disebut sebagai <strong>PIHAK KEDUA (PENERIMA BARANG)</strong>.</div>
                </div>

                <p>PIHAK PERTAMA telah menyerahkan secara sah kepada PIHAK KEDUA barang temuan berupa:</p>

                <!-- Item Description Box -->
                <div class="p-4 bg-slate-50 border border-slate-300 rounded-xl space-y-1 font-mono text-[11px]">
                    <div>- <strong>Nama / Jenis Barang:</strong> Dompet Kulit Pria Imperial Horse (Hitam)</div>
                    <div>- <strong>Kode Ref Inventaris:</strong> #TF-2024-8912</div>
                    <div>- <strong>Lokasi Penemuan:</strong> Platform 4 Terminal Tirtonadi</div>
                    <div>- <strong>Tanggal Ditemukan:</strong> 24 Oktober 2024 (14:30 WIB)</div>
                    <div>- <strong>Kondisi Barang:</strong> Baik, Lengkap dengan Kartu KTP & E-Money Mandiri</div>
                </div>

                <p>PIHAK KEDUA telah memeriksa dan menerima barang tersebut dalam kondisi baik dan sesuai dengan bukti kepemilikan yang terverifikasi secara sah.</p>
            </div>

            <!-- Signatures Section -->
            <div class="pt-12 grid grid-cols-2 text-center text-xs font-sans">
                <div class="space-y-16">
                    <div>
                        <p class="font-bold">PIHAK KEDUA (PENERIMA)</p>
                        <p class="text-slate-500">Pemilik Sah Barang</p>
                    </div>
                    <div>
                        <p class="font-bold underline">( Budi Santoso )</p>
                        <p class="text-[10px] text-slate-400">NIK: 3372011409880003</p>
                    </div>
                </div>

                <div class="space-y-16">
                    <div>
                        <p class="font-bold">PIHAK PERTAMA (PETUGAS)</p>
                        <p class="text-slate-500">Admin TirtoFind Terminal Tirtonadi</p>
                    </div>
                    <div>
                        <p class="font-bold underline">( Handoko, A.Md.Tra )</p>
                        <p class="text-[10px] text-slate-400">NIP: 19890412 201403 1 002</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
