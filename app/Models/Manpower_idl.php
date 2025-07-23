<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Database\Factories\ManpowerIdlFactory;

class Manpower_idl extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'manpower_idls';

    protected $fillable = [
        'nama',
        'proyek_id',
        'divisi_id'
    ];

    public static function newFactory()
    {
      return ManpowerIdlFactory::new();
    }

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
