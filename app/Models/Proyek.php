<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;

    protected $table = 'proyeks';

    protected $fillable = [
        'nama_proyek',
        'alamat_proyek',
        'jumlah_manpower',
        'status',
        'tanggal_mulai',
        'estimasi_selesai',
    ];

    public function manhours()
    {
        return $this->hasMany(Manhour::class, 'proyek_id');
    }
    public function manpowerdl()
    {
        return $this->hasMany(Manpower_dl::class, 'proyek_id');
    }
    public function manpoweridl()
    {
        return $this->hasMany(Manpower_idl::class, 'proyek_id');
    }
}
