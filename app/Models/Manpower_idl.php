<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manpower_idl extends Model
{
    use HasFactory;
    public $timestamps = false;

    // Tentukan nama tabel yang digunakan model ini
    protected $table = 'manpower_idls';

    // Tentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'nama' // Menambahkan jumlah_manpower ke fillable
    ];

    // Relasi satu proyek memiliki banyak manhours
    public function manhours()
    {
        return $this->hasMany(Manhour::class, 'proyek_id');
    }
}
