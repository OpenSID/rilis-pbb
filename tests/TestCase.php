<?php

namespace Tests;

use App\Http\Middleware\HandlePremiumMiddleware;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(HandlePremiumMiddleware::class);
        
        // Set default tenant for testing
        $this->app->singleton('current_tenant', function () {
            // Create or find a test tenant
            $tenant = \App\Models\Tenant::first();
            if(!$tenant) {
                $tenant = \App\Models\Tenant::create(
                    [
                        'code' => 'test',
                        'name' => 'Test Tenant',
                       'id_start_range' => 100,
                        'id_end_range' => 9999
                    ]
                );
            }
            return $tenant;
        });
    }
}
