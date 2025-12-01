<?php

namespace Tests\Feature\Controllers\Pengaturan;

use App\Models\Aplikasi;
use App\Models\Tenant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PenggunaControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;
    private $tenant1;
    private $tenant2;
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        // Ensure no tenant is bound by default
        app()->forgetInstance('current_tenant');
        $this->tenant1 = Tenant::factory()->create(['code' => 'tenant1', 'id_start_range' => 401, 'id_end_range' => 500]);
        $this->tenant2 = Tenant::factory()->create(['code' => 'tenant2', 'id_start_range' => 501, 'id_end_range' => 600]);
        Aplikasi::updateOrCreate(['key' => 'akun_pengguna'], ['value' => '1']);
    }   

    /** @test */
    public function it_can_update_a_user_for_the_active_tenant()
    {
        app()->instance('current_tenant', $this->tenant1);        

        $userToUpdate = User::factory()->create();
        $this->actingAs($userToUpdate);

        $updatedName = 'Updated User Name';
        $response = $this->put(route('pengguna.update', encrypt($userToUpdate->id)), [
            'name' => $updatedName,
            'username' => $userToUpdate->username,
            'email' => $userToUpdate->email,               
        ]);        
        $response->assertRedirect(route('pengguna.index'));
        $this->assertDatabaseHas('users', [
            'id' => $userToUpdate->id,
            'name' => $updatedName,
            'tenant_id' => $this->tenant1->id,
        ]);
    }

    /** @test */
    public function it_cannot_update_a_user_from_another_tenant()
    {        
        $tenant1 = $this->tenant1;
        $tenant2 = $this->tenant2;
        DB::table('users')->insert(array_merge(User::factory()->make(['tenant_id' => $tenant2->id])->toArray(), ['id' => $tenant2->id_start_range, 'email_verified_at' => Carbon::now(), 'password' => bcrypt('password')]));
        $userTenant2 = User::withoutGlobalScope('tenant_scope')->find($tenant2->id_start_range);                

        app()->instance('current_tenant', $tenant1);
        $userTenant1 = User::factory()->create(['tenant_id' => $tenant1->id]);
        $this->actingAs($userTenant1);

        $updatedName = 'Updated User Name';
        $response = $this->put(route('pengguna.update', encrypt($userTenant2->id)), [
            'name' => $updatedName,
            'username' => $userTenant2->username,
            'email' => $userTenant2->email            
        ]);

        // Expect a 404 or similar, as the user from tenant1 should not see user from tenant2
        $response->assertNotFound(); // Or 403 Forbidden, depending on exact implementation of HasTenantScope
        $this->assertDatabaseMissing('users', [
            'id' => $userTenant2->id,
            'name' => $updatedName,
        ]);
    }

    /** @test */
    public function it_can_delete_a_user_for_the_active_tenant()
    {
        $tenant1 = $this->tenant1;
        app()->instance('current_tenant', $tenant1);

        $userToDelete = User::factory()->create(['tenant_id' => $tenant1->id]);
        $this->actingAs($userToDelete);

        $response = $this->delete(route('pengguna.destroy', encrypt($userToDelete->id)));

        $response->assertRedirect(route('pengguna.index'));
        $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
    }

    /** @test */
    public function it_cannot_delete_a_user_from_another_tenant()
    {
        $tenant1 = $this->tenant1;
        $tenant2 = $this->tenant2;
        app()->instance('current_tenant', $tenant1);
        $userTenant1 = User::factory()->create(['tenant_id' => $tenant1->id]);

        DB::table('users')->insert(array_merge(User::factory()->make(['tenant_id' => $tenant2->id])->toArray(), ['id' => $tenant2->id_start_range, 'email_verified_at' => Carbon::now(), 'password' => bcrypt('password')]));
        $userToDeleteTenant2 = User::withoutGlobalScope('tenant_scope')->find($tenant2->id_start_range);

        $this->actingAs($userTenant1);

        $response = $this->delete(route('pengguna.destroy', encrypt($userToDeleteTenant2->id)));

        $response->assertNotFound(); // Or 403 Forbidden
        $this->assertDatabaseHas('users', ['id' => $userToDeleteTenant2->id]);
    }
}
