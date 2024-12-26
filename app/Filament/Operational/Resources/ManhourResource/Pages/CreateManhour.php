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
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

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
                    ->required()
                    ->default(now()->toDateString()),

                TextInput::make('pic')
                    ->required()
                    ->label('PIC (Person in Charge)'),

                    TextInput::make('remarks')
                ->required()
                ->label('Remarks'),


                 Repeater::make('manhourn')
                    ->label('Manpower DL')
                    ->live() // Tambahkan live() di sini
                    ->schema([
                        Select::make('manpower_dl_id')
                            ->label('Manpower DL')
                            ->searchable()
                            ->reactive()
                             ->live() // Tambahkan live() di sini
                            ->options(function (Get $get, $livewire) {
                                    $proyekId = $get('../../proyek_id');
                                   $selectedIds = collect($get('manhourn') ?? [])
                                    ->pluck('manpower_dl_id')
                                        ->filter()
                                    ->toArray();
                                    return Manpower_dl::query()
                                        ->where('proyek_id', $proyekId)
                                        ->whereNotNull('nama')
                                        ->whereNotIn('id', $selectedIds)
                                        ->pluck('nama', 'id')
                                        ;
                            })
                            ->required()
                            ->placeholder('Pilih Manpower DL'),

                           TextInput::make('overtime')
                            ->numeric()
                            ->required()
                                   ->label('Overtime Hours'),
                    ])
                    ->minItems(1)
                    ->columnSpanFull()
                    ->addActionLabel('Tambah Manpower DL')
                     ->afterStateUpdated(function ($state, $get, $set) {
                        // Cek apakah ada duplikasi pada manpower_dl_id
                       if($state){
                        $manpowerIds = array_column($state, 'manpower_dl_id');
                         if (count($manpowerIds) !== count(array_unique($manpowerIds))) {
                           throw ValidationException::withMessages(['manhourn' => 'Manpower DL tidak boleh duplikat.']);
                         }
                       }
                   }),

            ]);
    }

     public function save()
    {
        $get = $this->form->getState();
        $insert = [];
        foreach($get['manhourn'] as $row) {
             $insert[] = [
                'proyek_id' => $get['proyek_id'],
                'manpower_idl_id' => $get['manpower_idl_id'],
                'manpower_dl_id' => $row['manpower_dl_id'],
                'tanggal' => $get['tanggal'],
                'jam_absen' => $get['jam_absen'],
                'overtime' => $row['overtime'],
                'pic' => $get['pic'],
                'remark' => $get['remarks'],
             ];
        }

       Manhour::insert($insert);

        return redirect()->to('/operational/manhours');
    }
}