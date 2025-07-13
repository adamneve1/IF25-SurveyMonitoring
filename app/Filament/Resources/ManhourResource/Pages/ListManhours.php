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

    /**
     * Membuat tab dinamis yang lebih aman dan informatif.
     */
    public function getTabs(): array
    {
        $tabs = ['all' => Tab::make('Semua')];

        // 1. Ambil semua data Divisi
        $semuaDivisi = Divisi::all();

        foreach ($semuaDivisi as $divisi) {
            // 2. Hitung jumlah manhour untuk divisi ini
            $count = $this->getResource()::getEloquentQuery()
                ->whereHas('manpower_idl.divisi', function ($query) use ($divisi) {
                    $query->where('id', $divisi->id); // Lebih aman menggunakan ID
                })
                ->count();
            
            // 3. Hanya tampilkan tab jika ada isinya (jumlah > 0)
            if ($count > 0) {
                $tabs[$divisi->name] = Tab::make(strtoupper($divisi->name))
                    ->modifyQueryUsing(function (Builder $query) use ($divisi) {
                        return $query->whereHas('manpower_idl.divisi', function ($q) use ($divisi) {
                            $q->where('id', $divisi->id);
                        });
                    })
                    ->badge($count); // Gunakan jumlah yang sudah kita hitung
            }
        }

        return $tabs;
    }
}