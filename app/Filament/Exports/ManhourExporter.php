<?php

namespace App\Filament\Exports;

use App\Models\Manhour;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Filament\Tables\Columns\TextColumn;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
class ManhourExporter extends Exporter
{
    protected static ?string $model = Manhour::class;

    public static function query()
    {
        // Eager load relationships for the export query
        return Manhour::with(['proyek', 'manpower_idl', 'manpower_dl']);
    }

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('proyek.nama_proyek')
                ->label('Nama Proyek'),
            ExportColumn::make('manpower_idl.nama')
                ->label('Manpower IDL'),
            ExportColumn::make('manpower_dl.nama')
                ->label('Manpower DL'),
            ExportColumn::make('jam_absen')
                ->label('Jam Absen'),
            ExportColumn::make('pic')
                ->label('PIC'),
            ExportColumn::make('tanggal')
                ->label('Tanggal'),
            ExportColumn::make('manpower_idl.devisi')
                ->label('Devisi'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your manhour export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
