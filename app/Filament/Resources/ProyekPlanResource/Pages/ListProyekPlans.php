<?php

namespace App\Filament\Resources\ProyekPlanResource\Pages;

use App\Filament\Resources\ProyekPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProyekPlans extends ListRecords
{
    protected static string $resource = ProyekPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
