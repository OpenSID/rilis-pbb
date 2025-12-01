<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers;

use App\Http\Controllers\Controller;
use App\Exceptions\TenantIdRangeExceededException;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Database\Eloquent\Model;

class ControllerTest extends BaseTestCase
{
    use \Tests\CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        // Unbind current_tenant before each test
        app()->forgetInstance('current_tenant');
    }

    public function test_tenant_is_null_when_not_bound()
    {
        $controller = new Controller();
        $this->assertNull($controller->getTenant());
    }

    public function test_tenant_is_set_when_bound()
    {
        $tenant = (object) [
            'id' => 1,
            'id_start_range' => 1000,
            'id_end_range' => 1999,
        ];
        app()->instance('current_tenant', $tenant);
        $controller = new Controller();
        $this->assertSame($tenant, $controller->getTenant());
    }

    public function test_get_next_sequence_returns_null_if_no_tenant()
    {
        $controller = new Controller();
        $result = $controller->getNextSequence(MockModel::class);
        $this->assertNull($result);
    }

    public function test_get_next_sequence_returns_next_id()
    {
        $tenant = (object) [
            'id' => 1,
            'id_start_range' => 1000,
            'id_end_range' => 1999,
        ];
        app()->instance('current_tenant', $tenant);
        $controller = new Controller();
        MockModel::$maxId = 1500;
        $result = $controller->getNextSequence(MockModel::class);
        $this->assertEquals(1501, $result);
    }

    public function test_get_next_sequence_returns_first_id_if_none_exists()
    {
        $tenant = (object) [
            'id' => 1,
            'id_start_range' => 1000,
            'id_end_range' => 1999,
        ];
        app()->instance('current_tenant', $tenant);
        $controller = new Controller();
        MockModel::$maxId = null;
        $result = $controller->getNextSequence(MockModel::class);
        $this->assertEquals(1001, $result);
    }

    public function test_get_next_sequence_throws_exception_on_overflow()
    {
        $this->expectException(TenantIdRangeExceededException::class);
        $tenant = (object) [
            'id' => 1,
            'id_start_range' => 1000,
            'id_end_range' => 1999,
        ];
        app()->instance('current_tenant', $tenant);
        $controller = new Controller();
        MockModel::$maxId = 1999;
        $controller->getNextSequence(MockModel::class);
    }
}

class MockModel extends Model
{
    public static $maxId = null;
    public static function max($column)
    {
        return static::$maxId;
    }
    public static function getModel()
    {
        $instance = new static();
        $instance->setTable('mock_table');
        return $instance;
    }
}
