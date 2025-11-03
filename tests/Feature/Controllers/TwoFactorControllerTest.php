<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\OtpToken;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TwoFactorControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_settings_page_loads_successfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('2fa.settings'));
        $response->assertStatus(200);
        $response->assertViewIs('pages.pengaturan.2fa.settings');
    }

    public function test_activate_page_loads_successfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('2fa.activate'));
        $response->assertStatus(200);
        $response->assertViewIs('pages.pengaturan.2fa.activate');
    }

    public function test_setup_2fa_stores_temporary_configuration_in_session()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('2fa.setup'), [
            'method' => 'email',
            'contact' => $user->email,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Check that the temporary configuration is stored in the session
        $this->assertNotNull(session('temp_2fa_config'));
        $this->assertEquals([
            'method' => 'email',
            'contact' => $user->email,
        ], session('temp_2fa_config'));

        // Check that user data is not yet updated
        $user->refresh();
        $this->assertFalse((bool) $user->twofa_enabled);
    }

    public function test_resend_requires_temporary_configuration_in_session()
    {
        Mail::fake();
        $user = User::factory()->create();
        $this->actingAs($user);

        // No temporary configuration in session
        $response = $this->postJson(route('2fa.resend'));
        $response->assertStatus(400);
        $response->assertJson(['success' => false]);
    }

    public function test_resend_works_with_temporary_configuration()
    {
        Mail::fake();
        $user = User::factory()->create();
        $this->actingAs($user);

        // Set up temporary configuration in session
        session([
            'temp_2fa_config' => [
                'method' => 'email',
                'contact' => $user->email,
            ]
        ]);

        $response = $this->postJson(route('2fa.resend'));
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('otp_tokens', ['user_id' => $user->id, 'channel' => 'email']);
    }

    public function test_resend_works_with_telegram_method()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Set up temporary configuration in session
        session([
            'temp_2fa_config' => [
                'method' => 'telegram',
                'contact' => '123456789',
            ]
        ]);

        // Mock the Telegram sending to avoid actual API calls
        $this->mock(\App\Services\OtpService::class, function ($mock) {
            $mock->shouldReceive('generateAndSend')->andReturn(['success' => true, 'message' => 'Kode OTP berhasil dikirim']);
        });

        $response = $this->postJson(route('2fa.resend'));
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_verify_activation_enables_2fa_and_saves_to_database()
    {
        Mail::fake();
        $user = User::factory()->create();
        $this->actingAs($user);

        // Set up temporary configuration in session
        session([
            'temp_2fa_config' => [
                'method' => 'email',
                'contact' => $user->email,
            ]
        ]);

        // Mock OtpService to avoid manipulating token DB directly
        $this->mock(\App\Services\OtpService::class, function ($mock) {
            $mock->shouldReceive('verify')->andReturn(['success' => true, 'message' => 'OK']);
        });

        $response = $this->postJson(route('2fa.verify-activation'), [
            'code' => '123456'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Check that user data is now updated
        $user->refresh();
        $this->assertTrue((bool) $user->twofa_enabled);

        // Check that temporary configuration is cleared
        $this->assertNull(session('temp_2fa_config'));
    }

    public function test_disable_2fa_works_correctly()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Enable 2FA first
        $user->update([
            'twofa_enabled' => true,
        ]);

        // Create an OTP token for this user
        OtpToken::create([
            'user_id' => $user->id,
            'token_hash' => 'sample_hash',
            'channel' => 'email',
            'identifier' => $user->email,
            'expires_at' => now()->addMinutes(5),
        ]);

        $response = $this->postJson(route('2fa.disable'));
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $user->refresh();
        $this->assertFalse((bool) $user->twofa_enabled);
        $this->assertDatabaseMissing('otp_tokens', ['user_id' => $user->id]);
    }

    public function test_2fa_activation_fails_with_invalid_code()
    {
        Mail::fake();
        $user = User::factory()->create();
        $this->actingAs($user);

        // Set up temporary configuration in session
        session([
            'temp_2fa_config' => [
                'method' => 'email',
                'contact' => $user->email,
            ]
        ]);

        // Mock OtpService to simulate failed verification
        $this->mock(\App\Services\OtpService::class, function ($mock) {
            $mock->shouldReceive('verify')->andReturn(['success' => false, 'message' => 'Kode OTP salah']);
        });

        $response = $this->postJson(route('2fa.verify-activation'), [
            'code' => '000000'
        ]);

        $response->assertStatus(400);
        $response->assertJson(['success' => false]);

        $user->refresh();
        $this->assertFalse((bool) $user->twofa_enabled);
    }
}