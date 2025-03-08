<?php

namespace App\Filament\Resources\ManpowerIdlAbsensiResource\Pages;

use App\Filament\Resources\ManpowerIdlAbsensiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManpowerIdlAbsensi extends EditRecord
{
    protected static string $resource = ManpowerIdlAbsensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
