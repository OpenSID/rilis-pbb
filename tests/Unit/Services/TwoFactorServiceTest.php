<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\TwoFactorService;
use App\Services\OtpService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Mockery;

class TwoFactorServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function test_send_two_factor_code_with_invalid_telegram_chat_id()
    {
        // Create a mock OTP service
        $mockOtpService = Mockery::mock(OtpService::class);

        // Create TwoFactorService with mocked OTP service
        $twoFactorService = new TwoFactorService($mockOtpService);

        // Test with invalid Telegram chat ID (non-numeric)
        $result = $twoFactorService->sendTwoFactorCodeWithConfig(1, 'telegram', 'invalid-chat-id');

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Chat ID Telegram tidak valid', $result['message']);
    }

    public function test_send_two_factor_code_with_valid_telegram_chat_id()
    {
        // Create a mock OTP service
        $mockOtpService = Mockery::mock(OtpService::class);
        $mockOtpService->shouldReceive('generateAndSend')
            ->with(1, 'telegram', '123456789', '2fa')
            ->andReturn([
                'success' => true,
                'message' => 'Kode OTP berhasil dikirim',
                'channel' => 'telegram'
            ]);

        // Create TwoFactorService with mocked OTP service
        $twoFactorService = new TwoFactorService($mockOtpService);

        // Test with valid Telegram chat ID (numeric)
        $result = $twoFactorService->sendTwoFactorCodeWithConfig(1, 'telegram', '123456789');

        $this->assertTrue($result['success']);
        $this->assertEquals('telegram', $result['channel']);
    }

    public function test_send_two_factor_code_works_with_email()
    {
        // Create a user
        $user = User::factory()->create([
            'otp_channel' => json_encode(['email']),
            'otp_identifier' => 'test@example.com'
        ]);

        // Mock the OTP service
        $otpServiceMock = Mockery::mock(OtpService::class);
        $otpServiceMock->shouldReceive('generateAndSend')
            ->once()
            ->with($user->id, 'email', 'test@example.com', '2fa')
            ->andReturn(['success' => true, 'message' => 'Kode 2FA berhasil dikirim', 'channel' => 'email']);

        $this->app->instance(OtpService::class, $otpServiceMock);

        // Create the TwoFactorService
        $twoFactorService = new TwoFactorService($otpServiceMock);

        // Call the method
        $result = $twoFactorService->sendTwoFactorCode($user->id);

        // Assert the result
        $this->assertTrue($result['success']);
        $this->assertEquals('Kode 2FA berhasil dikirim', $result['message']);
        $this->assertEquals('email', $result['channel']);
    }

    public function test_send_two_factor_code_works_with_telegram()
    {
        // Create a user
        $user = User::factory()->create([
            'otp_channel' => json_encode(['telegram']),
            'otp_identifier' => '123456789'
        ]);

        // Mock the OTP service
        $otpServiceMock = Mockery::mock(OtpService::class);
        $otpServiceMock->shouldReceive('generateAndSend')
            ->once()
            ->with($user->id, 'telegram', '123456789', '2fa')
            ->andReturn(['success' => true, 'message' => 'Kode 2FA berhasil dikirim', 'channel' => 'telegram']);

        $this->app->instance(OtpService::class, $otpServiceMock);

        // Create the TwoFactorService
        $twoFactorService = new TwoFactorService($otpServiceMock);

        // Call the method
        $result = $twoFactorService->sendTwoFactorCode($user->id);

        // Assert the result
        $this->assertTrue($result['success']);
        $this->assertEquals('Kode 2FA berhasil dikirim', $result['message']);
        $this->assertEquals('telegram', $result['channel']);
    }

    public function test_send_two_factor_code_fails_when_not_configured()
    {
        // Create a user without 2FA configured
        $user = User::factory()->create([
            'otp_channel' => null,
            'otp_identifier' => null
        ]);

        // Create the TwoFactorService with a real OTP service
        $otpService = $this->app->make(OtpService::class);
        $twoFactorService = new TwoFactorService($otpService);

        // Call the method
        $result = $twoFactorService->sendTwoFactorCode($user->id);

        // Assert the result
        $this->assertFalse($result['success']);
        $this->assertEquals('Pengguna belum mengkonfigurasi metode 2FA. Silakan atur terlebih dahulu.', $result['message']);
    }
}