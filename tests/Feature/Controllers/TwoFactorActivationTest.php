<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Mockery;

class TwoFactorActivationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_activate_page_loads_successfully()
    {
        // Create a user
        $user = User::factory()->create();

        // Act as the user and visit the activation page
        $response = $this->actingAs($user)->get(route('2fa.activate'));

        // Assert the page loads successfully
        $response->assertStatus(200);
        $response->assertViewIs('pages.pengaturan.2fa.activate');
    }

    public function test_activate_page_does_not_send_code_automatically()
    {
        // Create a user with 2FA configured but not enabled
        $user = User::factory()->create([
            'twofa_enabled' => false
        ]);

        // Mock the TwoFactorService to verify that sendTwoFactorCode is NOT called automatically
        $twoFactorServiceMock = Mockery::mock(\App\Services\TwoFactorService::class);
        $twoFactorServiceMock->shouldNotReceive('sendTwoFactorCode');
        $twoFactorServiceMock->shouldNotReceive('sendTwoFactorCodeWithConfig');

        $this->app->instance(\App\Services\TwoFactorService::class, $twoFactorServiceMock);

        // Act as the user and visit the activation page
        $response = $this->actingAs($user)->get(route('2fa.activate'));

        // Assert the page loads successfully
        $response->assertStatus(200);
        $response->assertViewIs('pages.pengaturan.2fa.activate');
    }
}