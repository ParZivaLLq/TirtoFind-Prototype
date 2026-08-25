<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_access_user_management(): void
    {
        $user = User::factory()->create([
            'role' => 'super_admin',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertStatus(200);
    }

    public function test_cs_cannot_access_user_management(): void
    {
        $user = User::factory()->create([
            'role' => 'cs',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertStatus(403);
    }

    public function test_petugas_cannot_access_user_management(): void
    {
        $user = User::factory()->create([
            'role' => 'petugas',
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertStatus(403);
    }

    public function test_all_roles_can_access_dashboard(): void
    {
        foreach (['super_admin', 'cs', 'petugas'] as $role) {
            $user = User::factory()->create([
                'role' => $role,
                'status' => 'aktif',
            ]);

            $response = $this->actingAs($user)->get(route('admin.dashboard'));

            $response->assertStatus(200);
        }
    }

    public function test_guest_cannot_access_admin(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }
}
