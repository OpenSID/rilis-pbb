<?php

namespace Database\Factories;

use App\Models\Periode;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeriodeFactory extends Factory
{
    protected $model = Periode::class;

    public function definition()
    {
        return [
            'tahun' => $this->faker->unique()->numberBetween(2020, 2030),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
