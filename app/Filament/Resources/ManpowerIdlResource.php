<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManpowerIdlResource\Pages;
use App\Filament\Resources\ManpowerIdlResource\RelationManagers;
use App\Models\Manpower_idl;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManpowerIdlResource extends Resource
{
    protected static ?string $model = Manpower_idl::class;

    protected static ?string $navigationLabel = 'Manpower IDL';
    protected static ?string $navigationIcon = 'heroicon-s-identification';
    protected static ?string $label = 'Manpower IDL';
    protected static ?string $navigationGroup = 'Kelola';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->label('Nama Manpower IDL'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID'),
                Tables\Columns\TextColumn::make('nama')->label('Manpower IDL'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListManpowerIdls::route('/'),
            'create' => Pages\CreateManpowerIdl::route('/create'),
            'edit' => Pages\EditManpowerIdl::route('/{record}/edit'),
        ];
    }
}
