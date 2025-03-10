<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManpowerIdlAbsensi extends Model
{
    use HasFactory;

    protected $table = 'manpower_idl_absensi'; // Nama tabel di database

    protected $fillable = [
        'proyek_id',
        'manpower_idl_id',
        'tanggal',
        'hadir',
        'remark',
    ];

    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }

    public function manpower_idl()
    {
        return $this->belongsTo(Manpower_idl::class, 'manpower_idl_id');
    }
}
