<?php

namespace Database\Factories;

use App\Models\Sppt;
use App\Models\Periode;
use App\Models\ObjekPajak;
use App\Models\SubjekPajak;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpptFactory extends Factory
{
    protected $model = Sppt::class;

    public function definition()
    {
        return [
            'periode_id' => Periode::factory(),
            'objek_pajak_id' => ObjekPajak::factory(),
            'subjek_pajak_id' => SubjekPajak::factory(),
            'nop' => $this->faker->unique()->numerify('##########'),
            'nilai_pagu_pajak' => $this->faker->numberBetween(100000, 1000000),
            'status' => $this->faker->randomElement(['1', '2']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
