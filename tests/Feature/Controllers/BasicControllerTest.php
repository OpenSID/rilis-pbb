<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BasicControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_login_page_is_accessible()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_access_dashboard()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
    }

    public function test_logout_functionality()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    public function test_unauthenticated_access_redirects_to_login()
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_password_request_page_is_accessible()
    {
        $response = $this->get('/lupa-kata-sandi');

        $response->assertStatus(200);
    }
}
