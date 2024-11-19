<?php

namespace App\Filament\Operational\Resources\ManpowerResource\Pages;

use App\Filament\Operational\Resources\ManpowerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManpowers extends ListRecords
{
    protected static string $resource = ManpowerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
