<?php

namespace Tests\Feature\Admin;

use App\Models\Market;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Tests\TestCase;

class MarketManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        // Pastikan test hanya menggunakan SQLite in-memory.
        if (
            ($_ENV['DB_CONNECTION'] ?? $_SERVER['DB_CONNECTION'] ?? null) !== 'sqlite' ||
            ($_ENV['DB_DATABASE'] ?? $_SERVER['DB_DATABASE'] ?? null) !== ':memory:' ||
            !empty($_ENV['DB_URL'] ?? $_SERVER['DB_URL'] ?? null)
        ) {
            throw new RuntimeException(
                'TEST DIBATALKAN: database harus SQLite in-memory.'
            );
        }

        parent::setUp();

        // Verifikasi konfigurasi yang benar-benar digunakan Laravel.
        if (
            config('database.default') !== 'sqlite' ||
            config('database.connections.sqlite.database') !== ':memory:'
        ) {
            throw new RuntimeException(
                'TEST DIBATALKAN: koneksi Laravel bukan SQLite in-memory.'
            );
        }
    }

    private function admin(): User
    {
        $admin = User::factory()->create();

        $admin->role = 'admin';
        $admin->is_active = true;
        $admin->save();

        return $admin;
    }

    private function market(): Market
    {
        return Market::create([
            'code' => 'TEST_SURABAYA',
            'name' => 'Wilayah Uji Surabaya',
            'city' => 'Surabaya',
            'province' => 'Jawa Timur',
            'scope_type' => 'city',
            'is_active' => true,
        ]);
    }

    public function test_guest_cannot_access_markets(): void
    {
        $this->get(route('admin.markets.index'))
            ->assertRedirect(route('login'));
    }

    public function test_regular_user_cannot_access_markets(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.markets.index'))
            ->assertForbidden();
    }

    public function test_admin_can_view_market_list(): void
    {
        $market = $this->market();

        $this->actingAs($this->admin())
            ->get(route('admin.markets.index'))
            ->assertOk()
            ->assertSee($market->name);
    }

    public function test_admin_can_create_market(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.markets.store'), [
                'code' => 'TEST_JATIM',
                'name' => 'Wilayah Uji Jawa Timur',
                'city' => '',
                'province' => 'Jawa Timur',
                'scope_type' => 'province',
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.markets.index'));

        $this->assertDatabaseHas('markets', [
            'code' => 'TEST_JATIM',
            'scope_type' => 'province',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_update_market(): void
    {
        $market = $this->market();

        $this->actingAs($this->admin())
            ->put(route('admin.markets.update', $market), [
                'code' => 'TEST_SURABAYA',
                'name' => 'Wilayah Surabaya Diperbarui',
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
                'scope_type' => 'city',
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.markets.index'));

        $this->assertDatabaseHas('markets', [
            'id' => $market->id,
            'name' => 'Wilayah Surabaya Diperbarui',
        ]);
    }

    public function test_admin_can_deactivate_market(): void
    {
        $market = $this->market();

        $this->actingAs($this->admin())
            ->patch(route('admin.markets.toggle-status', $market))
            ->assertRedirect(route('admin.markets.index'));

        $this->assertDatabaseHas('markets', [
            'id' => $market->id,
            'is_active' => false,
        ]);
    }

    public function test_invalid_scope_is_rejected(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.markets.store'), [
                'code' => 'TEST_INVALID',
                'name' => 'Wilayah Tidak Valid',
                'scope_type' => 'unknown',
                'is_active' => '1',
            ])
            ->assertSessionHasErrors('scope_type');

        $this->assertDatabaseMissing('markets', [
            'code' => 'TEST_INVALID',
        ]);
    }
}
