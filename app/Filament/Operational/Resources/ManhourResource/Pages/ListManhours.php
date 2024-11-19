<?php

namespace App\Filament\Operational\Resources\ManhourResource\Pages;

use App\Filament\Operational\Resources\ManhourResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManhours extends ListRecords
{
    protected static string $resource = ManhourResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
