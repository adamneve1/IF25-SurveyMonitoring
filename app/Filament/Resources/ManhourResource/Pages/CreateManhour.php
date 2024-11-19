<?php

namespace App\Filament\Resources\ManhourResource\Pages;

use App\Filament\Resources\ManhourResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateManhour extends CreateRecord
{
    protected static string $resource = ManhourResource::class;
    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman index
        return $this->getResource()::getUrl('index');
    }
}
