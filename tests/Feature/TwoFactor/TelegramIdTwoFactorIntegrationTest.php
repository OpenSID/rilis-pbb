<?php

namespace Tests\Feature\TwoFactor;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TelegramIdTwoFactorIntegrationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test method getTwoFactorIdentifier() pada model User untuk email
     */
    public function test_get_two_factor_identifier_returns_email_for_email_method()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'telegram_id' => '123456789',
        ]);

        $identifier = $user->getTwoFactorIdentifier('email');

        $this->assertEquals('test@example.com', $identifier);
    }

    /**
     * Test method getTwoFactorIdentifier() pada model User untuk telegram
     */
    public function test_get_two_factor_identifier_returns_telegram_id_for_telegram_method()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'telegram_id' => '123456789',
        ]);

        $identifier = $user->getTwoFactorIdentifier('telegram');

        $this->assertEquals('123456789', $identifier);
    }

    /**
     * Test method getTwoFactorIdentifier() returns null untuk method tidak valid
     */
    public function test_get_two_factor_identifier_returns_null_for_invalid_method()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'telegram_id' => '123456789',
        ]);

        $identifier = $user->getTwoFactorIdentifier('invalid');

        $this->assertNull($identifier);
    }

    /**
     * Test bahwa 2FA dapat menggunakan telegram_id
     */
    public function test_two_factor_can_use_telegram_id()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'telegram_id' => '123456789',
            'verified' => true,
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
     * Test bahwa 2FA dapat menggunakan email
     */
    public function test_two_factor_can_use_email()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'verified' => true,
            'otp_channel' => json_encode(['email']),
            'otp_identifier' => 'test@example.com',
        ]);

        $this->actingAs($user);

        $response = $this->post(route('2fa.activate-with-config'));

        $response->assertRedirect(route('otp-2fa.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'twofa_enabled' => true,
            'email' => 'test@example.com',
        ]);
    }
}
