<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class HealthCheckControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_health_check_endpoint_is_accessible()
    {
        $this->markTestSkipped('Health check requires external service configuration');

        $response = $this->get('/healthcheck');

        $response->assertStatus(200);
    }

    public function test_health_check_returns_json()
    {
        $response = $this->get('/healthcheck');

        $response->assertJsonStructure([
            'database',
            'premium',
            'production'
        ]);
    }

    public function test_database_health_check_passes()
    {
        $response = $this->get('/healthcheck');

        $response->assertJson(['database' => true]);
    }

    public function test_premium_health_check_with_valid_config()
    {
        Http::fake([
            '*' => Http::response(['status' => 'ok'], 200)
        ]);

        Config::set('services.pbb.domain', 'https://test.domain.com');
        Config::set('services.pbb.secret', 'test-secret');
        Config::set('services.pbb.key', 'test-key');

        $response = $this->get('/healthcheck');

        $response->assertJson(['premium' => true]);
    }

    public function test_premium_health_check_fails_with_invalid_config()
    {
        Http::fake([
            '*' => Http::response([], 500)
        ]);

        Config::set('services.pbb.domain', 'https://invalid.domain.com');
        Config::set('services.pbb.secret', 'invalid-secret');
        Config::set('services.pbb.key', 'invalid-key');

        $response = $this->get('/healthcheck');

        $response->assertJson(['premium' => false]);
    }

    public function test_production_health_check_in_testing_environment()
    {
        $response = $this->get('/healthcheck');

        // In testing environment, this should be false
        $response->assertJson(['production' => false]);
    }
}
