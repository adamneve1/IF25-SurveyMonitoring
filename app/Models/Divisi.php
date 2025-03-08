<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $table = 'divisi';

    protected $fillable = [
      'name', 'reference'
    ];

    public function manpower_idl()
    {
        return $this->hasMany(Manpower_idl::class, 'proyek_id');
    }
    public function manpower_dl()
    {
        return $this->hasMany(Manpower_dl::class, 'proyek_id');
    }
}
