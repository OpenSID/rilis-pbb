<?php

namespace Tests\Unit\Helpers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    use DatabaseTransactions;
    /** @test */
    public function get_origin_returns_origin_from_url_without_port()
    {
        $url = 'https://opensid.example.com/api/v1/users';
        $result = getOrigin($url);

        $this->assertEquals('https://opensid.example.com', $result);
    }

    /** @test */
    public function get_origin_returns_origin_from_url_with_port()
    {
        $url = 'https://opensid.example.com:8080/api/v1';
        $result = getOrigin($url);

        $this->assertEquals('https://opensid.example.com:8080', $result);
    }

    /** @test */
    public function get_origin_returns_origin_from_url_without_path()
    {
        $url = 'https://opensid.example.com';
        $result = getOrigin($url);

        $this->assertEquals('https://opensid.example.com', $result);
    }

    /** @test */
    public function get_origin_handles_http_protocol()
    {
        $url = 'http://opensid.example.com:3000/api';
        $result = getOrigin($url);

        $this->assertEquals('http://opensid.example.com:3000', $result);
    }

    /** @test */
    public function get_origin_handles_complex_url_with_query_params()
    {
        $url = 'https://opensid.example.com:443/api/v1?token=abc123';
        $result = getOrigin($url);

        $this->assertEquals('https://opensid.example.com:443', $result);
    }
}