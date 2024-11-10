<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;

    // Tentukan nama tabel yang digunakan model ini
    protected $table = 'proyeks';

    // Tentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'nama_proyek',
        'alamat_proyek',
        'status',
        'tanggal_mulai',
        'estimasi_selesai',
    ];

    // Relasi satu proyek memiliki banyak manhours
    public function manhours()
    {
        return $this->hasMany(Manhour::class, 'proyek_id');
    }
}
