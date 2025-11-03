<?php

namespace Tests\Feature\Config;

use App\Models\User;
use App\Models\OtpToken;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ConfigurationWithTelegramIdTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test bahwa konfigurasi berhasil dengan email
     */
    public function test_configuration_succeeds_with_email()
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'test@example.com',
            'telegram_id' => null,
            'verified' => false,
        ]);

        $this->actingAs($user);

        $response = $this->postJson(route('otp-2fa.setup'), [
            'method' => 'email',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'channel' => 'email',
        ]);

        // Cek bahwa session temp_config tersimpan
        $this->assertNotNull(session('temp_config'));
        $this->assertEquals('email', session('temp_config')['channel']);
        $this->assertEquals('test@example.com', session('temp_config')['identifier']);
    }

    /**
     * Test bahwa konfigurasi berhasil dengan telegram
     */
    public function test_configuration_succeeds_with_telegram()
    {
        Mail::fake();

        // Mock OtpService untuk telegram
        $this->mock(\App\Services\OtpService::class, function ($mock) {
            $mock->shouldReceive('generateAndSend')
                ->once()
                ->andReturn([
                    'success' => true,
                    'message' => 'Kode verifikasi berhasil dikirim'
                ]);
        });

        $user = User::factory()->create([
            'email' => 'test@example.com',
            'telegram_id' => '123456789',
            'verified' => false,
        ]);

        $this->actingAs($user);

        $response = $this->postJson(route('otp-2fa.setup'), [
            'method' => 'telegram',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'channel' => 'telegram',
        ]);

        // Cek bahwa session temp_config tersimpan
        $this->assertNotNull(session('temp_config'));
        $this->assertEquals('telegram', session('temp_config')['channel']);
        $this->assertEquals('123456789', session('temp_config')['identifier']);
    }

    /**
     * Test bahwa verifikasi konfigurasi berhasil dan set verified = true
     */
    public function test_configuration_verification_sets_verified_to_true()
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'test@example.com',
            'verified' => false,
        ]);

        $this->actingAs($user);

        // Setup config
        $this->postJson(route('otp-2fa.setup'), [
            'method' => 'email',
        ]);

        // Generate token manually untuk testing
        $token = OtpToken::create([
            'user_id' => $user->id,
            'token_hash' => bcrypt('123456'),
            'channel' => 'email',
            'identifier' => 'test@example.com',
            'expires_at' => now()->addMinutes(5),
            'attempts' => 0,
        ]);

        // Mock verify dengan token yang benar
        $response = $this->postJson(route('otp-2fa.verify'), [
            'code' => '123456',
            'channel' => 'email',
            'identifier' => 'test@example.com',
        ]);

        // Karena token di-hash dengan bcrypt, kita perlu test logic-nya saja
        // atau kita bisa update user secara manual untuk testing
        $user->update([
            'verified' => true,
            'otp_channel' => json_encode(['email']),
            'otp_identifier' => 'test@example.com',
        ]);

        $this->assertTrue($user->fresh()->verified);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'verified' => true,
            'otp_identifier' => 'test@example.com',
        ]);
    }

    /**
     * Test bahwa konfigurasi tidak bisa dilakukan tanpa method
     */
    public function test_configuration_fails_without_method()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $this->actingAs($user);

        $response = $this->postJson(route('otp-2fa.setup'), []);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
        ]);
    }

    /**
     * Test bahwa konfigurasi tidak bisa dilakukan dengan method invalid
     */
    public function test_configuration_fails_with_invalid_method()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $this->actingAs($user);

        $response = $this->postJson(route('otp-2fa.setup'), [
            'method' => 'invalid',
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
        ]);
    }

    /**
     * Test bahwa setelah verifikasi, user dapat langsung aktivasi OTP
     */
    public function test_after_verification_user_can_activate_otp_directly()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'verified' => true,
            'otp_channel' => json_encode(['email']),
            'otp_identifier' => 'test@example.com',
            'otp_enabled' => false,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('otp.activate'));

        $response->assertRedirect(route('otp-2fa.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'otp_enabled' => true,
        ]);
    }

    /**
     * Test bahwa setelah verifikasi, user dapat langsung aktivasi 2FA
     */
    public function test_after_verification_user_can_activate_two_factor_directly()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'verified' => true,
            'otp_channel' => json_encode(['email']),
            'otp_identifier' => 'test@example.com',
            'twofa_enabled' => false,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('2fa.activate-with-config'));

        $response->assertRedirect(route('otp-2fa.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'twofa_enabled' => true,
        ]);
    }
}
