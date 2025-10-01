<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class NewPasswordControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_new_password_page_can_be_accessed()
    {
        $response = $this->get(route('password.reset', [
            'token' => 'test-token',
            'email' => 'test@example.com'
        ]));

        $response->assertStatus(200);
        $response->assertViewIs('auth.sandi-baru');
        $response->assertViewHas('request');
    }

    public function test_password_can_be_reset_with_valid_token()
    {
        $user = User::factory()->create(['email' => 'test@example.com']);

        $token = Password::createToken($user);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => 'test@example.com',
            'password' => 'UniqueSecure987#@!',
            'password_confirmation' => 'UniqueSecure987#@!'
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('status');

        // Verify password was actually changed
        $user->refresh();
        $this->assertTrue(Hash::check('UniqueSecure987#@!', $user->password));
    }

    public function test_password_reset_requires_token()
    {
        $response = $this->post(route('password.update'), [
            'email' => 'test@example.com',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!'
        ]);

        $response->assertSessionHasErrors(['token']);
    }

    public function test_password_reset_requires_email()
    {
        $response = $this->post(route('password.update'), [
            'token' => 'test-token',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!'
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_password_reset_requires_valid_email()
    {
        $response = $this->post(route('password.update'), [
            'token' => 'test-token',
            'email' => 'invalid-email',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!'
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_password_reset_requires_password()
    {
        $response = $this->post(route('password.update'), [
            'token' => 'test-token',
            'email' => 'test@example.com',
            'password_confirmation' => 'NewPassword123!'
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_password_reset_requires_password_confirmation()
    {
        $response = $this->post(route('password.update'), [
            'token' => 'test-token',
            'email' => 'test@example.com',
            'password' => 'NewPassword123!'
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_password_reset_validates_password_strength()
    {
        $response = $this->post(route('password.update'), [
            'token' => 'test-token',
            'email' => 'test@example.com',
            'password' => 'weak',
            'password_confirmation' => 'weak'
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_password_reset_requires_matching_passwords()
    {
        $response = $this->post(route('password.update'), [
            'token' => 'test-token',
            'email' => 'test@example.com',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'DifferentPassword123!'
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_password_reset_fails_with_invalid_token()
    {
        $user = User::factory()->create(['email' => 'test@example.com']);

        $response = $this->post(route('password.update'), [
            'token' => 'invalid-token',
            'email' => 'test@example.com',
            'password' => 'UniqueSecure456!@#',
            'password_confirmation' => 'UniqueSecure456!@#'
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['email']);
    }
}
