<?php

namespace Tests\Feature\Pengguna;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class VerifiedFlagTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test bahwa user memiliki kolom verified dengan default false
     */
    public function test_user_has_verified_column_with_default_false()
    {
        $user = User::factory()->create();

        $this->assertNotNull($user->verified);
        $this->assertFalse($user->verified);
    }

    /**
     * Test bahwa verified dapat diset menjadi true
     */
    public function test_verified_can_be_set_to_true()
    {
        $user = User::factory()->create([
            'verified' => false
        ]);

        $user->update(['verified' => true]);

        $this->assertTrue($user->fresh()->verified);
    }

    /**
     * Test method isVerified() pada model User
     */
    public function test_is_verified_method_returns_correct_value()
    {
        $unverifiedUser = User::factory()->create(['verified' => false]);
        $verifiedUser = User::factory()->create(['verified' => true]);

        $this->assertFalse($unverifiedUser->isVerified());
        $this->assertTrue($verifiedUser->isVerified());
    }

    /**
     * Test bahwa verified dicast sebagai boolean
     */
    public function test_verified_is_cast_as_boolean()
    {
        $user = User::factory()->create(['verified' => 1]);

        $this->assertIsBool($user->verified);
        $this->assertTrue($user->verified);
    }
}
