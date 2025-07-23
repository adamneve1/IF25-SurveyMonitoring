<?php

namespace App\Filament\Resources\ManhourResource\Pages;

use App\Filament\Resources\ManhourResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Divisi;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Components\Tab;

class ListManhours extends ListRecords
{
    protected static string $resource = ManhourResource::class;

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
