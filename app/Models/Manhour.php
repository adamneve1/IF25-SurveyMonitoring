<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manhour extends Model
{
    use HasFactory;
    protected $table = 'manhours';

    protected $fillable = [
        'proyek_id',
        'manpower_idl_id',
        'manpower_dl_id',
        'jam_absen',
        'pic',
        'tanggal',
        'overtime',
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
