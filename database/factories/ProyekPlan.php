<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyekPlan extends Model
{
    use HasFactory;

    protected $fillable = ['proyek_id', 'bulan', 'tahun', 'jumlah_plan'];

    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }
    public function getNamaBulanAttribute()
{
    $bulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    return $bulan[$this->bulan] ?? 'Unknown';
}

}
