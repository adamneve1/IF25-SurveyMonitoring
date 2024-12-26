<?php

namespace App\Filament\Resources\ManpowerIdlResource\Pages;

use App\Filament\Resources\ManpowerIdlResource;
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
        return [
            'semua' => Tab::make('Semua')
                ->modifyQueryUsing(fn (Builder $query) => $query),
            'pgmt' => Tab::make('PGMT')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('devisi', 'pgmt')),
            'hvac' => Tab::make('HVAC')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('devisi', 'hvac')),
             'qa.qc' => Tab::make('QA/QC')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('devisi', 'qa.qc')),
            'piping' => Tab::make('Piping')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('devisi', 'piping')),
            'scaffolder' => Tab::make('Scaffolder')
                 ->modifyQueryUsing(fn (Builder $query) => $query->where('devisi', 'scaffolder')),
             'structure' => Tab::make('Structure')
                 ->modifyQueryUsing(fn (Builder $query) => $query->where('devisi', 'structure')),
            'architectural' => Tab::make('Architectural')
                 ->modifyQueryUsing(fn (Builder $query) => $query->where('devisi', 'architectural')),
            'civil' => Tab::make('Civil')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('devisi', 'civil')),
        ];
    }
}