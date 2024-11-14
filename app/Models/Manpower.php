<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manpower extends Model
{
    use HasFactory;

    // Tentukan nama tabel yang digunakan model ini
    protected $table = 'Manpowers';

    // Tentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'proyek_id',
        'nama',
        'devisi'
    ];
}
