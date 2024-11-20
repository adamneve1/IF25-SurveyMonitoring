<?php

namespace App\Filament\Resources\ManpowerDlResource\Pages;

use App\Filament\Resources\ManpowerDlResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManpowerDl extends EditRecord
{
    protected static string $resource = ManpowerDlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
       
        return $this->getResource()::getUrl('index');
    }
}
