<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Manpower_idl extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'manpower_idls';

    protected $fillable = [
        'nama',
        'proyek_id',
        'devisi',
        'divisi_id'
    ];

    public function manhours()
    {
        return $this->hasMany(Manhour::class, 'manhour_idl_id');
    }
    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }
    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }
}
