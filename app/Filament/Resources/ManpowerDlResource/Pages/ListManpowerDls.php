<?php

namespace App\Filament\Resources\ManpowerDlResource\Pages;

use App\Filament\Resources\ManpowerDlResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManpowerDls extends ListRecords
{
    protected static string $resource = ManpowerDlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
