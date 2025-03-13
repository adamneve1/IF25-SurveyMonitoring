<?php

namespace App\Filament\Resources\ProyekPlanResource\Pages;

use App\Filament\Resources\ProyekPlanResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use App\Models\ProyekPlan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreateProyekPlan extends CreateRecord
{
    protected static string $resource = ProyekPlanResource::class;

    protected function handleRecordCreation(array $data): ProyekPlan
    {
        DB::beginTransaction(); // Mulai transaksi untuk menghindari duplikasi

        try {
            Log::info('Menerima input data', $data);

            // Konversi tipe data
            $data['proyek_id'] = (int) $data['proyek_id'];
            $data['bulan'] = (int) $data['bulan'];
            $data['tahun'] = (int) $data['tahun'];
            $data['jumlah_plan'] = (int) $data['jumlah_plan'];
            
            

            Log::info('Setelah konversi tipe data', $data);

            // Cari data yang sudah ada
            $existing = ProyekPlan::lockForUpdate() // Mencegah race condition
                ->where('proyek_id', $data['proyek_id'])
                ->where('bulan', $data['bulan'])
                ->where('tahun', $data['tahun'])
                ->first();

            if ($existing) {
                Log::info('Data ditemukan sebelum update', [
                    'ID' => $existing->id,
                    'jumlah_plan_lama' => $existing->jumlah_plan,
                    'jumlah_plan_baru' => $data['jumlah_plan'],
                  
                ]);

                // Update jumlah_plan dengan benar
                $existing->update([
                    'jumlah_plan' => $data['jumlah_plan'],
                ]);

                Log::info('Jumlah_plan setelah update', ['jumlah_plan' => $existing->jumlah_plan]);

                DB::commit(); // Simpan perubahan

                // Notifikasi sukses
                Notification::make()
                    ->title('Data diperbarui!')
                    ->body('Jumlah manpower telah ditambahkan ke data yang sudah ada.')
                    ->success()
                    ->send();

                return $existing;
            }

            // Validasi tahun (misalnya antara 2000 dan 2100)
// ✅ Validasi tahun (harus dalam rentang masuk akal)
if ($data['tahun'] < 2000 || $data['tahun'] > 2100) {
    Log::warning('Input tahun tidak valid', ['tahun' => $data['tahun']]);

    // Tampilkan notifikasi warning
    Notification::make()
        ->title('Input Tidak Valid')
        ->body('Tahun Tidak Valid')
        ->warning()
        ->send();

    throw ValidationException::withMessages([
        'tahun' => 'Tahun harus antara 2000 dan 2100.'
    ]);
}

            Log::info('Data tidak ditemukan, membuat data baru', $data);

            $newRecord = ProyekPlan::create($data);
            DB::commit(); // Simpan data baru

            return $newRecord;
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan jika ada error
            Log::error('Gagal menyimpan data', ['error' => $e->getMessage()]);
            throw $e; // Lempar error biar terlihat di debug
        }
    }
}
