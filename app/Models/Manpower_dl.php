<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manpower_dl extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'manpower_dls';

    protected $fillable = [
        'proyek_id',
        'nama',
        'devisi',
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
