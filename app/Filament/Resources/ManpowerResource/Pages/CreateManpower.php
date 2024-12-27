<?php

namespace App\Filament\Resources\ManpowerResource\Pages;

use App\Filament\Resources\ManpowerResource;
use App\Models\Manpower_dl;
use App\Models\Manpower_idl;
use App\Models\Manhour;
use App\Models\Proyek;
use App\Models\Manpower;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CreateManpower extends CreateRecord
{
    protected static string $resource = ManpowerResource::class;
    protected static string $view = 'filament.pages.form-manppour';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

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
                 
                   
                     TextInput::make('remarks')
                        ->required()
                        ->label('Remarks'),
                        Repeater::make('manpowern')
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
    
                         Toggle::make('is_present')
                             ->label('Hadir')
                             ->default(true),
                         
                    ])
                    ->addActionLabel('Tambah Manpower DL')
                    ->minItems(1)
                    ->columnSpanFull(),
            ]);
    }
     public function save()
    {
        $get = $this->form->getState();
         $insert = [];
         foreach ($get['manpowern'] as $row) {
             $insert[] = [
                'proyek_id' => $get['proyek_id'],
                'manpower_idl_id' => $get['manpower_idl_id'],
                'manpower_dl_id' => $row['manpower_dl_id'],
                'tanggal' => Carbon::now()->toDateString(),
                'pic' => auth()->user()->name ?? '',
                'remark' => $get['remarks'],
                'hadir' => $row['is_present'] ? 1 : 0,
            ];
          }
        Manpower::insert($insert);

        return redirect()->to('/operational/manpowers');
    }
}