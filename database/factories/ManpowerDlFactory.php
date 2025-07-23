<?php

namespace Database\Factories;

use App\Models\Manpower_dl;

use App\Models\Manpower_idl;
use App\Models\Proyek;
use App\Models\Divisi;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManpowerDlFactory extends Factory
{
    protected $model = Manpower_dl::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name,
            'proyek_id' => \App\Models\Proyek::factory(),
            'manpower_idl_id' => \App\Models\Manpower_idl::factory(),
            'divisi_id' => \App\Models\Divisi::factory(),
        ];
    }
}
