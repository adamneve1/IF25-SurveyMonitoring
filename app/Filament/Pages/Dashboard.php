<?php
 
namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Forms\Components\Section;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            Section::make('')->schema([
                TextInput::make('proyek')
                    ->label('Nama Proyek')
                    ->placeholder('Nama Proyek'),
                DatePicker::make('start')
                    ->label('Start'),
                DatePicker::make('end')
                    ->label('End'),
            ])->columns(3)
        ]);
    }
}