<?php

namespace App\Filament\Resources\ProyekResource\Pages;

use App\Filament\Resources\ProyekResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProyek extends CreateRecord
{
    protected static string $resource = ProyekResource::class;
    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman index
        return $this->getResource()::getUrl('index');
    }
}

