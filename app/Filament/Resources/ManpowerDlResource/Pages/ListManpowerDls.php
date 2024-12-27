<?php

namespace App\Filament\Resources\ManpowerDlResource\Pages;

use App\Filament\Resources\ManpowerDlResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use App\Models\Manpower_dl;
use Illuminate\Database\Eloquent\Builder; 
use Illuminate\Contracts\View\View; // Import View

class ListManpowerDls extends ListRecords
{
    protected static string $resource = ManpowerDlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
             'semua' => Tab::make('Semua')
                ->modifyQueryUsing(fn (Builder $query) => $query),
            'pgmt' => Tab::make('PGMT')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('devisi', 'pgmt')),
            'hvac' => Tab::make('HVAC')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('devisi', 'hvac')),
            'qa.qc' => Tab::make('QA/QC')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('devisi', 'qa.qc')),
            'piping' => Tab::make('Piping')
                 ->modifyQueryUsing(fn (Builder $query) => $query->where('devisi', 'piping')),
            'scaffolder' => Tab::make('Scaffolder')
                 ->modifyQueryUsing(fn (Builder $query) => $query->where('devisi', 'scaffolder')),
            'structure' => Tab::make('Structure')
                 ->modifyQueryUsing(fn (Builder $query) => $query->where('devisi', 'structure')),
            'architectural' => Tab::make('Architectural')
                 ->modifyQueryUsing(fn (Builder $query) => $query->where('devisi', 'architectural')),
            'civil' => Tab::make('Civil')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('devisi', 'civil')),
        ];
  //  }

   //     public function getHeader(): ?View
    //  {
    //      $data =  Actions\CreateAction::make();
    //      return view('filament.pages.upload-file', compact('data'));
    //  }
   //   public $file = '';

    ////public function save()
  //{
     // Manpower_dl::create([
       //   'proyek_id' => '1',
   //       'nama' => 'Rendi',
    //      'devisi'=> 'PGMT',
   // //'manpower_idl_id' => '1',
        
  //    ]);
    
}}