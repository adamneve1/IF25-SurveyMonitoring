<?php

namespace App\Services;

use App\Models\Manpower_dl;

class ManpowerDlService
{
    public function createBulk(array $formState): bool
    {
        $bulkData = array_map(function ($item) use ($formState) {
            return [
                'proyek_id' => $formState['proyek_id'],
                'divisi_id' => $formState['divisi_id'],
                'manpower_idl_id' => $formState['manpower_idl_id'],
                'nama' => $item['nama'],
            ];
        }, $formState['nama_manpower_dls']);

        return Manpower_dl::insert($bulkData);
    }
}