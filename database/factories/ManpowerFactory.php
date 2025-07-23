<?php
namespace Database\Factories;

use App\Models\Manpower;
use App\Models\Proyek;
use App\Models\Manpower_dl;
use App\Models\Manpower_idl;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManpowerFactory extends Factory
{
    protected $model = Manpower::class;

    public function definition()
    {
        return [
            'proyek_id' => Proyek::factory(),
            'manpower_idl_id' => Manpower_idl::factory(),
            'manpower_dl_id' => Manpower_dl::factory(),
            'pic' => $this->faker->name,
            'tanggal' => $this->faker->dateTimeThisYear(),
            'remark' => $this->faker->sentence,
        ];
    }
}