<?php

namespace App\Filament\Resources\ManpowerIdlResource\Pages;

use App\Filament\Resources\ManpowerIdlResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManpowerIdl extends EditRecord
{
    protected static string $resource = ManpowerIdlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
