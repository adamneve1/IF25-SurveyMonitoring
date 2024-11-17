<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManhourResource\Pages;
use App\Models\Manhour;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Select;

class ManhourResource extends Resource
{
    protected static ?string $model = Manhour::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationLabel = 'Manhour';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('proyek_id')
                    ->relationship('proyek', 'nama_proyek')
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('manpower_idl_id')
                    ->relationship('manpower_idl', 'nama')
                    ->required()
                    ->native(false)
                    ->label('Manpower IDL'),
                Forms\Components\TextInput::make('manpower_dl')
                    ->required()
                    ->label('Manpower DL'),
                Forms\Components\DatePicker::make('tanggal')
                    ->required(),
                Forms\Components\TextInput::make('overtime')
                    ->numeric()
                    ->required()
                    ->label('Overtime Hours'),
                Forms\Components\TextInput::make('pic')
                    ->required()
                    ->label('PIC (Person in Charge)'),
                Forms\Components\Select::make('devisi')
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('proyek.nama_proyek')->label('Proyek')->sortable(),
                Tables\Columns\TextColumn::make('manpower_idl.nama')->label('Manpower IDL')->sortable(),
                Tables\Columns\TextColumn::make('manpower_dl')->label('Manpower DL'),
                Tables\Columns\TextColumn::make('tanggal')->date()->sortable(),
                Tables\Columns\TextColumn::make('overtime')->label('Overtime Hours'),
                Tables\Columns\TextColumn::make('pic')->label('PIC')->sortable(),
                Tables\Columns\SelectColumn::make('devisi')->label('Devisi')
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
                    ->selectablePlaceholder(false)
                    ->sortable()
            ])
            ->filters([
                // Add any filters you need here
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit Manhour') // Edit action with modal
                    ->modalButton('Update')
                    ->label('Edit'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define relationships here if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListManhours::route('/'),
            'create' => Pages\CreateManhour::route('/create'),
            'edit' => Pages\EditManhour::route('/{record}/edit'),
        ];
    }
}
