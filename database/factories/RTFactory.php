<?php

namespace Database\Factories;

use App\Models\RT;
use App\Models\Rayon;
use Illuminate\Database\Eloquent\Factories\Factory;

class RTFactory extends Factory
{
    protected $model = RT::class;

    public function definition()
    {
        return [
            'rayon_id' => Rayon::factory(),
            'nama_rt' => $this->faker->numerify('RT###'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
