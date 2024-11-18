<?php

namespace App\Filament\Resources\ManpowerResource\Pages;

use App\Filament\Resources\ManpowerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Manhour;
use Filament\Resources\Components\Tab;

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
        return [
            'semua' => Tab::make('Semua')
                ->modifyQueryUsing(function ($query) {
                    return $query;
                }),
            'pgmt' => Tab::make('PGMT')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('devisi', 'pgmt');
                }),
            'hvac' => Tab::make('HVAC')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('devisi', 'hvac');
                }),
            'pa.qc' => Tab::make('QA.QC')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('devisi', 'qa.qc');
                }),
            'piping' => Tab::make('Pipping')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('devisi', 'piping');
                }),
            'scaffolder' => Tab::make('Scaffolder')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('devisi', 'scaffolder');
                }),
            'structure' => Tab::make('Structure')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('devisi', 'structure');
                }),
            'architectural' => Tab::make('Architectural')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('devisi', 'architectural');
                }),
            'civil' => Tab::make('Civil')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('devisi', 'civil');
                }),
        ];
    }
}
