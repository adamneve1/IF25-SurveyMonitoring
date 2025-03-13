<?php

namespace App\Filament\Resources\ProyekPlanResource\Pages;

use App\Filament\Resources\ProyekPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;


class EditProyekPlan extends EditRecord
{
    protected static string $resource = ProyekPlanResource::class;
    

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function beforeSave(): void
{
    $tahun = (int) $this->data['tahun'];

    if ($tahun < 2010 || $tahun > 2100) {
        // Log peringatan
        \Log::warning('Input tahun tidak valid', ['tahun' => $tahun]);

        // Tampilkan notifikasi warning
        Notification::make()
            ->title('Input Tidak Valid')
            ->body('Tahun Tidak Valid')
            ->warning()
            ->send();

        // Hentikan proses dengan ValidationException
        throw ValidationException::withMessages([
            'tahun' => 'Tahun harus antara 2000 dan 2100.'
        ]);
    }
}protected function getRedirectUrl(): string
{
    return route('filament.admin.resources.proyek-plans.index'); // Ganti dengan route yang sesuai
}
    
    
}
