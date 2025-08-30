<?php

namespace Tests\Unit\Services;

use App\Models\Aplikasi;
use App\Services\PbbConfigService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class PbbConfigServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Clear cache before each test
        $this->app['cache']->flush();
    }

    /** @test */
    public function it_can_get_key_from_database()
    {
        $kodeDesa = Aplikasi::where('key', 'layanan_kode_desa')->first();
        if (!$kodeDesa) {
            Aplikasi::factory()->create([
                'key' => 'layanan_kode_desa',
                'value' => 'TEST_KODE_123',
                'keterangan' => 'Test kode desa',
                'jenis' => 'text',
                'kategori' => 'credential_layanan'
            ]);
        }
        // Act
        $key = PbbConfigService::getKey();

        // Assert
        $this->assertEquals($kodeDesa->value, $key);
    }
    /** @test */
    public function it_can_get_secret_from_database()
    {
        $tokenLayanan = Aplikasi::where('key', 'layanan_opendesa_token')->first();
        if (!$tokenLayanan) {
            $tokenLayanan = Aplikasi::factory()->create([
                'key' => 'layanan_opendesa_token',
                'value' => 'secret_token_123',
                'keterangan' => 'Test token',
                'jenis' => 'text',
                'kategori' => 'credential_layanan'
            ]);
        }

        // Act
        $secret = PbbConfigService::getSecret();

        // Assert
        $this->assertEquals($tokenLayanan->value, $secret);
    }

    /** @test */
    public function it_uses_cache_for_key()
    {
        // Arrange
        Cache::shouldReceive('rememberForever')
            ->once()
            ->with('pbb_config_key', \Closure::class)
            ->andReturn('CACHED_KEY');

        // Act
        $key = PbbConfigService::getKey();

        // Assert
        $this->assertEquals('CACHED_KEY', $key);
    }

    /** @test */
    public function it_uses_cache_for_secret()
    {
        // Arrange
        Cache::shouldReceive('rememberForever')
            ->once()
            ->with('pbb_config_secret', \Closure::class)
            ->andReturn('CACHED_SECRET');

        // Act
        $secret = PbbConfigService::getSecret();

        // Assert
        $this->assertEquals('CACHED_SECRET', $secret);
    }

    /** @test */
    public function it_can_get_all_config()
    {
        // Act
        $config = PbbConfigService::getConfig();

        // Assert
        $this->assertIsArray($config);
        $this->assertArrayHasKey('key', $config);
        $this->assertArrayHasKey('secret', $config);
        $this->assertArrayHasKey('domain', $config);
    }

    /** @test */
    public function it_can_clear_cache()
    {
        // Arrange
        Cache::shouldReceive('forget')->with('pbb_config_key')->once();
        Cache::shouldReceive('forget')->with('pbb_config_secret')->once();

        // Act
        PbbConfigService::clearCache();

        // Assert - expectations are checked automatically
    }
}
