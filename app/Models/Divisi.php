<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Divisi extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $table = 'divisi';

    protected $fillable = [
      'name'
    ];

    public function manpower_idl():HasMany
    {
        return $this->hasMany(Manpower_idl::class, 'divisi_id');
    }
    public function manpower_dl(): HasMany
    {
        return $this->hasMany(Manpower_dl::class, 'divisi_id');
    }
}
