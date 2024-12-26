<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

     public function proyek(): BelongsTo
    {
        return $this->belongsTo(Proyek::class);
    }
    public function manhours(): BelongsToMany
    {
        return $this->belongsToMany(Manhour::class, 'manhour_manpower_dl', 'manpower_dl_id', 'manhour_id');
    }
}