<?php

namespace App\Filament\Resources\ManhourResource\Pages;

use App\Filament\Resources\ManhourResource;
use Filament\Actions;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Manpower_dl;

class CreateManhour extends CreateRecord
{
    protected static string $resource = ManhourResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getFormSchema(): array
    {
       return [
           Select::make('proyek_id')
                    ->relationship('proyek', 'nama_proyek')
                    ->native(false)
                    ->live()
                    ->required(),
                Select::make('jam_absen')
                    ->native(false)
                    ->options([
                        'pagi' => 'Pagi',
                        'siang' => 'Siang',
                        'malam' => 'Malam',
                    ])
                    ->required()
                    ->label('Jam Absen'),
                Select::make('manpower_idl_id')
                    ->required()
                    ->native(false)
                    ->label('Manpower IDL')
                    ->reactive()
                    ->searchable()
                    ->options(fn(Get $get) => \App\Models\Manpower_idl::query()
                        ->where('proyek_id', $get('proyek_id'))
                        ->pluck('nama', 'id')),
                Repeater::make('manpower_dls')
                    ->label('Manpower DL')
                    ->schema([
                        Select::make('manpower_dl_id')
                            ->required()
                            ->native(false)
                            ->label('Manpower DL')
                             ->searchable()
                            ->options(fn(Get $get) => Manpower_dl::query()
                                ->where('proyek_id', $get('proyek_id'))
                                ->pluck('nama', 'id')),
                    ])
                   ->columnSpanFull()
                    ->addActionLabel('Tambah Manpower DL'),
                \Filament\Forms\Components\DatePicker::make('tanggal')
                    ->required(),
                \Filament\Forms\Components\TextInput::make('overtime')
                    ->numeric()
                    ->required()
                    ->label('Overtime Hours'),
                \Filament\Forms\Components\TextInput::make('pic')
                    ->required()
                    ->label('PIC (Person in Charge)'),
                Select::make('devisi')
                    ->options([
                        'pgmt' => 'PGMT',
                        'hvac' => 'HVAC',
                        'qa.qc' => 'QA/QC',
                        'piping' => 'Piping',
                        'scaffolder' => 'Scaffolder',
                        'structure' => 'Structure',
                        'architectural' => 'Architectural',
                        'civil' => 'Civil',
                    ])
                    ->required()
                    ->native(false)
                    ->label('Devisi'),

        ];
    }
}