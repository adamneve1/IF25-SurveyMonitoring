<?php

namespace App\Filament\Resources\ManhourResource\Pages;


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
                    ->required()
                    ->afterStateUpdated(function ($state, $set) {
                        $set('manpower_idl_id',null);
                       
                    }),

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
                     ->live()
                    ->options(fn(Get $get) => Manpower_idl::query()
                        ->where('proyek_id', $get('proyek_id'))
                        ->whereNotNull('nama')
                        ->pluck('nama', 'id'))
                     ->afterStateUpdated(function ($state, $set) {
                           $set('manpower_dl_id',null);
                       }),

                 

        

                    TextInput::make('remarks')
                ->required()
                ->label('Remarks'),


                 Repeater::make('manhourn')
                    ->label('Manpower DL')
                    ->live()
                    ->schema([
                        Select::make('manpower_dl_id')
                            ->label('Manpower DL')
                            ->searchable()
                            ->reactive()
                             ->live()
                              ->options(function (Get $get) {
                                $proyekId = $get('../../proyek_id');
                                 $manpowerIdlId = $get('../../manpower_idl_id');
                                $selectedIds = collect($get('manhourn') ?? [])
                                        ->pluck('manpower_dl_id')
                                        ->filter()
                                        ->toArray();

                                return Manpower_dl::query()
                                    ->where('proyek_id', $proyekId)
                                     ->whereNotNull('nama')
                                      ->when($manpowerIdlId, function ($query, $manpowerIdlId) {
                                            return $query->whereHas('manpower_idl', function ($query) use ($manpowerIdlId) {
                                                $query->where('manpower_idl_id', $manpowerIdlId);
                                            });
                                        })
                                     ->whereNotIn('id', $selectedIds)
                                    ->pluck('nama', 'id');
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
                    ->addActionLabel('Tambah Manpower DL'),
                     

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
                'tanggal' => Carbon::now()->toDateString(),
                'jam_absen' => $get['jam_absen'],
                'overtime' => $row['overtime'],
                'pic' => auth()->user()->name ?? '', 
                'remark' => $get['remarks'],
             ];
        }

       Manhour::insert($insert);

        return redirect()->to('/operational/manhours');
    }
}