<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manpower extends Model
{
    use HasFactory;

    // Tentukan nama tabel yang digunakan model ini
    protected $table = 'manpowers';
   

    // Tentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'proyek_id',
        'manpower_idl_id',
        'manpower_dl_id',
        'pic',
        'tanggal',
        'remark',
    ];
    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }
    public function manpower_dl()
    {
        return $this->belongsTo(Manpower_dl::class,'manpower_dl_id');  
    }
    public function manpower_idl()
    {
        return $this->belongsTo(Manpower_idl::class, 'manpower_idl_id');
    }
}
