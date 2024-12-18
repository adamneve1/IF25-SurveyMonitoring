<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProyekResource\Pages;
use App\Models\Proyek;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProyekResource extends Resource
{
    protected static ?string $model = Proyek::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationLabel = 'Proyek';
    protected static ?string $navigationGroup = 'Kelola';

    // Batasi akses Create
    public static function canCreate(): bool
    {
        return self::emailDomainCheck() && !self::isExcludedUser();
    }

    // Batasi akses Edit
    public static function canEdit($record): bool
    {
        return self::emailDomainCheck() && !self::isExcludedUser();
    }

    // Batasi akses Delete
    public static function canDelete($record): bool
    {
        return self::emailDomainCheck() && !self::isExcludedUser();
    }

    
    protected static function emailDomainCheck(): bool
    {
        $userEmail = auth()->user()?->email;

        return Str::endsWith($userEmail, '@lks.com');
    }

  
    protected static function isExcludedUser(): bool
    {
        $userEmail = auth()->user()?->email;

        return $userEmail === 'pras@lks.com';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_proyek')->required(),
                Forms\Components\TextInput::make('alamat_proyek')->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'berjalan' => 'Berjalan',
                        'batal' => 'Batal',
                        'belum_mulai' => 'Belum Mulai',
                        'selesai' => 'Selesai'
                    ])
                    ->native(false)
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
                Tables\Columns\TextColumn::make('tanggal_mulai')->sortable()->date(),
                Tables\Columns\TextColumn::make('estimasi_selesai')->sortable()->date(),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'berjalan' => 'Berjalan',
                        'batal' => 'Batal',
                        'belum_mulai' => 'Belum Mulai',
                        'selesai' => 'Selesai'
                    ])
                    ->selectablePlaceholder(false)
                    ->sortable()
                    ->disabled(fn () => self::isExcludedUser()),
            ])
            ->filters([
                // Tambahkan filter jika perlu
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => self::isExcludedUser()),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => self::emailDomainCheck() && !self::isExcludedUser()),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn () => self::emailDomainCheck() && !self::isExcludedUser()),
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
