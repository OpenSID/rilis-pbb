<?php

namespace Database\Factories;

use App\Models\ObjekPajak;
use App\Models\RT;
use App\Models\SubjekPajak;
use Illuminate\Database\Eloquent\Factories\Factory;

class ObjekPajakFactory extends Factory
{
    protected $model = ObjekPajak::class;

    public function definition()
    {
        return [
            'rt_id' => RT::factory(),
            'letak_objek' => $this->faker->words(3, true),
            'kode_blok' => $this->faker->numerify('B##'),
            'alamat_objek' => $this->faker->address(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
