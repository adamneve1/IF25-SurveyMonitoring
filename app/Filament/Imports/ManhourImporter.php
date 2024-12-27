<?php

namespace App\Filament\Imports;

use App\Models\Manhour;
use App\Models\Proyek;
use App\Models\Manpower_idl;
use App\Models\Manpower_dl;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ManhourImporter extends Importer
{
    protected static ?string $model = Manhour::class;

    /**
     * Define the columns from the CSV and their validation rules.
     */
    public static function getColumns(): array
    {
        return [
            ImportColumn::make('proyek')
                ->label('Nama Proyek')
                ->rules(['required', 'exists:proyeks,nama_proyek'])
                ->relationship(resolveUsing: function (string $state): ?Proyek {
                    return Proyek::query()
                        ->where('nama_proyek', $state)
                        ->first();
                }),
            ImportColumn::make('manpower_idl')
                ->label('Manpower IDL')
                ->rules(['required', 'exists:manpower_idls,nama'])
                ->relationship(resolveUsing: function (string $state): ?Manpower_idl {
                    return Manpower_idl::query()
                        ->where('nama', $state)
                        ->first();
                }),
            ImportColumn::make('manpower_dl')
                ->label('Manpower DL')
                ->rules(['required', 'exists:manpower_dls,nama'])
                ->relationship(resolveUsing: function (string $state): ?Manpower_dl {
                    return Manpower_dl::query()
                        ->where('nama', $state)
                        ->first();
                }),
            ImportColumn::make('jam_absen')
                ->label('Jam Absen')
                ->rules(['required', 'in:pagi,siang,malam']),
            ImportColumn::make('pic')
                ->label('PIC')
                ->rules(['required']),
            ImportColumn::make('tanggal')
                ->label('Tanggal')
                ->rules(['required', 'date']),
            ImportColumn::make('overtime')
                ->label('Overtime')
                ->rules(['required', 'numeric']),
            ImportColumn::make('remark')
                ->label('Remark')
                ->rules(['nullable', 'string']),
        ];
    }
    
    /**
     * This function is used to resolve the record to be inserted into the database.
     */
    public function resolveRecord(): ?Manhour
    {
        return new Manhour();
    }

    /**
     * Custom notification message when the import is completed.
     */
    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your manhour import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }

    /**
     * Before validating, we need to resolve the foreign keys and make sure they are correct.
     */
    // protected function beforeValidate(): void
    // {
    //     // Log the incoming data for debugging
    //     // \Log::debug('Imported data: ', $this->data);
    
    //     if (isset($this->data['proyek'])) {
    //         $proyek = Proyek::query()->where('nama_proyek', $this->data['proyek'])->first();
    //         $this->data['proyek_id'] = $proyek?->id;
    //         echo "TEST PROYEK: ".$proyek;
    //     }
    
    //     if (isset($this->data['manpower_idl'])) {
    //         $manpower_idl = Manpower_idl::query()->where('nama', $this->data['manpower_idl'])->first();
    //         $this->data['manpower_idl_id'] = $manpower_idl?->id;
    //         echo "TEST MANPOWER IDL: ".$manpower_idl;
    //     }
    
    //     if (isset($this->data['manpower_dl'])) {
    //         $manpower_dl = Manpower_dl::query()->where('nama', $this->data['manpower_dl'])->first();
    //         $this->data['manpower_dl_id'] = $manpower_dl?->id;
    //         echo "TEST MANPOWER DL: ".$manpower_dl;
    //     }
    
    //     unset($this->data['proyek'], $this->data['manpower_idl'], $this->data['manpower_dl']);
    // }
}
