<?php
// database/factories/ProyekFactory.php

namespace Database\Factories;

use App\Models\Proyek;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProyekFactory extends Factory
{
    protected $model = Proyek::class;

    public function definition(): array
    {
        return [
            'nama_proyek' => $this->faker->company . ' Project',
            'alamat_proyek' => $this->faker->address,
            'status' => $this->faker->randomElement(['berjalan', 'batal', 'belum_mulai', 'selesai']),
            'tanggal_mulai' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'estimasi_selesai' => $this->faker->dateTimeBetween('now', '+1 year'),
            'jumlah_manpower' => 0, // sesuai default
        ];
    }
}

