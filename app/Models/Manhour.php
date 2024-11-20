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
        'manpower_idl_id',
        'manpower_dl',
        'pic',
        'tanggal',
        'overtime',
        'devisi',
    ];

    // Relasi banyak manhours terkait dengan satu proyek
    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'proyek_id');
    }
    public function manpower_idl()
    {
        return $this->belongsTo(Manpower_idl::class, 'manpower_idl_id');
    }
    public function manpower_dl()
    {
        return $this->belongsTo(Manpower_idl::class, 'manpower_idl_id');
    }
}
