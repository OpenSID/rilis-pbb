<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_forgot_password_page_can_be_accessed()
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.lupa-sandi');
    }

    public function test_password_reset_link_can_be_requested()
    {
        Notification::fake();

        $user = User::factory()->create(['email' => 'test@example.com']);

        $response = $this->post(route('password.email'), [
            'email' => 'test@example.com'
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status', 'Kami telah mengirim email setel ulang kata sandi Anda!');
    }

    public function test_password_reset_requires_valid_email()
    {
        $response = $this->post(route('password.email'), [
            'email' => 'invalid-email'
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_password_reset_requires_registered_email()
    {
        $response = $this->post(route('password.email'), [
            'email' => 'nonexistent@example.com'
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['email' => 'Email tidak ditemukan, masukkan email yang telah terdaftar']);
    }

    public function test_password_reset_requires_email_field()
    {
        $response = $this->post(route('password.email'), []);

        $response->assertSessionHasErrors(['email']);
    }
}
