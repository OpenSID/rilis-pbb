<?php

namespace Tests\Feature\Controllers;

use App\Models\Aplikasi;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_dashboard_can_be_accessed_by_authenticated_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('pages.dashboard.index');
        $response->assertViewHas(['aplikasi', 'periodes', 'currentPeriod']);
    }

    public function test_dashboard_redirects_unauthenticated_user()
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_dashboard_contains_required_data()
    {
        $user = User::factory()->create();

        // Create test data using direct model creation instead of factory
        $periode = new \App\Models\Periode();
        $periode->tahun = date('Y');
        $periode->save();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('currentPeriod', date('Y'));
        $response->assertViewHas('periodes');
        $response->assertViewHas('aplikasi');
    }
}
