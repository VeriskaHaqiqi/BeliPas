<?php

namespace Tests\Feature\Admin;

use App\Models\Commodity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Tests\TestCase;

class CommodityManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        // Cegah test mengubah Supabase jika konfigurasi testing salah.
        $connection = $_ENV['DB_CONNECTION']
            ?? $_SERVER['DB_CONNECTION']
            ?? null;

        $database = $_ENV['DB_DATABASE']
            ?? $_SERVER['DB_DATABASE']
            ?? null;

        $url = $_ENV['DB_URL']
            ?? $_SERVER['DB_URL']
            ?? null;

        if (
            $connection !== 'sqlite' ||
            $database !== ':memory:' ||
            !empty($url)
        ) {
            throw new RuntimeException(
                'TEST DIBATALKAN: database harus SQLite in-memory.'
            );
        }

        parent::setUp();
    }

    private function admin(): User
    {
        $admin = User::factory()->create();

        // role tidak mass assignable: set lewat assignment langsung.
        $admin->role = 'admin';
        $admin->is_active = true;
        $admin->save();

        return $admin;
    }

    public function test_guest_cannot_access_admin(): void
    {
        $this->get('/admin')
            ->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_access_admin(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_inactive_admin_cannot_access_admin(): void
    {
        $admin = $this->admin();

        $admin->is_active = false;
        $admin->save();

        $this->actingAs($admin)
            ->get('/admin')
            ->assertForbidden();
    }

    public function test_active_admin_can_open_dashboard(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin')
            ->assertOk()
            ->assertSee('Dashboard Admin');
    }

    public function test_admin_can_create_commodity(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.commodities.store'), [
                'code' => 'TEST_CABAI',
                'name' => 'Komoditas Pengujian',
                'unit' => 'kg',
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.commodities.index'));

        $this->assertDatabaseHas('commodities', [
            'code' => 'TEST_CABAI',
            'name' => 'Komoditas Pengujian',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_update_commodity(): void
    {
        $commodity = Commodity::create([
            'code' => 'TEST_AWAL',
            'name' => 'Nama Awal',
            'unit' => 'kg',
            'is_active' => true,
        ]);

        $this->actingAs($this->admin())
            ->put(route('admin.commodities.update', $commodity), [
                'code' => 'TEST_AWAL',
                'name' => 'Nama Diperbarui',
                'unit' => 'kg',
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.commodities.index'));

        $this->assertDatabaseHas('commodities', [
            'id' => $commodity->id,
            'name' => 'Nama Diperbarui',
        ]);
    }

    public function test_admin_can_deactivate_commodity(): void
    {
        $commodity = Commodity::create([
            'code' => 'TEST_STATUS',
            'name' => 'Komoditas Status',
            'unit' => 'kg',
            'is_active' => true,
        ]);

        $this->actingAs($this->admin())
            ->patch(route(
                'admin.commodities.toggle-status',
                $commodity
            ))
            ->assertRedirect(route('admin.commodities.index'));

        $this->assertDatabaseHas('commodities', [
            'id' => $commodity->id,
            'is_active' => false,
        ]);
    }

    public function test_regular_user_cannot_create_commodity(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('admin.commodities.store'), [
                'code' => 'TEST_FORBIDDEN',
                'name' => 'Tidak Boleh Masuk',
                'unit' => 'kg',
                'is_active' => '1',
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing('commodities', [
            'code' => 'TEST_FORBIDDEN',
        ]);
    }
}
