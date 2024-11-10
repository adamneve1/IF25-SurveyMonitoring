<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManhourResource\Pages;
use App\Filament\Resources\ManhourResource\RelationManagers;
use App\Models\Manhour;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

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
                    ->required(),
                Forms\Components\DatePicker::make('tanggal')->required(),
                Forms\Components\TextInput::make('jumlah_tenaga_langsung')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('jumlah_tenaga_tidak_langsung')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('total_jam')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('proyek.nama_proyek')->label('Proyek'),
                Tables\Columns\TextColumn::make('tanggal')->date(),
                Tables\Columns\TextColumn::make('jumlah_tenaga_langsung'),
                Tables\Columns\TextColumn::make('jumlah_tenaga_tidak_langsung'),
                Tables\Columns\TextColumn::make('total_jam'),
            ])
            ->filters([
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
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
