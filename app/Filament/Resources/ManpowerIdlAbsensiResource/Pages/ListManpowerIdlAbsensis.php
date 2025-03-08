<?php

namespace App\Filament\Resources\ManpowerIdlAbsensiResource\Pages;

use App\Filament\Resources\ManpowerIdlAbsensiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManpowerIdlAbsensis extends ListRecords
{
    protected static string $resource = ManpowerIdlAbsensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
