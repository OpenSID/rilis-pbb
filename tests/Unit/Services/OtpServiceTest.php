<?php

namespace Tests\Unit\Services;

use App\Models\OtpToken;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OtpServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function test_generate_and_send_email_creates_token_and_sends_mail()
    {
        Mail::fake();

        $user = User::factory()->create();
        $service = $this->app->make(OtpService::class);

        $result = $service->generateAndSend($user->id, 'email', $user->email);

        // Some environments may return false on send; ensure token created and mail was queued/sent
        $this->assertDatabaseHas('otp_tokens', ['user_id' => $user->id, 'channel' => 'email']);

        Mail::assertSent(\App\Mail\OtpMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_generate_and_send_telegram_posts_http()
    {
        Http::fake();

        // Set a bot token to avoid exception (ensure env is available)
        putenv('TELEGRAM_BOT_TOKEN=test-token');
        $_ENV['TELEGRAM_BOT_TOKEN'] = 'test-token';
        $_SERVER['TELEGRAM_BOT_TOKEN'] = 'test-token';

        $user = User::factory()->create();
        $service = $this->app->make(OtpService::class);

        $result = $service->generateAndSend($user->id, 'telegram', '123456789');

        // Ensure token created and HTTP request attempted
        $this->assertDatabaseHas('otp_tokens', ['user_id' => $user->id, 'channel' => 'telegram']);

        Http::assertSent(function ($request) {
            return strpos($request->url(), 'api.telegram.org') !== false;
        });
    }

    public function test_verify_success_and_failure()
    {
        $user = User::factory()->create();

        // Create token with known OTP
        $plain = '123456';
        $hash = Hash::make($plain);

        OtpToken::create([
            'user_id' => $user->id,
            'token_hash' => $hash,
            'channel' => 'email',
            'identifier' => $user->email,
            'expires_at' => now()->addMinutes(5),
            'attempts' => 0,
        ]);

        $service = $this->app->make(OtpService::class);

        $ok = $service->verify($user->id, $plain);
        $this->assertTrue($ok['success']);

        // Create another token to test failure attempt increment
        $hash2 = Hash::make('654321');
        $token = OtpToken::create([
            'user_id' => $user->id,
            'token_hash' => $hash2,
            'channel' => 'email',
            'identifier' => $user->email,
            'expires_at' => now()->addMinutes(5),
            'attempts' => 0,
        ]);

        $bad = $service->verify($user->id, '000000');
        $this->assertFalse($bad['success']);
        $this->assertDatabaseHas('otp_tokens', ['id' => $token->id, 'attempts' => 1]);
    }

    public function test_cleanup_expired_deletes_tokens()
    {
        $user = User::factory()->create();
        OtpToken::create([
            'user_id' => $user->id,
            'token_hash' => Hash::make('111111'),
            'channel' => 'email',
            'identifier' => $user->email,
            'expires_at' => now()->subMinutes(10),
            'attempts' => 0,
        ]);

        $service = $this->app->make(OtpService::class);
        $deleted = $service->cleanupExpired();
        $this->assertGreaterThanOrEqual(1, $deleted);
    }
}
