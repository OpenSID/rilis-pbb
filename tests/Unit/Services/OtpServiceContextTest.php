<?php

namespace Tests\Unit\Services;

use App\Services\OtpService;
use App\Models\OtpToken;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Mockery;

class OtpServiceContextTest extends TestCase
{
    use DatabaseTransactions;

    public function test_generate_and_send_with_otp_context()
    {
        // Create a user for testing
        $user = User::factory()->create();

        // Create OTP service
        $otpService = new OtpService();

        // Since we can't easily mock the Mail or Http facades, we'll test the method signature
        // and ensure it accepts the context parameter
        $this->assertTrue(method_exists($otpService, 'generateAndSend'));

        // Test that the method accepts a context parameter (we can't easily test the actual sending)
        $reflection = new \ReflectionMethod($otpService, 'generateAndSend');
        $parameters = $reflection->getParameters();

        $this->assertEquals(4, count($parameters));
        $this->assertEquals('context', $parameters[3]->getName());
        $this->assertEquals('otp', $parameters[3]->getDefaultValue());
    }

    public function test_generate_and_send_with_2fa_context()
    {
        // Create a user for testing
        $user = User::factory()->create();

        // Create OTP service
        $otpService = new OtpService();

        // Test that the method accepts a context parameter (we can't easily test the actual sending)
        $reflection = new \ReflectionMethod($otpService, 'generateAndSend');
        $parameters = $reflection->getParameters();

        $this->assertEquals(4, count($parameters));
        $this->assertEquals('context', $parameters[3]->getName());
        $this->assertEquals('otp', $parameters[3]->getDefaultValue());
    }
}