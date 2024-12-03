<?php

namespace App\Filament\Resources\ManpowerDlResource\Pages;

use App\Filament\Resources\ManpowerDlResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateManpowerDl extends CreateRecord
{
    protected static string $resource = ManpowerDlResource::class;
    protected function getRedirectUrl(): string
    {
        // Redirect ke halaman index
        return $this->getResource()::getUrl('index');
    }
}
