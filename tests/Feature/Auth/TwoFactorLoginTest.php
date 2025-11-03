<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;

class TwoFactorLoginTest extends TestCase
{
    use DatabaseTransactions;

    public function test_2fa_login_routes_exist()
    {
        // Test that the routes exist and can be accessed
        $this->assertTrue(route('2fa-login.form') !== null);
        $this->assertTrue(route('2fa-login.send') !== null);
        $this->assertTrue(route('2fa-login.verify') !== null);
        $this->assertTrue(route('2fa-login.resend') !== null);
    }

    public function test_2fa_login_page_loads_successfully()
    {
        $response = $this->get(route('2fa-login.form'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.2fa-login');
    }

    public function test_user_with_2fa_enabled_is_redirected_to_2fa_login()
    {
        // Create a user with 2FA enabled
        $user = User::factory()->create([
            'password' => 'Password123!', // Use a strong password
            'twofa_enabled' => true,
        ]);

        // Attempt to login with regular credentials
        $response = $this->post(route('login.post'), [
            'username' => $user->email, // Use email in the username field
            'password' => 'Password123!' // Use the correct password
        ]);

        // Should redirect to 2FA login page
        $response->assertRedirect(route('2fa-login.form'));

        // Check that user identifier is stored in session
        $this->assertNotNull(session('2fa_user_identifier'));
        $this->assertEquals($user->email, session('2fa_user_identifier'));
    }

    public function test_user_without_2fa_enabled_logs_in_normally()
    {
        // Create a user without 2FA enabled
        $user = User::factory()->create([
            'password' => 'Password123!', // Use a strong password
            'twofa_enabled' => false
        ]);

        // Attempt to login with regular credentials
        $response = $this->post(route('login.post'), [
            'username' => $user->email, // Use email in the username field
            'password' => 'Password123!' // Use the correct password
        ]);

        // Should redirect to home page or password change page (both are valid after login)
        $response->assertStatus(302); // Check that it's a redirect
        $location = $response->headers->get('Location');

        // Either redirect to home page or to password change page
        $this->assertTrue(
            $location === '/' ||
            strpos($location, '/pengguna/') !== false,
            'Expected redirect to home page or user edit page, got: ' . $location
        );
    }
}