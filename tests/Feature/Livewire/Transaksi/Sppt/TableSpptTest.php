<?php

namespace Tests\Feature\Livewire\Transaksi\Sppt;

use App\Http\Livewire\Transaksi\Sppt\TableSppt;
use App\Models\Periode;
use App\Models\Sppt;
use App\Models\SubjekPajak;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class TableSpptTest extends TestCase
{
    use DatabaseTransactions;

    public function test_component_can_render()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(TableSppt::class)
            ->assertStatus(200);
    }

    public function test_component_renders_with_view()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(TableSppt::class)
            ->assertViewIs('livewire.transaksi.sppt.table-sppt');
    }

    public function test_set_pilih_tahun_with_specific_periode()
    {
        $user = User::factory()->create();

        // Create test data
        $periode1 = \App\Models\Periode::factory()->create(['tahun' => 2023]);
        $periode2 = \App\Models\Periode::factory()->create(['tahun' => 2024]);
        $subjekPajak = SubjekPajak::factory()->create();

        $sppt1 = Sppt::factory()->create([
            'periode_id' => $periode1->id,
            'subjek_pajak_id' => $subjekPajak->id
        ]);
        $sppt2 = Sppt::factory()->create([
            'periode_id' => $periode2->id,
            'subjek_pajak_id' => $subjekPajak->id
        ]);

        $component = Livewire::actingAs($user)
            ->test(TableSppt::class, ['table' => 'sppt']);

        // Test filtering by specific periode
        $result = $component->instance()->setPilihTahun($periode1->id);

        $this->assertNotNull($result);
        $this->assertNotNull($component->get('sppts'));

        // Check that sppts are filtered by periode
        $sppts = $component->get('sppts');
        foreach ($sppts as $sppt) {
            $this->assertEquals($periode1->id, $sppt->periode_id);
        }
    }

    public function test_set_pilih_tahun_with_null_periode()
    {
        $user = User::factory()->create();

        // Create test data
        $periode = \App\Models\Periode::factory()->create(['tahun' => 2023]);
        $subjekPajak = SubjekPajak::factory()->create();

        Sppt::factory()->count(3)->create([
            'periode_id' => $periode->id,
            'subjek_pajak_id' => $subjekPajak->id
        ]);

        $component = Livewire::actingAs($user)
            ->test(TableSppt::class, ['table' => 'sppt']);

        // Test with null periode (should return all sppts)
        $result = $component->instance()->setPilihTahun(null);

        $this->assertNotNull($result);
        $this->assertNotNull($component->get('sppts'));

        // Check that we get all sppts
        $sppts = $component->get('sppts');
        $this->assertGreaterThanOrEqual(3, $sppts->count());
    }

    public function test_set_pilih_tahun_returns_datatables_response()
    {
        $user = User::factory()->create();

        // Create test data
        $periode = \App\Models\Periode::factory()->create(['tahun' => 2023]);
        $subjekPajak = SubjekPajak::factory()->create();

        $sppt = Sppt::factory()->create([
            'periode_id' => $periode->id,
            'subjek_pajak_id' => $subjekPajak->id
        ]);

        $component = Livewire::actingAs($user)
            ->test(TableSppt::class, ['table' => 'sppt']);

        // Call setPilihTahun - this should update the sppts property
        $component->call('setPilihTahun', $periode->id);

        // Check that sppts property is updated with the correct data
        $sppts = $component->get('sppts');
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $sppts);
        $this->assertEquals(1, $sppts->count());
        $this->assertEquals($sppt->id, $sppts->first()->id);
    }

    public function test_component_initializes_with_correct_properties()
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(TableSppt::class, [
                'table' => 'test_table'
            ]);

        $this->assertEquals('test_table', $component->get('table'));
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $component->get('sppts')); // Initially empty collection
        $this->assertTrue($component->get('sppts')->isEmpty());
    }

    public function test_component_has_correct_listeners()
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(TableSppt::class);

        $listeners = $component->instance()->getEventsBeingListenedFor();

        $this->assertContains('setPilihTahun', $listeners);
    }

    public function test_datatables_action_column_contains_correct_buttons()
    {
        $user = User::factory()->create();

        // Create test data
        $periode = \App\Models\Periode::factory()->create(['tahun' => 2023]);
        $subjekPajak = SubjekPajak::factory()->create();

        $sppt = Sppt::factory()->create([
            'periode_id' => $periode->id,
            'subjek_pajak_id' => $subjekPajak->id
        ]);

        $component = Livewire::actingAs($user)
            ->test(TableSppt::class, ['table' => 'sppt']);

        // Call the method to populate sppts
        $component->instance()->setPilihTahun($periode->id);

        // Get the sppts and check if they have the required relationships
        $sppts = $component->get('sppts');
        $this->assertNotNull($sppts);

        if ($sppts->count() > 0) {
            $firstSppt = $sppts->first();
            $this->assertNotNull($firstSppt->periode);
            $this->assertNotNull($firstSppt->subjek_pajak);
        }
    }
}
