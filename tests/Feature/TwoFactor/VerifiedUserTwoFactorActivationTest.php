<?php

namespace Tests\Feature\TwoFactor;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class VerifiedUserTwoFactorActivationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test bahwa user yang belum verified tidak dapat aktivasi 2FA
     */
    public function test_unverified_user_cannot_activate_two_factor()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'verified' => false,
            'otp_channel' => json_encode(['email']),
            'otp_identifier' => 'test@example.com',
        ]);

        $this->actingAs($user);

        $response = $this->post(route('2fa.activate-with-config'));

        $response->assertRedirect(route('otp-2fa.settings'));
        $response->assertSessionHas('error', 'Anda belum melakukan verifikasi email/telegram. Silakan verifikasi terlebih dahulu di halaman konfigurasi.');
    }

    /**
     * Test bahwa user yang sudah verified dapat aktivasi 2FA langsung tanpa verifikasi
     */
    public function test_verified_user_can_activate_two_factor_without_verification()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'verified' => true,
            'twofa_enabled' => false,
            'otp_channel' => json_encode(['email']),
            'otp_identifier' => 'test@example.com',
        ]);

        $this->actingAs($user);

        $response = $this->post(route('2fa.activate-with-config'));

        $response->assertRedirect(route('otp-2fa.index'));
        $response->assertSessionHas('success', '2FA berhasil diaktifkan! Anda sekarang dapat menggunakan 2FA untuk login.');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'twofa_enabled' => true,
        ]);
    }

    /**
     * Test bahwa verified user dengan telegram_id dapat aktivasi 2FA
     */
    public function test_verified_user_with_telegram_id_can_activate_two_factor()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'telegram_id' => '123456789',
            'verified' => true,
            'twofa_enabled' => false,
            'otp_channel' => json_encode(['telegram']),
            'otp_identifier' => '123456789',
        ]);

        $this->actingAs($user);

        $response = $this->post(route('2fa.activate-with-config'));

        $response->assertRedirect(route('otp-2fa.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'twofa_enabled' => true,
            'telegram_id' => '123456789',
        ]);
    }

    /**
     * Test bahwa user yang sudah verified tetapi belum ada konfigurasi tidak bisa aktivasi
     */
    public function test_verified_user_without_config_cannot_activate_two_factor()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'verified' => true,
            'otp_channel' => null,
            'otp_identifier' => null,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('2fa.activate-with-config'));

        $response->assertRedirect(route('otp-2fa.settings'));
        $response->assertSessionHas('error', 'Anda belum mengkonfigurasi email/telegram. Silakan atur terlebih dahulu.');
    }

    /**
     * Test bahwa user yang sudah aktif 2FA tidak bisa aktivasi lagi
     */
    public function test_user_with_active_two_factor_cannot_activate_again()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'verified' => true,
            'twofa_enabled' => true,
            'otp_channel' => json_encode(['email']),
            'otp_identifier' => 'test@example.com',
        ]);

        $this->actingAs($user);

        $response = $this->post(route('2fa.activate-with-config'));

        $response->assertRedirect(route('otp-2fa.index'));
        $response->assertSessionHas('info', '2FA sudah aktif untuk akun Anda.');
    }

    /**
     * Test AJAX request untuk aktivasi 2FA
     */
    public function test_verified_user_can_activate_two_factor_via_ajax()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'verified' => true,
            'twofa_enabled' => false,
            'otp_channel' => json_encode(['email']),
            'otp_identifier' => 'test@example.com',
        ]);

        $this->actingAs($user);

        $response = $this->postJson(route('2fa.activate-with-config'));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => '2FA berhasil diaktifkan! Anda sekarang dapat menggunakan 2FA untuk login.'
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'twofa_enabled' => true,
        ]);
    }

    /**
     * Test bahwa 2FA menyimpan konfigurasi dengan benar
     */
    public function test_two_factor_saves_method_and_contact_correctly()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'telegram_id' => '987654321',
            'verified' => true,
            'twofa_enabled' => false,
            'otp_channel' => json_encode(['telegram']),
            'otp_identifier' => '987654321',
        ]);

        $this->actingAs($user);

        $response = $this->post(route('2fa.activate-with-config'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'twofa_enabled' => true,
            'telegram_id' => '987654321',
        ]);
        
        // Verify getTwoFactorIdentifier returns correct value
        $user->refresh();
        $this->assertEquals('987654321', $user->getTwoFactorIdentifier('telegram'));
    }
}
