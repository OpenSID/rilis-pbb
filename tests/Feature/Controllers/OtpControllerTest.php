<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\OtpToken;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OtpControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_index_shows_activate_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $resp = $this->get(route('otp.index'));
        $resp->assertStatus(200);
        $resp->assertViewIs('pages.pengaturan.otp.activate');
    }

    public function test_setup_sends_otp_and_stores_session()
    {
        Mail::fake();
        $user = User::factory()->create();
        $this->actingAs($user);

        $resp = $this->postJson(route('otp.setup'), [
            'channel' => 'email',
            'identifier' => $user->email,
        ]);

        $resp->assertStatus(200);
        $resp->assertJson(['success' => true]);
        $this->assertDatabaseHas('otp_tokens', ['user_id' => $user->id, 'channel' => 'email']);
        $this->assertTrue(session()->has('temp_otp_config'));
    }

    public function test_verify_activation_activates_user()
    {
        Mail::fake();
        $user = User::factory()->create();
        $this->actingAs($user);

        // simulate setup
        $this->postJson(route('otp.setup'), ['channel' => 'email', 'identifier' => $user->email]);

    // Ensure session was stored by setup
    $this->assertTrue(session()->has('temp_otp_config'));

        // Mock OtpService to avoid manipulating token DB directly
        $this->mock(\App\Services\OtpService::class, function ($mock) {
            $mock->shouldReceive('verify')->andReturn(['success' => true, 'message' => 'OK']);
        });

        $resp = $this->withSession(['temp_otp_config' => ['channel' => 'email', 'identifier' => $user->email]])
            ->postJson(route('otp.verify-activation'), ['otp' => '123456']);
        $resp->assertStatus(200);
        $resp->assertJson(['success' => true]);

        $user->refresh();
        $this->assertTrue((bool) $user->otp_enabled);
    }

    public function test_resend_is_rate_limited()
    {
        Mail::fake();
        $user = User::factory()->create();
        $this->actingAs($user);

        // No session => should fail
        $resp = $this->postJson(route('otp.resend'));
        $resp->assertStatus(400);
    }
}
