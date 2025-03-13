<?php

namespace App\Filament\Resources\ManpowerDlResource\Pages;

use App\Filament\Resources\ManpowerDlResource;
use App\Models\Divisi;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use App\Models\Manpower_dl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View; // Import View

class ListManpowerDls extends ListRecords
{
    protected static string $resource = ManpowerDlResource::class;

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
}}
