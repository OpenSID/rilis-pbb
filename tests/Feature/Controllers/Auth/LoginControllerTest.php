<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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
        $password = 'SuperSecret123@!#';

        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => $password, // Pass plain text, let mutator hash it
        ]);

        $response = $this->post(route('login.post'), [
            'username' => 'testuser',
            'password' => $password,
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('./'); // HOME constant is './'
        $response->assertSessionHas('success-login', 'Anda telah berhasil login.');
    }

    public function test_user_can_login_with_email()
    {
        $password = 'SuperSecret123@!#';

        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => $password,
        ]);

        $response = $this->post(route('login.post'), [
            'username' => 'test@example.com',
            'password' => $password,
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('./');
    }

    public function test_user_with_weak_password_is_redirected_to_change_password()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => 'weak', // This should trigger weak password logic
        ]);

        $response = $this->post(route('login.post'), [
            'username' => 'testuser',
            'password' => 'weak',
        ]);

        $this->assertAuthenticatedAs($user);
        // Check that redirect contains /pengguna/ and /edit, but don't check exact encrypted ID
        $this->assertTrue(str_contains($response->getTargetUrl(), '/pengguna/'));
        $this->assertTrue(str_contains($response->getTargetUrl(), '/edit'));
        $response->assertSessionHas('success-login', 'Ganti password dengan yang lebih kuat');
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'password' => 'SuperSecret123@!#',
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
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }

    public function test_login_throttling_works()
    {
        // Make multiple failed login attempts to trigger throttling
        for ($i = 0; $i < 3; $i++) {
            $this->post(route('login.post'), [
                'username' => 'testuser',
                'password' => 'wrongpassword',
            ]);
        }

        // The 4th attempt should be throttled (redirected back with error message)
        $response = $this->post(route('login.post'), [
            'username' => 'testuser',
            'password' => 'wrongpassword',
        ]);

        // Check if throttling message exists in session
        $response->assertSessionHasErrors();
        $this->assertTrue(session()->has('errors'));
    }

    public function test_login_requires_username_and_password()
    {
        $response = $this->post(route('login.post'), []);

        $response->assertSessionHasErrors(['username', 'password']);
    }
}
