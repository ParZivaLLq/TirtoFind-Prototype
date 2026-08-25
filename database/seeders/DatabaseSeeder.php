<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\FoundItem;
use App\Models\LostReport;
use App\Models\AiMatchingLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Categories
        $categoriesData = [
            ['name' => 'Tas & Dompet', 'slug' => 'tas-dompet'],
            ['name' => 'Elektronik & HP', 'slug' => 'elektronik-hp'],
            ['name' => 'Aksesoris', 'slug' => 'aksesoris'],
            ['name' => 'Kunci & Otomotif', 'slug' => 'kunci-otomotif'],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['name']] = Category::firstOrCreate(['slug' => $cat['slug']], ['name' => $cat['name']]);
        }

        // 2. Seed Users
        $admin = User::updateOrCreate(
            ['email' => 'admin@tirtofind.go.id'],
            [
                'name' => 'Officer Handoko',
                'nip' => '198904122014031002',
                'role' => 'super_admin',
                'status' => 'aktif',
                'password' => bcrypt('password'),
            ]
        );

        $cs = User::updateOrCreate(
            ['email' => 'bambang@tirtonadi.dephub.go.id'],
            [
                'name' => 'Officer Bambang',
                'nip' => '199105202016021004',
                'role' => 'cs',
                'status' => 'aktif',
                'password' => bcrypt('password'),
            ]
        );

        // 3. Seed Found Items
        $foundItems = [
            [
                'ref_code' => '#TF-2026-8912',
                'title' => 'Dompet Kulit Pria Imperial Horse',
                'category_id' => $categories['Tas & Dompet']->id,
                'description' => 'Dompet lipat dua berbahan kulit asli warna hitam merk Imperial Horse. Di dalamnya terdapat 6 slot kartu identitas, e-money mandiri, serta uang tunai. Pemilik sah dapat melakukan verifikasi klaim dengan menyertakan KTP dan mencocokkan identitas kartu.',
                'color' => 'Hitam Pekat',
                'brand' => 'Imperial Horse',
                'location_found' => 'Platform 4 Terminal Tirtonadi',
                'date_found' => '2026-08-18 14:30:00',
                'storage_location' => 'Brankas Inventaris Pos 1',
                'image_path' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=800',
                'status' => 'active',
            ],
            [
                'ref_code' => '#TF-2026-8911',
                'title' => 'Samsung Galaxy S23 Ultra',
                'category_id' => $categories['Elektronik & HP']->id,
                'description' => 'Smartphone Samsung Galaxy S23 Ultra warna biru dengan casing transparan, layar retak sedikit di pojok kiri bawah.',
                'color' => 'Biru',
                'brand' => 'Samsung',
                'location_found' => 'Ruang Tunggu Zone B',
                'date_found' => '2026-08-17 09:15:00',
                'storage_location' => 'Brankas Inventaris Pos 1',
                'image_path' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800',
                'status' => 'claimed',
            ],
            [
                'ref_code' => '#TF-2026-8910',
                'title' => 'Headphone Wireless Sony',
                'category_id' => $categories['Aksesoris']->id,
                'description' => 'Headphone bluetooth Sony WH-1000XM4 warna hitam. Busa penutup telinga masih mulus.',
                'color' => 'Hitam',
                'brand' => 'Sony',
                'location_found' => 'Area Food Court',
                'date_found' => '2026-08-16 10:00:00',
                'storage_location' => 'Laci Meja Layanan CS',
                'image_path' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800',
                'status' => 'active',
            ],
            [
                'ref_code' => '#TF-2026-8909',
                'title' => 'Tas Ransel Eiger 30L Abu-Abu',
                'category_id' => $categories['Tas & Dompet']->id,
                'description' => 'Ransel abu-abu 30L merk Eiger di pintu kedatangan. Berisi pakaian ganti dan charger laptop.',
                'color' => 'Abu-Abu',
                'brand' => 'Eiger',
                'location_found' => 'Pintu Kedatangan',
                'date_found' => '2026-08-15 11:20:00',
                'storage_location' => 'Gudang Barang Temuan',
                'image_path' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800',
                'status' => 'active',
            ],
            [
                'ref_code' => '#TF-2026-8908',
                'title' => 'Kunci Mobil Remote Toyota',
                'category_id' => $categories['Kunci & Otomotif']->id,
                'description' => 'Kunci mobil Toyota Innova dengan gantungan kunci kulit warna coklat.',
                'color' => 'Hitam/Coklat',
                'brand' => 'Toyota',
                'location_found' => 'Parkir Selatan',
                'date_found' => '2026-08-14 16:45:00',
                'storage_location' => 'Kotak Kunci CS',
                'image_path' => 'https://images.unsplash.com/photo-1583485088034-697b5bc54ccd?w=800',
                'status' => 'active',
            ],
            [
                'ref_code' => '#TF-2026-8907',
                'title' => 'Jam Tangan Seiko Automatic',
                'category_id' => $categories['Aksesoris']->id,
                'description' => 'Jam tangan rantai stainless steel merk Seiko 5 Automatic, dial warna hitam.',
                'color' => 'Silver/Stainless',
                'brand' => 'Seiko',
                'location_found' => 'Toilet Utama',
                'date_found' => '2026-08-13 08:30:00',
                'storage_location' => 'Brankas Inventaris Pos 1',
                'image_path' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=800',
                'status' => 'active',
            ],
        ];

        $itemsCreated = [];
        foreach ($foundItems as $item) {
            $itemsCreated[$item['ref_code']] = FoundItem::create($item);
        }

        // 4. Seed Lost Reports
        $lostReports = [
            [
                'report_code' => '#LR-2026-0001',
                'category_id' => $categories['Tas & Dompet']->id,
                'reporter_name' => 'Budi Setiawan',
                'reporter_phone' => '081234567890',
                'reporter_id_type' => 'KTP',
                'reporter_id_number' => '3311020304050001',
                'item_name' => 'Dompet Kulit Hitam Imperial Horse',
                'color' => 'Hitam',
                'brand' => 'Imperial Horse',
                'location_lost' => 'Platform 4 area peron bus intercity',
                'date_lost' => '2026-08-18 13:00:00',
                'distinctive_features' => 'Bahan kulit asli hitam merk Imperial Horse, ada e-money mandiri dengan saldo sekitar 50rb dan KTP atas nama Budi Setiawan.',
                'image_path' => null,
                'status' => 'Menunggu Verifikasi',
            ],
            [
                'report_code' => '#LR-2026-0002',
                'category_id' => $categories['Aksesoris']->id,
                'reporter_name' => 'Anisa Rahmawati',
                'reporter_phone' => '089876543210',
                'reporter_id_type' => 'KTP',
                'reporter_id_number' => '3311020304050002',
                'item_name' => 'Helm KYT Merah Maroon',
                'color' => 'Merah',
                'brand' => 'KYT',
                'location_lost' => 'Parkiran Motor Depan Pos Informasi',
                'date_lost' => '2026-08-19 10:15:00',
                'distinctive_features' => 'Helm KYT DJ Maxi warna merah maroon, ada stiker logo fakultas teknik UMS di bagian belakang.',
                'image_path' => null,
                'status' => 'Menunggu Verifikasi',
            ],
        ];

        $reportsCreated = [];
        foreach ($lostReports as $report) {
            $reportsCreated[$report['report_code']] = LostReport::create($report);
        }

        // 5. Seed AI Matching Logs
        AiMatchingLog::create([
            'lost_report_id' => $reportsCreated['#LR-2026-0001']->id,
            'found_item_id' => $itemsCreated['#TF-2026-8912']->id,
            'score' => 94,
            'reason' => 'Cocok tinggi berdasarkan kemiripan warna hitam, bahan kulit, serta kemiripan lokasi Platform 4.',
            'color_match' => 100,
            'brand_match' => 95,
            'location_match' => 90,
            'time_match' => 92,
        ]);
    }
}
