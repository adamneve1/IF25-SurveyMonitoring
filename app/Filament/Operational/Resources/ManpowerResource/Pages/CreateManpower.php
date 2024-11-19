<?php

namespace App\Filament\Operational\Resources\ManpowerResource\Pages;

use App\Filament\Operational\Resources\ManpowerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateManpower extends CreateRecord
{
    protected static string $resource = ManpowerResource::class;

    // Metode ini mengatur URL redirect setelah data berhasil disimpan
    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman index
        return $this->getResource()::getUrl('index');
    }
}
