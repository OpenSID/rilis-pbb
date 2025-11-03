<?php

namespace Tests\Feature\OTP;

use App\Models\User;
use App\Models\OtpToken;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class VerifiedUserOtpActivationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test bahwa user yang belum verified tidak dapat aktivasi OTP
     */
    public function test_unverified_user_cannot_activate_otp()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'verified' => false,
            'otp_channel' => json_encode(['email']),
            'otp_identifier' => 'test@example.com',
        ]);

        $this->actingAs($user);

        $response = $this->post(route('otp.activate'));

        $response->assertRedirect(route('otp-2fa.settings'));
        $response->assertSessionHas('error', 'Anda belum melakukan verifikasi email/telegram. Silakan verifikasi terlebih dahulu di halaman konfigurasi.');
    }

    /**
     * Test bahwa user yang sudah verified dapat aktivasi OTP langsung tanpa verifikasi
     */
    public function test_verified_user_can_activate_otp_without_verification()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'verified' => true,
            'otp_enabled' => false,
            'otp_channel' => json_encode(['email']),
            'otp_identifier' => 'test@example.com',
        ]);

        $this->actingAs($user);

        $response = $this->post(route('otp.activate'));

        $response->assertRedirect(route('otp-2fa.index'));
        $response->assertSessionHas('success', 'OTP berhasil diaktifkan! Anda sekarang dapat menggunakan OTP untuk login.');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'otp_enabled' => true,
        ]);
    }

    /**
     * Test bahwa verified user dengan telegram_id dapat aktivasi OTP
     */
    public function test_verified_user_with_telegram_id_can_activate_otp()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'telegram_id' => '123456789',
            'verified' => true,
            'otp_enabled' => false,
            'otp_channel' => json_encode(['telegram']),
            'otp_identifier' => '123456789',
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
     * Test bahwa user yang sudah verified tetapi belum ada konfigurasi tidak bisa aktivasi
     */
    public function test_verified_user_without_config_cannot_activate_otp()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'verified' => true,
            'otp_channel' => null,
            'otp_identifier' => null,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('otp.activate'));

        $response->assertRedirect(route('otp-2fa.settings'));
        $response->assertSessionHas('error', 'Anda belum mengkonfigurasi email/telegram. Silakan atur terlebih dahulu.');
    }

    /**
     * Test bahwa user yang sudah aktif OTP tidak bisa aktivasi lagi
     */
    public function test_user_with_active_otp_cannot_activate_again()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'verified' => true,
            'otp_enabled' => true,
            'otp_channel' => json_encode(['email']),
            'otp_identifier' => 'test@example.com',
        ]);

        $this->actingAs($user);

        $response = $this->post(route('otp.activate'));

        $response->assertRedirect(route('otp-2fa.index'));
        $response->assertSessionHas('info', 'OTP sudah aktif untuk akun Anda.');
    }

    /**
     * Test AJAX request untuk aktivasi OTP
     */
    public function test_verified_user_can_activate_otp_via_ajax()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'verified' => true,
            'otp_enabled' => false,
            'otp_channel' => json_encode(['email']),
            'otp_identifier' => 'test@example.com',
        ]);

        $this->actingAs($user);

        $response = $this->postJson(route('otp.activate'));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'OTP berhasil diaktifkan! Anda sekarang dapat menggunakan OTP untuk login.'
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'otp_enabled' => true,
        ]);
    }
}
