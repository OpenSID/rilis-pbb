<?php

namespace Database\Factories;

use App\Models\Rayon;
use Illuminate\Database\Eloquent\Factories\Factory;

class RayonFactory extends Factory
{
    protected $model = Rayon::class;

    public function definition()
    {
        return [
            'nama_rayon' => $this->faker->words(2, true),
            'foto_rayon' => $this->faker->imageUrl(640, 480, 'city'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
