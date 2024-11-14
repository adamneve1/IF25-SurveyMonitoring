<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProyekResource\Pages;
use App\Filament\Resources\ProyekResource\RelationManagers;
use App\Models\Proyek;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProyekResource extends Resource
{
    protected static ?string $model = Proyek::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationLabel = 'Proyek';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_proyek')->required(),
                Forms\Components\TextInput::make('alamat_proyek')->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'Berjalan' => 'Berjalan',
                        'Terhambat' => 'Terhambat',
                        'Berhasil' => 'Berhasil',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_mulai')->required(),
                Forms\Components\DatePicker::make('estimasi_selesai')->required(),
                Forms\Components\TextInput::make('jumlah_manpower')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_proyek')->sortable(),
                Tables\Columns\TextColumn::make('tanggal_mulai')->sortable(),
                Tables\Columns\TextColumn::make('estimasi_selesai')->sortable(),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'berjalan' => 'Berjalan',
                        'batal' => 'Batal',
                        'belum_mulai' => 'Belum Mulai',
                        'selesai' => 'Selesai'
                    ])
                    ->sortable(),
            ])
            ->filters([
                // Tambahkan filter jika perlu
            ])
            ->actions([
              //  Tables\Actions\EditAction::make(), // Membuka halaman edit
              Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListProyeks::route('/'),
            'create' => Pages\CreateProyek::route('/create'),
            'edit' => Pages\EditProyek::route('/{record}/edit'),
        ];
    }
}
