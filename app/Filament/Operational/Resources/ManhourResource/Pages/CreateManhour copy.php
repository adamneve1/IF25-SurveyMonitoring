<?php

namespace App\Filament\Operational\Resources\ManhourResource\Pages;

use App\Filament\Operational\Resources\ManhourResource;
use App\Models\Manpower_dl; // Import Manpower_dl model
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Pages\CreateRecord;

class CreateManhour extends CreateRecord
{
    protected static string $resource = ManhourResource::class;
  
    // Correct method signature
     public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                    
                Repeater::make('manpower_dl')
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
        ]);
    }   protected static string $view = 'filament.pages.form-manhour';
   

public function save()
{
    $get = $this->form->getState();

    $insert = [];
    foreach ($get['manhour'] as $row) {
        array_push($insert, [
            '_id' => $get['classrooms'],
            'student_id' => $row['student'],
            'periode_id' => $get['periode'],
            'teacher_id' => Auth::user()->id,
            'subject_id' => $get['subject_id'],
            'category_nilai_id' => $get['category_nilai'],
            'nilai' => $row['nilai']
        ]);
    }

    Nilai::insert($insert);

    return redirect()->to('admin/nilais');
}
   
}
