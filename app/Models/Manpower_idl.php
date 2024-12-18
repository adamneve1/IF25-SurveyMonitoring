<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manpower_idl extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'manpower_idls';

    protected $fillable = [
        'nama',
        'proyek_id'
    ];

    public function manhours()
    {
        return $this->hasMany(Manhour::class, 'manhour_idl_id');
    }
    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }
}
