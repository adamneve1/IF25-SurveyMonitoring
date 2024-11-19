<?php

namespace App\Filament\Operational\Resources\ManpowerResource\Pages;

use App\Filament\Operational\Resources\ManpowerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManpower extends EditRecord
{
    protected static string $resource = ManpowerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
}
