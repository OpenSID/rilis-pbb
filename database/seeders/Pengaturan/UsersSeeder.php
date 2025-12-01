<?php

namespace Database\Seeders\Pengaturan;

use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // kalau posisi install awal, artinya pasti hanya ada 1 tenant
        $tenant = Tenant::first();
        collect([
            [
                'name' => 'Open Desa',
                'username' => 'admin',
                'email' => 'info@opendesa.id',
                'password' => bcrypt('admin'),
                'photo' => '',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'tenant_id' => $tenant->id,
            ],
        ])->each(function ($user) {
            DB::table('users')->insert($user);
        });
    }
}
