<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--path' => [
                'database/migrations/0001_01_01_000000_create_users_table.php',
                'database/migrations/2026_11_28_042954_add_role_and_is_active_to_users_table.php',
                'database/migrations/2026_11_28_100000_add_business_name_and_phone_to_users_table.php',
            ],
        ]);
    }

    public function test_login_and_register_pages_are_accessible_to_guests(): void
    {
        $this->get('/login')->assertStatus(200);
        $this->get('/register')->assertStatus(200);
    }

    public function test_guest_is_redirected_to_login_from_protected_user_routes(): void
    {
        $protectedRoutes = [
            '/dashboard',
            '/komoditas/cabai-rawit-merah',
            '/komoditas/cabai-rawit-merah/prakiraan',
            '/rekomendasi',
            '/pengaturan',
            '/profil',
            '/bantuan/prediksi/cabai-rawit-merah',
        ];

        foreach ($protectedRoutes as $uri) {
            $this->get($uri)->assertRedirect('/login');
        }
    }

    public function test_user_can_register_and_is_redirected_to_dashboard(): void
    {
        $response = $this->post('/register', [
            'business_name' => 'Warung Bu Rina',
            'owner_name' => 'Ibu Rina',
            'identity' => 'rina@warung.com',
            'password' => 'Secret123',
            'password_confirmation' => 'Secret123',
            'terms' => 'on',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        $user = User::where('email', 'rina@warung.com')->first();
        $this->assertNotNull($user);
        $this->assertSame('Ibu Rina', $user->name);
        $this->assertSame('Warung Bu Rina', $user->business_name);
        $this->assertSame('user', $user->role);
        $this->assertTrue($user->is_active);
    }

    public function test_login_is_rate_limited_after_five_failed_attempts(): void
    {
        User::factory()->create([
            'email' => 'ratelimit@example.com',
            'password' => 'Secret123',
            'role' => 'user',
            'is_active' => true,
        ]);

        for ($i = 0; $i < 5; $i++) {
            $this->from('/login')->post('/login', [
                'identity' => 'ratelimit@example.com',
                'password' => 'WrongPassword',
            ])->assertRedirect('/login');
        }

        $response = $this->from('/login')->post('/login', [
            'identity' => 'ratelimit@example.com',
            'password' => 'WrongPassword',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('identity');
        $this->assertGuest();
    }

    public function test_active_user_can_login_and_access_user_routes(): void
    {
        $user = User::factory()->create([
            'email' => 'tya@example.com',
            'password' => 'Secret123',
            'role' => 'user',
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'identity' => 'tya@example.com',
            'password' => 'Secret123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);

        $this->get('/dashboard')->assertStatus(200);
        $this->get('/komoditas/cabai-rawit-merah')->assertStatus(200);
        $this->get('/komoditas/cabai-rawit-merah/prakiraan')->assertStatus(200);
        $this->get('/rekomendasi')->assertStatus(200);
        $this->get('/pengaturan')->assertStatus(200);
        $this->get('/profil')->assertStatus(200);
        $this->get('/bantuan/prediksi/cabai-rawit-merah')->assertStatus(200);
    }

    public function test_inactive_user_cannot_login_or_stay_authenticated(): void
    {
        User::factory()->create([
            'email' => 'nonaktif@example.com',
            'password' => 'Secret123',
            'role' => 'user',
            'is_active' => false,
        ]);

        $response = $this->from('/login')->post('/login', [
            'identity' => 'nonaktif@example.com',
            'password' => 'Secret123',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('identity');
        $this->assertGuest();
    }

    public function test_inactive_authenticated_user_is_logged_out_by_middleware(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'is_active' => false,
        ]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertRedirect('/login')
            ->assertSessionHasErrors('identity');

        $this->assertGuest();
    }

    public function test_invalid_credentials_fail_login(): void
    {
        User::factory()->create([
            'email' => 'user@example.com',
            'password' => 'Secret123',
            'role' => 'user',
            'is_active' => true,
        ]);

        $response = $this->from('/login')->post('/login', [
            'identity' => 'user@example.com',
            'password' => 'WrongPassword',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('identity');
        $this->assertGuest();
    }

    public function test_admin_login_redirects_safely_and_cannot_access_user_only_routes(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@belipas.id',
            'password' => 'Admin1234',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'identity' => 'admin@belipas.id',
            'password' => 'Admin1234',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($admin);

        $this->get('/dashboard')->assertStatus(403);
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
