<?php

namespace Tests\Feature\Policies;

use App\Models\Aplikasi;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CustomCSPPolicyTest extends TestCase
{
    use DatabaseTransactions;
    /** @test */
    public function csp_connect_directive_uses_origin_from_full_url()
    {
        $opensidUrl = 'https://opensid.example.com:8080/api/v1';

        Aplikasi::updateOrCreate(
            ['key' => 'opensid_url'],
            ['value' => $opensidUrl, 'jenis' => 'text', 'kategori' => 'integrasi']
        );

        $origin = getOrigin($opensidUrl);

        $this->assertEquals('https://opensid.example.com:8080', $origin);
        $this->assertStringStartsWith('https://', $origin);
        $this->assertStringEndsWith(':8080', $origin);
    }

    /** @test */
    public function csp_connect_directive_works_without_path()
    {
        $opensidUrl = 'https://opensid.example.com';

        Aplikasi::updateOrCreate(
            ['key' => 'opensid_url'],
            ['value' => $opensidUrl, 'jenis' => 'text', 'kategori' => 'integrasi']
        );

        $origin = getOrigin($opensidUrl);

        $this->assertEquals('https://opensid.example.com', $origin);
    }

    /** @test */
    public function csp_policy_returns_origin_only_not_full_url()
    {
        $testCases = [
            'https://opensid.example.com' => 'https://opensid.example.com',
            'https://opensid.example.com/' => 'https://opensid.example.com',
            'https://opensid.example.com/api' => 'https://opensid.example.com',
            'https://opensid.example.com:8080/api/v1' => 'https://opensid.example.com:8080',
            'http://localhost:3000' => 'http://localhost:3000',
        ];

        foreach ($testCases as $url => $expectedOrigin) {
            $result = getOrigin($url);
            $this->assertEquals($expectedOrigin, $result, "Failed for URL: {$url}");
        }
    }
}