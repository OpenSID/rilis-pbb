<?php

namespace Database\Factories;

use App\Models\SubjekPajak;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjekPajakFactory extends Factory
{
    protected $model = SubjekPajak::class;

    public function definition()
    {
        return [
            'nik' => $this->faker->unique()->numerify('################'),
            'nama_subjek' => $this->faker->name(),
            'alamat_subjek' => $this->faker->address(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
