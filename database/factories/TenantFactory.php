<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->word,
            'name' => $this->faker->company,
            'id_start_range' => $this->faker->numberBetween(1, 100000),
            'id_end_range' => $this->faker->numberBetween(100001, 200000),
        ];
    }
}
