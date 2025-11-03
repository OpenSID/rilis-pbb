<?php

namespace Tests\Feature\OTP;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TelegramIdOtpIntegrationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test bahwa user tidak dapat setup OTP dengan telegram jika telegram_id kosong
     */
    public function test_user_cannot_setup_otp_with_telegram_if_telegram_id_is_empty()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'telegram_id' => null,
        ]);

        $this->actingAs($user);

        $response = $this->postJson(route('otp-2fa.setup'), [
            'method' => 'telegram',
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Telegram ID belum diatur. Silakan atur Telegram ID terlebih dahulu di profil Anda.'
        ]);
    }

    /**
     * Test bahwa user dapat setup OTP dengan telegram jika telegram_id terisi
     */
    public function test_user_can_setup_otp_with_telegram_if_telegram_id_is_filled()
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
        ]);

        $this->actingAs($user);

        $response = $this->postJson(route('otp-2fa.setup'), [
            'method' => 'telegram',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }

    /**
     * Test bahwa user dapat setup OTP dengan email
     */
    public function test_user_can_setup_otp_with_email()
    {
        Mail::fake();
        
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'telegram_id' => null,
        ]);

        $this->actingAs($user);

        $response = $this->postJson(route('otp-2fa.setup'), [
            'method' => 'email',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
    }

    /**
     * Test method getOtpIdentifier() pada model User untuk email
     */
    public function test_get_otp_identifier_returns_email_for_email_channel()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'telegram_id' => '123456789',
        ]);

        $identifier = $user->getOtpIdentifier('email');

        $this->assertEquals('test@example.com', $identifier);
    }

    /**
     * Test method getOtpIdentifier() pada model User untuk telegram
     */
    public function test_get_otp_identifier_returns_telegram_id_for_telegram_channel()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'telegram_id' => '123456789',
        ]);

        $identifier = $user->getOtpIdentifier('telegram');

        $this->assertEquals('123456789', $identifier);
    }

    /**
     * Test method getOtpIdentifier() returns null untuk channel tidak valid
     */
    public function test_get_otp_identifier_returns_null_for_invalid_channel()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'telegram_id' => '123456789',
        ]);

        $identifier = $user->getOtpIdentifier('invalid');

        $this->assertNull($identifier);
    }
}
