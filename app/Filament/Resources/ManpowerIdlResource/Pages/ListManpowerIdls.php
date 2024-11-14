<?php

namespace App\Filament\Resources\ManpowerIdlResource\Pages;

use App\Filament\Resources\ManpowerIdlResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManpowerIdls extends ListRecords
{
    protected static string $resource = ManpowerIdlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
