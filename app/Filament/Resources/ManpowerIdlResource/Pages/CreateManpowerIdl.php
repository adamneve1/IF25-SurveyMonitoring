<?php

namespace App\Filament\Resources\ManpowerIdlResource\Pages;

use App\Filament\Resources\ManpowerIdlResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateManpowerIdl extends CreateRecord
{
    protected static string $resource = ManpowerIdlResource::class;
    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman index
        return $this->getResource()::getUrl('index');
    }
}


