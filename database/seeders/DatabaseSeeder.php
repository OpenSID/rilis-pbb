<?php

namespace Database\Seeders;

use Database\Seeders\Pengaturan\{UsersSeeder, AplikasiSeeder};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            //Pengaturan
            UsersSeeder::class,
            AplikasiSeeder::class,
        ]);
    }
}
