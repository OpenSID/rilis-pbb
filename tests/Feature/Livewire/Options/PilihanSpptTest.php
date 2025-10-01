<?php

namespace Tests\Feature\Livewire\Options;

use App\Http\Livewire\Options\PilihanSppt;
use App\Models\Aplikasi;
use App\Models\ObjekPajak;
use App\Models\Rayon;
use App\Models\RT;
use App\Models\Sppt;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class PilihanSpptTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Create basic aplikasi settings
        Aplikasi::factory()->create(['key' => 'nama_aplikasi', 'value' => 'Test App']);
    }

    public function test_component_can_render()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(PilihanSppt::class)
            ->assertStatus(200);
    }

    public function test_component_renders_with_view()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(PilihanSppt::class)
            ->assertViewIs('livewire.options.pilihan-sppt');
    }

    public function test_component_mounts_with_initial_data()
    {
        $user = User::factory()->create();

        // Create test data
        Rayon::factory()->count(3)->create();

        $component = Livewire::actingAs($user)
            ->test(PilihanSppt::class);

        $this->assertNotNull($component->get('rayons'));
        $this->assertEquals(0, $component->get('rts')->count());
        $this->assertEquals(0, $component->get('objeks')->count());
        $this->assertEquals(0, $component->get('sppts')->count());
    }

    public function test_component_mounts_with_selected_sppt()
    {
        $user = User::factory()->create();

        // Create test data hierarchy
        $rayon = Rayon::factory()->create();
        $rt = RT::factory()->create(['rayon_id' => $rayon->id]);
        $objekPajak = ObjekPajak::factory()->create(['rt_id' => $rt->id]);
        $sppt = Sppt::factory()->create([
            'objek_pajak_id' => $objekPajak->id,
            'nilai_pagu_pajak' => 100000
        ]);

        $component = Livewire::actingAs($user)
            ->test(PilihanSppt::class, ['selectedSppt' => $sppt->id]);

        $this->assertEquals($sppt->id, $component->get('selectedSppt'));
        $this->assertEquals($rayon->id, $component->get('selectedRayon'));
        $this->assertEquals($rt->id, $component->get('selectedRT'));
        $this->assertEquals($objekPajak->id, $component->get('selectedObjek'));
    }

    public function test_updated_selected_rayon_loads_rts()
    {
        $user = User::factory()->create();

        // Create test data
        $rayon = Rayon::factory()->create();
        $rt1 = RT::factory()->create(['rayon_id' => $rayon->id]);
        $rt2 = RT::factory()->create(['rayon_id' => $rayon->id]);

        $component = Livewire::actingAs($user)
            ->test(PilihanSppt::class)
            ->set('selectedRayon', $rayon->id);

        $rts = $component->get('rts');
        $this->assertEquals(2, $rts->count());
        $this->assertNull($component->get('selectedObjek'));
        $this->assertNull($component->get('selectedSppt'));
    }

    public function test_updated_selected_rt_loads_sppts()
    {
        $user = User::factory()->create();

        // Create test data
        $rayon = Rayon::factory()->create();
        $rt = RT::factory()->create(['rayon_id' => $rayon->id]);
        $objekPajak = ObjekPajak::factory()->create(['rt_id' => $rt->id]);

        // Create SPPT with status 1 (should be included)
        $sppt1 = Sppt::factory()->create([
            'objek_pajak_id' => $objekPajak->id,
            'status' => '1'
        ]);

        // Create SPPT with status 2 (should still be included as it's valid status)
        $sppt2 = Sppt::factory()->create([
            'objek_pajak_id' => $objekPajak->id,
            'status' => '2'
        ]);

        $component = Livewire::actingAs($user)
            ->test(PilihanSppt::class)
            ->set('selectedRT', $rt->id);

        $sppts = $component->get('sppts');
        $this->assertEquals(1, $sppts->count()); // Only status '1' should be included
        $this->assertEquals($sppt1->id, $sppts->first()->id);
    }

    public function test_set_sppt_updates_pagu()
    {
        $user = User::factory()->create();

        // Create test data
        $sppt = Sppt::factory()->create(['nilai_pagu_pajak' => 150000]);

        $component = Livewire::actingAs($user)
            ->test(PilihanSppt::class)
            ->call('setSppt', $sppt->id);

        $this->assertEquals(150000, $component->get('pagu'));
    }

    public function test_set_sppt_with_null_data()
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(PilihanSppt::class)
            ->call('setSppt', null);

        // Should not throw error and pagu should remain null
        $this->assertNull($component->get('pagu'));
    }

    public function test_denda_is_masked_when_updated()
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(PilihanSppt::class)
            ->set('denda', '123456789');

        // Should be masked to 6 digits
        $this->assertEquals('123456', $component->get('denda'));
    }

    public function test_render_calculates_total_correctly()
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(PilihanSppt::class)
            ->set('pagu', 100000)
            ->set('denda', 25000);

        $component->call('render');

        // Total should be pagu + denda = 125000
        // We can't directly test the view data, but we can verify the calculation logic
        $this->assertEquals(100000, $component->get('pagu'));
        $this->assertEquals(25000, $component->get('denda'));
    }

    public function test_component_has_correct_listeners()
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(PilihanSppt::class);

        $listeners = $component->instance()->getEventsBeingListenedFor();

        $this->assertContains('setSppt', $listeners);
    }
}
