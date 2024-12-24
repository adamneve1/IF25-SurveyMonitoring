<?php

namespace App\Filament\Resources\ManhourResource\Pages;

use App\Filament\Resources\ManhourResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Manhour;
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
        return [
            'semua' => Tab::make('Semua')
                ->modifyQueryUsing(function ($query) {
                    return $query;
                }),
            'pgmt' => Tab::make('PGMT')
                ->modifyQueryUsing(function ($query) {
                    return $query->whereHas('manpower_idl', function ($subQuery) {
                        $subQuery->where('devisi', 'pgmt');
                    });
                }),
            'hvac' => Tab::make('HVAC')
                ->modifyQueryUsing(function ($query) {
                    return $query->whereHas('manpower_idl', function ($subQuery) {
                        $subQuery->where('devisi', 'hvac');
                    });
                }),
            'qa.qc' => Tab::make('QA.QC')
                ->modifyQueryUsing(function ($query) {
                    return $query->whereHas('manpower_idl', function ($subQuery) {
                        $subQuery->where('devisi', 'qa.qc');
                    });
                }),
            'piping' => Tab::make('Piping')
                ->modifyQueryUsing(function ($query) {
                    return $query->whereHas('manpower_idl', function ($subQuery) {
                        $subQuery->where('devisi', 'piping');
                    });
                }),
            'scaffolder' => Tab::make('Scaffolder')
                ->modifyQueryUsing(function ($query) {
                    return $query->whereHas('manpower_idl', function ($subQuery) {
                        $subQuery->where('devisi', 'scaffolder');
                    });
                }),
            'structure' => Tab::make('Structure')
                ->modifyQueryUsing(function ($query) {
                    return $query->whereHas('manpower_idl', function ($subQuery) {
                        $subQuery->where('devisi', 'structure');
                    });
                }),
            'architectural' => Tab::make('Architectural')
                ->modifyQueryUsing(function ($query) {
                    return $query->whereHas('manpower_idl', function ($subQuery) {
                        $subQuery->where('devisi', 'architectural');
                    });
                }),
            'civil' => Tab::make('Civil')
                ->modifyQueryUsing(function ($query) {
                    return $query->whereHas('manpower_idl', function ($subQuery) {
                        $subQuery->where('devisi', 'civil');
                    });
                }),
        ];
    }
}
