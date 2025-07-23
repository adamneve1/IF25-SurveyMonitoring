<?php

namespace App\Services;

use App\Models\Manpower;
use App\Models\Manpower_dl;
use Carbon\Carbon;

class ManpowerAttendanceService
{
    public function saveAttendance(array $formState): array
    {
        $today = Carbon::today()->toDateString();
        $insert = [];
        $sudahAbsenList = [];
        $list_name = [];

        if (!empty($formState['manpowern'])) {
            foreach ($formState['manpowern'] as $row) {
                $dlId = $row['manpower_dl_id'];

                // Cek apakah DL ini sudah absen hari ini
                $sudahAbsen = Manpower::where('manpower_dl_id', $dlId)
                    ->where('tanggal', $today)
                    ->exists();
                
                if ($sudahAbsen) {
                    // Simpan info DL yang sudah absen
                    $sudahAbsenList[] = $dlId;
                    continue;
                }

                $insert[] = [
                    'proyek_id' => $formState['proyek_id'],
                    'manpower_idl_id' => $formState['manpower_idl_id'],
                    'manpower_dl_id' => $dlId,
                    'tanggal' => $today,
                    'pic' => auth()->user()->name ?? '',
                    'remark' => $formState['remarks'],
                    'hadir' => $row['is_present'] === true ? 1 : 0,
                ];
            }

            if (!empty($insert)) {
                Manpower::insert($insert);
            }
        }
        if ($sudahAbsenList) {

            foreach ($sudahAbsenList as $dlId) {
                $manpower = Manpower_dl::find($dlId); // lebih singkat pakai find()

                if ($manpower) {
                    $list_name[] = $manpower->nama; // pastikan field-nya 'nama', bukan 'name'
                }
            }
        }
        return [
            'success' => count($insert),
            'skipped' => $list_name, // list DL yang udah absen
        ];
    }
}
