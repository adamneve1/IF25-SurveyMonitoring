<?php

namespace App\Services;

use Carbon\Carbon;

class ManhourService
{
    public static function calculateOvertime(string $checkIn, string $checkOut): int
    {
      
        return Carbon::parse($checkOut)->diffInHours(Carbon::parse($checkIn));
    }

    public static function buildManhourData(array $formState, array $manhournRow): array
    {
        return [
            'proyek_id' => $formState['proyek_id'],
            'manpower_idl_id' => $formState['manpower_idl_id'],
            'manpower_dl_id' => $manhournRow['manpower_dl_id'],
            'tanggal' => now()->toDateString(),
            'jam_absen' => $formState['jam_absen'],
            'overtime' => self::calculateOvertime($manhournRow['check_in'], $manhournRow['check_out']),
            'pic' => auth()->user()->name ?? '',
            'remark' => $formState['remarks'],
        ];
    }
}
