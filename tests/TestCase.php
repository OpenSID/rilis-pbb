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
    }
}
