<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_login_page_can_be_accessed()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => Hash::make('TestPassword123!'),
        ]);

        $response = $this->post(route('login.post'), [
            'username' => 'testuser',
            'password' => 'TestPassword123!',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(RouteServiceProvider::HOME);
        $response->assertSessionHas('success-login', 'Anda telah berhasil login.');
    }

    public function test_user_can_login_with_email()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('TestPassword123!'),
        ]);

        $response = $this->post(route('login.post'), [
            'username' => 'test@example.com',
            'password' => 'TestPassword123!',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_user_with_weak_password_is_redirected_to_change_password()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => Hash::make('weak'),
        ]);

        $response = $this->post(route('login.post'), [
            'username' => 'testuser',
            'password' => 'weak',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/validasi');
        $response->assertSessionHas('warning-login', 'Kata sandi Anda lemah, silakan ubah kata sandi Anda.');
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('login.post'), [
            'username' => 'testuser',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['message']);
    }

    public function test_user_cannot_login_with_nonexistent_username()
    {
        $response = $this->post(route('login.post'), [
            'username' => 'nonexistent',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors(['message']);
    }

    public function test_user_cannot_access_protected_routes_when_not_authenticated()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_login_throttling_works()
    {
        // Make multiple failed login attempts to trigger throttling
        for ($i = 0; $i < 4; $i++) {
            $this->post(route('login.post'), [
                'username' => 'testuser',
                'password' => 'wrongpassword',
            ]);
        }

        // The 4th attempt should be throttled
        $response = $this->post(route('login.post'), [
            'username' => 'testuser',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(429); // Too Many Requests
    }

    public function test_login_requires_username_and_password()
    {
        $response = $this->post(route('login.post'), []);

        $response->assertSessionHasErrors(['username', 'password']);
    }
}
