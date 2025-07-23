<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ManpowerDlFactory;

class Manpower_dl extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'manpower_dls';

    protected $fillable = [
        'proyek_id',
        'nama',
        'manpower_idl_id',
        'divisi_id',
    ];

    protected static function newFactory()
    {
        return ManpowerDlFactory::new();
    }

    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }

    public function manhours()
    {
        return $this->belongsToMany(Manhour::class);
    }

    public function manpower_idl()
    {
        return $this->belongsTo(Manpower_idl::class, 'manpower_idl_id');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }
}
