<?php

namespace Database\Factories;

use App\Models\Manhour;
use App\Models\Proyek;
use App\Models\Manpower_dl;
use App\Models\Manpower_idl;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManhourFactory extends Factory
{
    protected $model = Manhour::class;

    public function definition(): array
    {
        return [
            'proyek_id' => Proyek::factory(),
            'manpower_idl_id' => Manpower_idl::factory(),
            'manpower_dl_id' => Manpower_dl::factory(),
            'jam_absen' => 'pagi',
            'pic' => $this->faker->name,
            'tanggal' => now()->format('Y-m-d'),
            'overtime' => 0,
            'remark' => $this->faker->sentence,
         
        ];
    }
}
