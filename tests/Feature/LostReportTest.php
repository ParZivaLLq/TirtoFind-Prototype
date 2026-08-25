<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LostReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_lost_report_form(): void
    {
        Category::factory()->create(['name' => 'Elektronik & HP']);

        $response = $this->get(route('lost-report'));

        $response->assertStatus(200);
    }

    public function test_can_submit_lost_report(): void
    {
        Storage::fake('public');
        $category = Category::factory()->create(['name' => 'Elektronik & HP']);

        $response = $this->post(route('lost-report.store'), [
            'reporter_name' => 'Budi Santoso',
            'reporter_phone' => '081234567890',
            'reporter_id_type' => 'KTP',
            'reporter_id_number' => '3311001234567890',
            'item_name' => 'Laptop ASUS',
            'category_id' => $category->id,
            'location_lost' => 'Platform 4',
            'date_lost' => '2026-08-19',
            'color' => 'Hitam',
            'brand' => 'ASUS',
            'distinctive_features' => 'Ada stiker kucing',
            'image' => UploadedFile::fake()->image('laptop.jpg'),
        ]);

        $response->assertRedirect(route('lost-report'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('lost_reports', [
            'reporter_name' => 'Budi Santoso',
            'item_name' => 'Laptop ASUS',
        ]);
    }

    public function test_lost_report_generates_unique_code(): void
    {
        $category = Category::factory()->create(['name' => 'Elektronik & HP']);

        $this->post(route('lost-report.store'), [
            'reporter_name' => 'Andi',
            'reporter_phone' => '081234567890',
            'reporter_id_type' => 'KTP',
            'reporter_id_number' => '3311001234567890',
            'item_name' => 'HP Samsung',
            'category_id' => $category->id,
            'location_lost' => 'Ruang Tunggu',
            'date_lost' => '2026-08-19',
        ]);

        $this->assertDatabaseCount('lost_reports', 1);

        $report = \App\Models\LostReport::first();
        $this->assertStringStartsWith('#LR-', $report->report_code);
    }

    public function test_lost_report_requires_validation(): void
    {
        $response = $this->post(route('lost-report.store'), []);

        $response->assertSessionHasErrors([
            'reporter_name',
            'reporter_phone',
            'reporter_id_type',
            'reporter_id_number',
            'item_name',
            'category_id',
            'location_lost',
            'date_lost',
        ]);
    }
}
