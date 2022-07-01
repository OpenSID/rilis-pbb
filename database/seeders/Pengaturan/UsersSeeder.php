<?php

namespace Database\Seeders\Pengaturan;

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
            ],
        ])->each(function ($user) {
            DB::table('users')->insert($user);
        });
    }
}
