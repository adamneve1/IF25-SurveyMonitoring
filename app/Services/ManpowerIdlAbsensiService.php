<?php

namespace App\Services;

use App\Models\ManpowerIdlAbsensi;
use Carbon\Carbon;
use Exception; // <-- TAMBAHKAN INI

class ManpowerIdlAbsensiService
{
    /**
     * @throws Exception
     */
    public function create(array $formState): void
    {
        // 1. Cek dulu apakah data sudah ada
        $sudahAbsen = ManpowerIdlAbsensi::where('manpower_idl_id', $formState['manpower_idl_id'])
            ->whereDate('tanggal', Carbon::today()) // Asumsi kolom tanggal Anda bernama 'tanggal'
            ->exists();

        // 2. Jika sudah ada, lempar exception untuk menghentikan proses
        if ($sudahAbsen) {
            throw new Exception('Manpower ini sudah tercatat absen hari ini.');
        }

        // 3. Jika aman, baru buat data absensi
        ManpowerIdlAbsensi::create([
            'proyek_id' => $formState['proyek_id'],
            'manpower_idl_id' => $formState['manpower_idl_id'],
            'remark' => $formState['remarks'],
            'tanggal' => Carbon::now()->toDateString(),
            'hadir' => 1,
        ]);
    }
}