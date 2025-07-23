<?php

namespace App\Filament\Resources\ManpowerIdlAbsensiResource\Pages;

use App\Filament\Resources\ManpowerIdlAbsensiResource;
use Filament\Actions;
use App\Models\Divisi;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ManpowerResource;




class ListManpowerIdlAbsensis extends ListRecords
{
    protected static string $resource = ManpowerIdlAbsensiResource::class;

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
