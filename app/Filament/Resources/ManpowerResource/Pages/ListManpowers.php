<?php

namespace App\Filament\Resources\ManpowerResource\Pages;

use App\Filament\Resources\ManpowerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Manhour;
use Filament\Resources\Components\Tab;
use App\Models\Divisi;
use Illuminate\Database\Eloquent\Builder;

class ListManpowers extends ListRecords
{
    protected static string $resource = ManpowerResource::class;

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
                ->modifyQueryUsing(fn (Builder $query) => 
                    $query->whereHas('manpower_idl.divisi', fn ($q) => $q->where('name', $divisi))
                );
        }

        return $tabs;
    }
}
