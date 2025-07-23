<?php

namespace App\Filament\Resources\ManpowerDlResource\Pages;

use App\Filament\Resources\ManpowerDlResource;
use App\Models\Divisi;
use App\Models\Manpower_dl;
use Filament\Actions;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;
use App\Models\Proyek;
use App\Models\Manpower_idl;
use App\Services\ManpowerDlService;



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
                ->label('Proyek')
                ->options(Proyek::query()
                    ->whereNotNull('nama_proyek')
                    ->pluck('nama_proyek', 'id'))
                ->native(false)
                ->reactive()
                ->required(),
            Select::make('manpower_idl_id')
                ->label('Manpower IDL')
                ->options(fn ($get) => Manpower_idl::query()
                    ->where('proyek_id', $get('proyek_id'))
                    ->whereNotNull('nama')
                    ->pluck('nama', 'id'))
                ->native(false)
                ->searchable()
                ->reactive()
                ->required(),
            // Select::make('devisi')
            //     ->options([
            //         'pgmt' => 'PGMT',
            //         'hvac' => 'HVAC',
            //         'qa.qc' => 'QA/QC',
            //         'piping' => 'Piping',
            //         'scaffolder' => 'Scaffolder',
            //         'structure' => 'Structure',
            //         'architectural' => 'Architectural',
            //         'civil' => 'Civil',
            //     ])
            //     ->required()
            //     ->placeholder('Pilih Devisi')
            //     ->native(false)
            //     ->label('Devisi'),
            Select::make('divisi_id')
                ->label('Divisi')
                ->options(Divisi::query()
                    ->whereNotNull('name')
                    ->pluck('name', 'id'))
                ->native(false)
                ->reactive()
                ->required(),
            Repeater::make('nama_manpower_dls')
                ->label('Nama Manpower DL')
                ->columnSpanFull() // Memenuhi lebar kolom
                ->grid(columns: 1)  // Mengatur grid menjadi 3 kolom
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
                    ->columnSpanFull(),
                    ])
                    ->addActionLabel('Tambah Manpower DL'),
            ]);
    }

 public function save()
{
    $formState = $this->form->getState();

    // Ambil service langsung dari service container Laravel
    $manpowerDlService = app(ManpowerDlService::class);

    $manpowerDlService->createBulk($formState);

    return redirect()->to('/admin/manpower-dls');
}}
