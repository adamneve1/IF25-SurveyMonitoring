<?php

namespace App\Filament\Imports;

use App\Models\Manpower_dl;
use App\Models\Proyek;
use App\Models\Manpower_idl;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ManpowerdlImporter extends Importer
{
    protected static ?string $model = Manpower_dl::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')
                ->label('Nama Manpower DL')
                ->rules(['required', 'string', 'max:255']),
            ImportColumn::make('proyek')
                 ->label('Proyek')
                ->rules(['required', 'exists:proyeks,nama_proyek'])
                 ->relationship(resolveUsing: function (string $state): ?Proyek {
                    return Proyek::query()->where('nama_proyek', $state)->first();
                  }),
             ImportColumn::make('devisi')
                 ->label('Devisi')
                 ->rules(['required','in:pgmt,hvac,qa.qc,piping,scaffolder,structure,architectural,civil']),
             ImportColumn::make('manpower_idl')
               ->label('Manpower IDL')
                ->rules(['required', 'exists:manpower_idls,nama'])
               ->relationship(resolveUsing: function (string $state): ?Manpower_idl {
                    return Manpower_idl::query()->where('nama', $state)->first();
                }),
        ];
    }

    public function resolveRecord(): ?Manpower_dl
    {
        return new Manpower_dl();
    }
     protected function beforeValidate(): void
    {
    
        if (isset($this->data['proyek'])) {
            $proyek = Proyek::query()->where('nama_proyek', $this->data['proyek'])->first();
            $this->data['proyek_id'] = $proyek?->id;
        }
         if (isset($this->data['manpower_idl'])) {
             $manpowerIdl = Manpower_idl::query()->where('nama', $this->data['manpower_idl'])->first();
             $this->data['manpower_idl_id'] = $manpowerIdl?->id;
         }
        unset($this->data['proyek'], $this->data['manpower_idl']);
       
    }


    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your manpower dl import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}