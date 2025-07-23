<?php

namespace Database\Factories;

use App\Models\Manpower_idl;
use App\Models\Proyek;
use App\Models\Divisi;
use Illuminate\Database\Eloquent\Factories\Factory;


class ManpowerIdlFactory extends Factory
{
    protected $model = Manpower_idl::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name,
            'proyek_id' => Proyek::factory(),
            'divisi_id' => Divisi::factory(), // Atau null jika divisi belum dibutuhkan
        ];
    }
}
