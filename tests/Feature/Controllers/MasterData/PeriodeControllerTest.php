<?php

namespace Tests\Feature\Controllers\MasterData;

use App\Models\Periode;
use App\Models\Sppt;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PeriodeControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_index_page_can_be_accessed()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('periode.index'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.master-data.periode.index');
        $response->assertViewHas(['table', 'periodes']);
    }

    public function test_create_page_can_be_accessed()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('periode.create'));

        $response->assertStatus(200);
        $response->assertViewIs('pages.master-data.periode.create');
        $response->assertViewHas(['table', 'periodes', 'data', 'reset', 'submit']);
    }

    public function test_store_creates_new_periode()
    {
        $user = User::factory()->create();

        $periodeData = [
            'tahun' => '2099', // Use a year that's unlikely to exist
        ];

        $response = $this->actingAs($user)->post(route('periode.store'), $periodeData);

        $response->assertRedirect(route('periode.index'));
        $response->assertSessionHas('store-success', 'Proses tambah data berhasil');

        $this->assertDatabaseHas('periode', $periodeData);
    }

    public function test_store_validates_required_fields()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('periode.store'), []);

        $response->assertSessionHasErrors(['tahun']);
    }

    public function test_store_validates_unique_tahun()
    {
        $user = User::factory()->create();

        // Create existing periode
        $existingPeriode = \App\Models\Periode::factory()->create(['tahun' => 2023]);

        $periodeData = [
            'tahun' => '2023', // Same year as existing periode
        ];

        $response = $this->actingAs($user)->post(route('periode.store'), $periodeData);

        $response->assertSessionHasErrors(['tahun']);
    }

    public function test_store_validates_tahun_format()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('periode.store'), [
            'tahun' => '24' // should be 4 digits
        ]);

        $response->assertSessionHasErrors(['tahun']);
    }

    public function test_edit_page_can_be_accessed()
    {
        $user = User::factory()->create();
        $periode = \App\Models\Periode::factory()->create(['tahun' => 2023]);

        $response = $this->actingAs($user)->get(route('periode.edit', encrypt($periode->id)));

        $response->assertStatus(200);
        $response->assertViewIs('pages.master-data.periode.edit');
        $response->assertViewHas(['table', 'periodes', 'data', 'reset', 'submit']);
    }

    public function test_update_modifies_existing_periode()
    {
        $user = User::factory()->create();
        $periode = \App\Models\Periode::factory()->create(['tahun' => 2023]);

        $updateData = [
            'tahun' => '2099', // Use unique year
        ];

        $response = $this->actingAs($user)->put(route('periode.update', encrypt($periode->id)), $updateData);

        $response->assertRedirect(route('periode.index'));
        $response->assertSessionHas('update-success', 'Proses ubah data berhasil');

        $this->assertDatabaseHas('periode', [
            'id' => $periode->id,
            'tahun' => '2099'
        ]);
    }

    public function test_destroy_deletes_periode_without_sppt()
    {
        $user = User::factory()->create();
        $periode = \App\Models\Periode::factory()->create(['tahun' => 2023]);

        $response = $this->actingAs($user)->delete(route('periode.destroy', encrypt($periode->id)));

        $response->assertRedirect(route('periode.index'));
        $response->assertSessionHas('destroy-success', 'Proses hapus data berhasil.');

        $this->assertDatabaseMissing('periode', ['id' => $periode->id]);
    }

    public function test_destroy_prevents_deletion_when_periode_has_sppt()
    {
        $user = User::factory()->create();
        $periode = \App\Models\Periode::factory()->create(['tahun' => 2023]);

        // Create SPPT associated with periode
        Sppt::factory()->create(['periode_id' => $periode->id]);

        $response = $this->actingAs($user)->delete(route('periode.destroy', encrypt($periode->id)));

        $response->assertRedirect(route('periode.index'));
        $response->assertSessionHas('action-failed');

        // Periode should still exist
        $this->assertDatabaseHas('periode', ['id' => $periode->id]);
    }

    public function test_delete_checked_removes_multiple_periodes()
    {
        $user = User::factory()->create();
        $periode1 = \App\Models\Periode::factory()->create(['tahun' => 2098]);
        $periode2 = \App\Models\Periode::factory()->create(['tahun' => 2097]);

        $response = $this->actingAs($user)->delete(route('periode.deleteSelected'), [
            'ids' => [$periode1->id, $periode2->id]
        ]);

        $response->assertJson(['success' => 'Data telah dihapus']);

        $this->assertDatabaseMissing('periode', ['id' => $periode1->id]);
        $this->assertDatabaseMissing('periode', ['id' => $periode2->id]);
    }

    public function test_delete_checked_prevents_deletion_when_periode_has_sppt()
    {
        $user = User::factory()->create();
        $periode1 = \App\Models\Periode::factory()->create(['tahun' => 2096]);
        $periode2 = \App\Models\Periode::factory()->create(['tahun' => 2095]);

        // Create SPPT for one periode
        Sppt::factory()->create(['periode_id' => $periode1->id]);

        $response = $this->actingAs($user)->delete(route('periode.deleteSelected'), [
            'ids' => [$periode1->id, $periode2->id]
        ]);

        $response->assertStatus(404);
        $response->assertJsonStructure(['failed']);

        // Both periodes should still exist
        $this->assertDatabaseHas('periode', ['id' => $periode1->id]);
        $this->assertDatabaseHas('periode', ['id' => $periode2->id]);
    }

    public function test_unauthenticated_user_cannot_access_periode_pages()
    {
        $periode = \App\Models\Periode::factory()->create(['tahun' => 2023]);

        $this->get(route('periode.index'))->assertRedirect('/login');
        $this->get(route('periode.create'))->assertRedirect('/login');
        $this->post(route('periode.store'))->assertRedirect('/login');
        $this->get(route('periode.edit', encrypt($periode->id)))->assertRedirect('/login');
        $this->put(route('periode.update', encrypt($periode->id)))->assertRedirect('/login');
        $this->delete(route('periode.destroy', encrypt($periode->id)))->assertRedirect('/login');
    }
}
