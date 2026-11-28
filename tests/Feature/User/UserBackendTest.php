<?php

namespace Tests\Feature\User;

use App\Models\Commodity;
use App\Models\Market;
use App\Models\PriceRecord;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserBackendTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--path' => [
                'database/migrations/0001_01_01_000000_create_users_table.php',
                'database/migrations/2026_11_28_042954_add_role_and_is_active_to_users_table.php',
                'database/migrations/2026_11_28_100000_add_business_name_and_phone_to_users_table.php',
                'database/migrations/2026_11_28_042955_create_commodities_table.php',
                'database/migrations/2026_11_28_042955_create_markets_table.php',
                'database/migrations/2026_11_28_042956_create_data_imports_table.php',
                'database/migrations/2026_11_28_100001_create_user_watchlists_table.php',
            ],
        ]);

        // SQLite does not support PostgreSQL's ALTER TABLE ... ADD CONSTRAINT CHECK syntax
        // in 2026_11_28_042957_create_price_records_table.php, so create equivalent table locally.
        Schema::create('price_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commodity_id')->constrained('commodities')->restrictOnDelete();
            $table->foreignId('market_id')->constrained('markets')->restrictOnDelete();
            $table->date('price_date');
            $table->decimal('price', 14, 2);
            $table->string('source_name', 150);
            $table->foreignId('data_import_id')->nullable()->constrained('data_imports')->nullOnDelete();
            $table->timestamps();
            $table->unique(['commodity_id', 'market_id', 'price_date'], 'price_records_unique_daily_price');
        });
    }

    public function test_dashboard_and_profile_render_authenticated_user_identity_without_dummy_name(): void
    {
        $user = User::factory()->create([
            'name' => 'Siti Rahma',
            'business_name' => 'Warung Berkah',
            'email' => 'siti@warungberkah.id',
            'role' => 'user',
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertStatus(200)
            ->assertSee('Siti Rahma')
            ->assertSee('Warung Berkah')
            ->assertDontSee('Dapur Bu Tya');

        $this->actingAs($user)
            ->get('/profil')
            ->assertStatus(200)
            ->assertSee('Siti Rahma')
            ->assertSee('Warung Berkah')
            ->assertSee('siti@warungberkah.id')
            ->assertDontSee('Dapur Bu Tya');
    }

    public function test_dashboard_and_commodity_detail_read_actual_database_prices_consistently(): void
    {
        $user = User::factory()->create(['role' => 'user', 'is_active' => true]);

        $commodity = Commodity::create([
            'code' => 'CABAI_RAWIT',
            'name' => 'Cabai Rawit Merah',
            'unit' => 'kg',
            'is_active' => true,
        ]);
        $emptyCommodity = Commodity::create([
            'code' => 'BAWANG_PUTIH',
            'name' => 'Bawang Putih Kating',
            'unit' => 'kg',
            'is_active' => true,
        ]);
        $market = Market::create([
            'code' => 'PASAR_TURI',
            'name' => 'Pasar Turi Surabaya',
            'city' => 'Surabaya',
            'province' => 'Jawa Timur',
            'scope_type' => 'market',
            'is_active' => true,
        ]);

        PriceRecord::create([
            'commodity_id' => $commodity->id,
            'market_id' => $market->id,
            'price_date' => '2026-11-26',
            'price' => 48000.00,
            'source_name' => 'Panel Harga Pangan',
        ]);
        PriceRecord::create([
            'commodity_id' => $commodity->id,
            'market_id' => $market->id,
            'price_date' => '2026-11-27',
            'price' => 52000.00,
            'source_name' => 'Panel Harga Pangan',
        ]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertStatus(200)
            ->assertSee('DATA AKTUAL')
            ->assertSee('Cabai Rawit Merah')
            ->assertSee('Rp52.000')
            ->assertSee('Pasar Turi Surabaya')
            ->assertSee('naik Rp4.000 dari sebelumnya (+8,3%)')
            ->assertSee('Bawang Putih Kating')
            ->assertSee('Harga belum tersedia');

        $this->actingAs($user)
            ->get('/komoditas/CABAI_RAWIT')
            ->assertStatus(200)
            ->assertSee('Cabai Rawit Merah')
            ->assertSee('Rp52.000')
            ->assertSee('Pasar Turi Surabaya')
            ->assertSee('Proyeksi belum tersedia');

        $this->actingAs($user)
            ->get('/komoditas/BAWANG_PUTIH')
            ->assertStatus(200)
            ->assertSee('Grafik belum tersedia')
            ->assertSee('Proyeksi belum tersedia');

        $this->actingAs($user)
            ->get('/komoditas/KODE_TIDAK_ADA')
            ->assertStatus(404);
    }

    public function test_authenticated_user_can_update_and_view_own_watchlist_only(): void
    {
        $owner = User::factory()->create(['role' => 'user', 'is_active' => true]);
        $otherUser = User::factory()->create(['role' => 'user', 'is_active' => true]);

        $cabai = Commodity::create([
            'code' => 'CABAI_RAWIT',
            'name' => 'Cabai Rawit Merah',
            'unit' => 'kg',
            'is_active' => true,
        ]);
        $telur = Commodity::create([
            'code' => 'TELUR_AYAM',
            'name' => 'Telur Ayam Ras',
            'unit' => 'kg',
            'is_active' => true,
        ]);

        // Empty selection is rejected
        $this->actingAs($owner)
            ->putJson('/pengaturan/pantauan', ['commodity_codes' => []])
            ->assertStatus(422)
            ->assertJsonValidationErrors('commodity_codes');

        // Owner updates watchlist to TELUR_AYAM only
        $this->actingAs($owner)
            ->putJson('/pengaturan/pantauan', ['commodity_codes' => ['TELUR_AYAM']])
            ->assertStatus(200)
            ->assertJsonPath('tracked_codes', ['TELUR_AYAM']);

        $this->assertDatabaseHas('user_watchlists', [
            'user_id' => $owner->id,
            'commodity_id' => $telur->id,
        ]);
        $this->assertDatabaseMissing('user_watchlists', [
            'user_id' => $owner->id,
            'commodity_id' => $cabai->id,
        ]);

        // Other user's watchlist remains unaffected
        $this->assertDatabaseMissing('user_watchlists', [
            'user_id' => $otherUser->id,
            'commodity_id' => $telur->id,
        ]);

        // Owner sees updated watchlist on /profil
        $this->actingAs($owner)
            ->get('/profil')
            ->assertStatus(200)
            ->assertSee('Telur Ayam Ras');
    }
}
