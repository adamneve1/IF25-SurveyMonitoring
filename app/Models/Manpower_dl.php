<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manpower_dl extends Model
{
    use HasFactory;
    public $timestamps = false;

    // Tentukan nama tabel yang digunakan model ini
    protected $table = 'manpower_dls';

    // Tentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'nama',
        'proyek_id'
    ];

    public function manhours()
    {
        return $this->hasMany(Manhour::class, 'manpower_dl_id');
    }
    public function proyek()
    {
        return $this->belongsTo(Proyek::class, 'proyek_id');
    }
}
