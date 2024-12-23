<?php
 
namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Forms\Components\Section;
use App\Models\Proyek;
use Filament\Forms\Components\Select;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            Section::make('')->schema([
                Select::make('proyek_id')
                    ->label('Nama Proyek')
                    ->placeholder('Semua Proyek')
                    ->options(Proyek::pluck('nama_proyek', 'id')->toArray())
                    ->searchable('Nama Proyek'),
                DatePicker::make('start')
                    ->label('Start'),
                DatePicker::make('end')
                    ->label('End'),
            ])->columns(3)
        ]);
    }

    public function getFilteredData()
    { 
        $query = Proyek::query();

        if ($this->filters['proyek_id'] ?? false) {
            $query->where('id', $this->filters['proyek_id']);
        }
    }
}