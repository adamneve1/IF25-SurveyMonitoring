<?php

namespace App\Filament\Resources\ProyekResource\Pages;

use App\Filament\Resources\ProyekResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Proyek;

class ListProyeks extends ListRecords
{
    protected static string $resource = ProyekResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [
            'belum_mulai' => Tab::make('Belum Mulai')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', 'belum_mulai');
                }),
            'berjalan' => Tab::make('Berjalan')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', 'berjalan');
                }),
            'batal' => Tab::make('Batal')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', 'batal');
                }),
            'selesai' => Tab::make('Selesai')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', 'selesai');
                }),
        ];
    }

}
