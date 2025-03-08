<?php

namespace App\Filament\Resources\ManpowerDlResource\Pages;

use App\Filament\Resources\ManpowerDlResource;
use App\Models\Manpower_dl;
use Filament\Actions;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateManpowerDl extends CreateRecord
{
    protected static string $resource = ManpowerDlResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected static string $view = 'filament.pages.form-manpowerdl';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('proyek_id')
                    ->relationship('proyek', 'nama_proyek')
                    ->required()
                    ->placeholder('Pilih Proyek')
                    ->native(false)
                    ->label('Proyek'),
              Select::make('manpower_idl_id')
                    ->relationship('manpower_idl', 'nama')
                    ->required()
                    ->placeholder('Pilih Manpower IDL')
                    ->native(false)
                    ->label('Manpower IDL'),
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
                    ->placeholder('Pilih Devisi')
                    ->native(false)
                    ->label('Devisi'),
                Repeater::make('nama_manpower_dls')
                    ->label('Nama Manpower DL')
                    ->columnSpanFull() // Memenuhi lebar kolom
                     ->grid(1)  // Mengatur grid menjadi 3 kolom
                     ->itemLabel(fn (array $state): ?string => $state['nama'] ?? null)
                    ->schema([
                        TextInput::make('nama')
                        ->required()
                        ->placeholder('Nama Manpower DL')
                        ->label('Nama Manpower DL')
                         ->afterStateUpdated(function ($state, $set, $get) {
                              $selectedNames = collect($get('../../nama_manpower_dls') ?? [])
                                      ->pluck('nama')
                                      ->filter()
                                      ->toArray();
                                 if (count(array_keys($selectedNames, $state)) > 1) {
                                   throw ValidationException::withMessages(['nama' => 'Nama Manpower DL tidak boleh duplikat.']);
                              }
                         })
                        ->columnSpanFull()
                  ,
                    ])
                    ->addActionLabel('Tambah Manpower DL'),
            ]);
    }

    public function save()
    {
        $get = $this->form->getState();
        $insert = [];
        foreach ($get['nama_manpower_dls'] as $row) {
            $insert[] = [
                'proyek_id' => $get['proyek_id'],
                'devisi' => $get['devisi'],
                'manpower_idl_id' => $get['manpower_idl_id'],
                'nama' => $row['nama'],
            ];
        }
        Manpower_dl::insert($insert);
        return redirect()->to('/admin/manpower-dls');
    }
}
