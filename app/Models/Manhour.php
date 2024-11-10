<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manhour extends Model
{
    use HasFactory;

    // Tentukan nama tabel yang digunakan model ini
    protected $table = 'manhours';

    // Tentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'proyek_id',
        'tanggal',
        'jumlah_tenaga_langsung',
        'jumlah_tenaga_tidak_langsung',
        'total_jam',
    ];

    // Relasi banyak manhours terkait dengan satu proyek
    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'proyek_id');
    }
}
