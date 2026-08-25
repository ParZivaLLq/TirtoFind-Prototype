<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\FoundItem;
use App\Models\LostReport;
use App\Models\User;
use App\Jobs\MatchLostReportJob;
use App\Services\AiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class P0RequirementsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_open_public_lost_report_form(): void
    {
        $response = $this->get(route('lost-report'));

        $response->assertOk();
    }

    public function test_guest_cannot_open_admin_dashboard(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_dashboard_displays_lost_reports_from_database(): void
    {
        $category = Category::create(['name' => 'Dokumen', 'slug' => 'dokumen']);
        LostReport::create([
            'report_code' => '#LR-2026-0099',
            'category_id' => $category->id,
            'reporter_name' => 'Sari Wijaya',
            'reporter_phone' => '08123456789',
            'reporter_id_type' => 'KTP',
            'reporter_id_number' => '3300000000000001',
            'item_name' => 'Kartu Identitas',
            'location_lost' => 'Ruang Tunggu',
            'date_lost' => '2026-08-21 09:00:00',
            'status' => 'Menunggu Verifikasi',
        ]);
        $admin = User::factory()->create(['role' => 'cs', 'status' => 'aktif']);

        $this->actingAs($admin)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Kartu Identitas')
            ->assertSee('#LR-2026-0099')
            ->assertSee('Menunggu Verifikasi');
    }

    public function test_staff_can_open_lost_report_detail(): void
    {
        $category = Category::create(['name' => 'Dokumen', 'slug' => 'dokumen']);
        $report = LostReport::create([
            'report_code' => '#LR-2026-0100',
            'category_id' => $category->id,
            'reporter_name' => 'Sari Wijaya',
            'reporter_phone' => '08123456789',
            'reporter_id_type' => 'KTP',
            'reporter_id_number' => '3300000000000001',
            'item_name' => 'Kartu Identitas',
            'location_lost' => 'Ruang Tunggu',
            'date_lost' => '2026-08-21 09:00:00',
            'distinctive_features' => 'Ada sampul biru.',
            'status' => 'Menunggu Verifikasi',
        ]);
        $admin = User::factory()->create(['role' => 'cs', 'status' => 'aktif']);

        $this->actingAs($admin)->get(route('admin.lost-reports.show', $report->id))
            ->assertOk()
            ->assertSee($report->report_code)
            ->assertSee($report->item_name)
            ->assertSee($report->reporter_name);

        $this->actingAs($admin)->get(route('admin.lost-reports.index'))
            ->assertOk()
            ->assertSee($report->report_code)
            ->assertSee($report->item_name);

        $this->actingAs($admin)->put(route('admin.lost-reports.update-status', $report->id), [
            'status' => 'Terverifikasi',
        ])->assertRedirect(route('admin.lost-reports.show', $report->id));
        $this->assertDatabaseHas('lost_reports', ['id' => $report->id, 'status' => 'Terverifikasi']);
    }

    public function test_super_admin_can_create_update_and_delete_category(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin', 'status' => 'aktif']);

        $this->actingAs($admin)->post(route('admin.categories.store'), ['name' => 'Dokumen'])
            ->assertRedirect(route('admin.categories.index'));
        $category = Category::where('name', 'Dokumen')->firstOrFail();

        $this->actingAs($admin)->put(route('admin.categories.update', $category->id), ['name' => 'Identitas'])
            ->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'Identitas', 'slug' => 'identitas']);

        $this->actingAs($admin)->delete(route('admin.categories.destroy', $category->id))
            ->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_staff_can_create_update_and_delete_found_item(): void
    {
        $admin = User::factory()->create(['role' => 'cs', 'status' => 'aktif']);
        $category = Category::create(['name' => 'Elektronik', 'slug' => 'elektronik']);
        $itemData = [
            'title' => 'Kamera Digital',
            'category_id' => $category->id,
            'location_found' => 'Platform 3',
            'date_found' => '2026-08-21 10:30:00',
            'color' => 'Hitam',
            'brand' => 'Canon',
            'storage_location' => 'Brankas Pos 1',
            'description' => 'Kamera digital dengan tali hitam.',
        ];

        $this->actingAs($admin)->post(route('admin.found-items.store'), $itemData)
            ->assertRedirect(route('admin.found-items.index'));
        $item = FoundItem::where('title', 'Kamera Digital')->firstOrFail();
        $this->assertDatabaseHas('found_items', ['id' => $item->id, 'status' => 'active', 'brand' => 'Canon']);

        $this->actingAs($admin)->put(route('admin.found-items.update', $item->id), array_merge($itemData, [
            'title' => 'Kamera Canon Updated',
            'status' => 'claimed',
        ]))->assertRedirect(route('admin.found-items.index'));
        $this->assertDatabaseHas('found_items', ['id' => $item->id, 'title' => 'Kamera Canon Updated', 'status' => 'claimed']);

        $this->actingAs($admin)->delete(route('admin.found-items.destroy', $item->id))
            ->assertRedirect(route('admin.found-items.index'));
        $this->assertDatabaseMissing('found_items', ['id' => $item->id]);
    }

    public function test_cs_cannot_manage_users(): void
    {
        $user = User::factory()->create(['role' => 'cs', 'status' => 'aktif']);

        $this->actingAs($user)->get(route('admin.users.index'))->assertForbidden();
    }

    public function test_public_lost_report_is_saved_with_expected_fields(): void
    {
        $category = Category::create(['name' => 'Elektronik', 'slug' => 'elektronik']);

        $response = $this->post(route('lost-report.store'), [
            'reporter_name' => 'Budi Setiawan',
            'reporter_phone' => '08123456789',
            'reporter_id_type' => 'KTP',
            'reporter_id_number' => '3300000000000001',
            'item_name' => 'Ponsel Hitam',
            'category_id' => $category->id,
            'location_lost' => 'Ruang Tunggu',
            'date_lost' => '2026-08-19 10:00:00',
            'distinctive_features' => 'Casing transparan',
        ]);

        $response->assertRedirect(route('lost-report'));
        $this->assertDatabaseHas('lost_reports', [
            'reporter_name' => 'Budi Setiawan',
            'category_id' => $category->id,
            'status' => 'Menunggu Verifikasi',
        ]);
    }

    public function test_lost_report_dispatches_ai_matching_to_queue(): void
    {
        Queue::fake();
        $category = Category::create(['name' => 'Elektronik', 'slug' => 'elektronik']);

        $this->post(route('lost-report.store'), [
            'reporter_name' => 'Budi Setiawan',
            'reporter_phone' => '08123456789',
            'reporter_id_type' => 'KTP',
            'reporter_id_number' => '3300000000000001',
            'item_name' => 'Ponsel Hitam',
            'category_id' => $category->id,
            'location_lost' => 'Ruang Tunggu',
            'date_lost' => '2026-08-19 10:00:00',
        ])->assertRedirect(route('lost-report'));

        Queue::assertPushed(MatchLostReportJob::class);
    }

    public function test_claim_document_is_optional_and_claim_is_saved(): void
    {
        $category = Category::create(['name' => 'Tas', 'slug' => 'tas']);
        $item = FoundItem::create([
            'ref_code' => '#TF-2026-0001',
            'title' => 'Dompet Hitam',
            'category_id' => $category->id,
            'description' => 'Dompet kulit hitam',
            'location_found' => 'Platform 1',
            'date_found' => '2026-08-19 09:00:00',
            'status' => 'active',
        ]);

        $response = $this->post(route('claim.store', $item->id), [
            'claimant_name' => 'Budi Setiawan',
            'claimant_phone' => '08123456789',
            'claimant_id_number' => '3300000000000001',
            'relationship' => 'Pemilik',
            'reason' => 'Ciri barang sesuai',
        ]);

        $response->assertRedirect(route('claim', $item->id));
        $this->assertDatabaseHas('claims', [
            'found_item_id' => $item->id,
            'claimant_name' => 'Budi Setiawan',
            'supporting_document_path' => null,
        ]);
    }

    public function test_public_claim_tracking_shows_current_status(): void
    {
        $category = Category::create(['name' => 'Tas', 'slug' => 'tas']);
        $item = FoundItem::create([
            'ref_code' => '#TF-2026-0002',
            'title' => 'Tas Biru',
            'category_id' => $category->id,
            'description' => 'Tas kain biru',
            'location_found' => 'Platform 2',
            'date_found' => '2026-08-19 09:00:00',
            'status' => 'active',
        ]);
        $claim = $item->claims()->create([
            'claim_code' => '#CL-2026-0002',
            'claimant_name' => 'Budi',
            'claimant_phone' => '08123456789',
            'claimant_id_number' => '3300000000000001',
            'relationship' => 'Pemilik',
            'reason' => 'Ciri sesuai',
            'status' => 'Menunggu Verifikasi',
        ]);

        $this->get(route('claim.tracking', ['claim_code' => $claim->claim_code]))
            ->assertOk()
            ->assertSee($claim->claim_code)
            ->assertSee('Menunggu Verifikasi');
    }

    public function test_ai_failure_returns_no_fake_match_score(): void
    {
        Config::set('services.openrouter.key', null);

        $this->assertNull(app(AiService::class)->matchItems('barang hilang', 'barang temuan'));
    }
}