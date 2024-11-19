<?php

namespace App\Filament\Operational\Resources\ManhourResource\Pages;

use App\Filament\Operational\Resources\ManhourResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManhour extends EditRecord
{
    protected static string $resource = ManhourResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
