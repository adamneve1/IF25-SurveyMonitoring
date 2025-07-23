<?php

namespace Database\Factories;

use App\Models\ProyekPlan;
use App\Models\Proyek;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProyekPlanFactory extends Factory
{
    protected $model = ProyekPlan::class;

    public function definition(): array
    {
        return [
            'proyek_id' => Proyek::factory(), // otomatis buat proyek baru
            'bulan' => $this->faker->numberBetween(1, 12),
            'tahun' => $this->faker->year(),
            'jumlah_plan' => $this->faker->numberBetween(10, 100),
        ];
    }
}
