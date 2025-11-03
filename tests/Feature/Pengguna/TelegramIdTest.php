<?php

namespace Tests\Feature\Pengguna;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TelegramIdTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test bahwa user dapat memiliki telegram_id
     */
    public function test_user_can_have_telegram_id()
    {
        $user = User::factory()->create([
            'telegram_id' => '123456789'
        ]);

        $this->assertNotNull($user->telegram_id);
        $this->assertEquals('123456789', $user->telegram_id);
    }

    /**
     * Test bahwa telegram_id bersifat nullable
     */
    public function test_telegram_id_is_nullable()
    {
        $user = User::factory()->create([
            'telegram_id' => null
        ]);

        $this->assertNull($user->telegram_id);
    }

    /**
     * Test update telegram_id pada user
     */
    public function test_user_can_update_telegram_id()
    {
        $user = User::factory()->create([
            'telegram_id' => null
        ]);

        $user->update(['telegram_id' => '987654321']);

        $this->assertEquals('987654321', $user->fresh()->telegram_id);
    }

    /**
     * Test bahwa telegram_id dapat disimpan melalui form pengguna
     */
    public function test_telegram_id_can_be_saved_through_user_form()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        $username = 'testuser' . time();
        $email = 'test' . time() . '@example.com';
        
        // Skip password breach check in test
        config(['app.password_compromised' => false]);
        
        $response = $this->post(route('pengguna.store'), [
            'name' => 'Test User',
            'username' => $username,
            'email' => $email,
            'telegram_id' => '111222333',
            'password' => 'UniqueP@ssw0rd!2025',
        ]);

        // Debug if any errors
        if ($response->status() === 302 && session()->has('errors')) {
            dump(session()->get('errors')->toArray());
        }

        $response->assertRedirect();
        $response->assertSessionHas('store-success');
        
        // Cari user yang baru dibuat berdasarkan username yang unik
        $user = User::where('username', $username)->first();
        $this->assertNotNull($user, 'User should be created');
        $this->assertEquals('111222333', $user->telegram_id);
    }

    /**
     * Test bahwa telegram_id dapat diupdate melalui form edit pengguna
     */
    public function test_telegram_id_can_be_updated_through_edit_form()
    {
        $admin = User::factory()->create();
        $user = User::factory()->create([
            'username' => 'testuser',
            'telegram_id' => '111222333'
        ]);

        $this->actingAs($admin);

        $response = $this->put(route('pengguna.update', encrypt($user->id)), [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
            'telegram_id' => '999888777',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'telegram_id' => '999888777',
        ]);
    }

    /**
     * Test validasi telegram_id harus numeric
     */
    public function test_telegram_id_must_be_numeric()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        $response = $this->post(route('pengguna.store'), [
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'telegram_id' => 'invalid_text',
            'password' => 'TestPassword123!',
        ]);

        $response->assertSessionHasErrors('telegram_id');
    }

    /**
     * Test bahwa telegram_id dapat dikosongkan
     */
    public function test_telegram_id_can_be_empty()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        $username = 'testuser' . time();
        $response = $this->post(route('pengguna.store'), [
            'name' => 'Test User Empty Telegram',
            'username' => $username,
            'email' => 'test' . time() . '@example.com',
            'telegram_id' => '',
            'password' => 'UniqueP@ssw0rd!2025',
        ]);

        $response->assertRedirect();
        
        // Cek user yang baru dibuat berdasarkan username unik
        $user = User::where('username', $username)->first();
        $this->assertNotNull($user, 'User should be created');
        $this->assertNull($user->telegram_id);
    }

    /**
     * Test bahwa user dengan telegram_id ditampilkan di index
     */
    public function test_telegram_id_displayed_in_user_index()
    {
        $user = User::factory()->create([
            'telegram_id' => '123456789'
        ]);

        $admin = User::factory()->create();
        $this->actingAs($admin);

        $response = $this->get(route('pengguna.index'));

        $response->assertStatus(200);
        $response->assertSee($user->telegram_id);
    }
}
