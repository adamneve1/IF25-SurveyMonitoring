<?php

namespace App\Filament\Operational\Resources\ManhourResource\Pages;

use App\Filament\Operational\Resources\ManhourResource;
use App\Models\Manhour;
use App\Models\Manpower_dl;
use App\Models\Manpower_idl;
use App\Models\Proyek;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateManhour extends CreateRecord
{
    protected static string $resource = ManhourResource::class;

    protected static string $view = 'filament.pages.form-manhour';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('proyek_id')
                ->label('Proyek')
                ->options(Proyek::query()
                    ->whereNotNull('nama_proyek')
                    ->pluck('nama_proyek', 'id'))
                ->native(false)
                ->reactive()
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
                    ->options(fn(Get $get) => Manpower_idl::query()
                        ->where('proyek_id', $get('proyek_id'))
                        ->whereNotNull('nama')
                        ->pluck('nama', 'id')),
                

                DatePicker::make('tanggal')
                    ->required(),

                TextInput::make('overtime')
                    ->numeric()
                    ->required()
                    ->label('Overtime Hours'),

                TextInput::make('pic')
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

                    Repeater::make('manhour')
                    ->label('Manpower DL')
                    ->schema([
                        Select::make('manpower_dl_id')
                            ->label('Manpower DL')
                            ->searchable()
                            ->reactive()
                            ->options(fn(Get $get) => 
                                Manpower_dl::query()
                                    ->where('proyek_id', $get('../../proyek_id')) // Perhatikan hierarki
                                    ->pluck('nama', 'id')
                            )
                            ->required()
                            ->placeholder('Pilih Manpower DL'),
                    ])
                    ->minItems(1)
                    ->columnSpanFull()
                    ->addActionLabel('Tambah Manpower DL'),
                
                

                
                
            ]);
    }

    public function save()
    {
        $get = $this->form->getState();

        $manhourData = [
            'proyek_id' => $get['proyek_id'],
            'manpower_idl_id' => $get['manpower_idl_id'],
            'tanggal' => $get['tanggal'],
            'jam_absen' => $get['jam_absen'],
            'overtime' => $get['overtime'],
            'pic' => $get['pic'],
            'devisi' => $get['devisi'],
        ];

        // Insert main Manhour record
        $manhour = Manhour::create($manhourData);

        // Insert related Manpower DL records from Repeater
        if (!empty($get['manpower_dl'])) {
            foreach ($get['manpower_dl'] as $dl) {
                DB::table('manpower_dl_manhour')->insert([
                    'manhour_id' => $manhour->id,
                    'manpower_dl_id' => $dl['manpower_dl_id'],
                ]);
            }
        }

        return redirect()->to('/admin/manhours');
    }
}