<?php

namespace Database\Factories;

use App\Models\ManpowerIdlAbsensi;
use App\Models\Manpower_idl;
use App\Models\Proyek;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManpowerIdlAbsensiFactory extends Factory
{
    protected $model = ManpowerIdlAbsensi::class;

   public function definition(): array
{
    return [
        'proyek_id' => Proyek::factory(),
        'manpower_idl_id' => Manpower_idl::factory(),
        'tanggal' => $this->faker->date(),
        'hadir' => $this->faker->boolean(),
        'remark' => $this->faker->optional()->sentence,
    ];
}
}