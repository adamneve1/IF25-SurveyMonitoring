<?php

namespace App\Filament\Resources\ManpowerIdlResource\Pages;

use App\Filament\Resources\ManpowerIdlResource;
use App\Models\Divisi;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListManpowerIdls extends ListRecords
{
    protected static string $resource = ManpowerIdlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    
    public function getTabs(): array
    {
        $tabs = [
            'semua' => Tab::make('Semua')
                ->modifyQueryUsing(fn (Builder $query) => $query),
        ];
    
        $divisiList = Divisi::pluck('name');
        foreach ($divisiList as $divisi)
        {
            $tabs[$divisi] = Tab::make(strtoupper($divisi))
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('divisi', fn ($q) => $q->where('name', $divisi)));
        }

        return $tabs;
    }
}