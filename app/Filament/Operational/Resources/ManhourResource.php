<?php

namespace App\Filament\Operational\Resources;

use App\Filament\Operational\Resources\ManhourResource\Pages;
use App\Filament\Operational\Resources\ManhourResource\RelationManagers;
use App\Models\Manhour;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Tables\Columns\TextColumn::make('devisi')->label('Divisi')->sortable(),
                    
            ])
            ->filters([
                // Add any filters you need here
            ])
            ->actions([]) // Tidak ada aksi edit
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
            
        ];
    }
}
