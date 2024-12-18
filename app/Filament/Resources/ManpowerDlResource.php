<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManpowerDlResource\Pages;
use App\Filament\Resources\ManpowerDlResource\RelationManagers;
use App\Models\Manpower_dl;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManpowerDlResource extends Resource
{
    protected static ?string $model = Manpower_dl::class;

    protected static ?string $navigationLabel = 'Manpower DL';
    protected static ?string $navigationIcon = 'heroicon-s-identification';
    protected static ?string $label = 'Manpower DL';
    protected static ?string $navigationGroup = 'Kelola';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->label('Nama Manpower DL'),
                Forms\Components\Select::make('proyek_id')
                    ->relationship('proyek', 'nama_proyek')
                    ->native(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')->label('Manpower DL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('proyek.nama_proyek')->label('Proyek')
                    ->sortable(),
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
            'index' => Pages\ListManpowerDls::route('/'),
            'create' => Pages\CreateManpowerDl::route('/create'),
            'edit' => Pages\EditManpowerDl::route('/{record}/edit'),
        ];
    }
}
