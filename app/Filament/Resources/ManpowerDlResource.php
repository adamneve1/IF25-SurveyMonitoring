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
use Illuminate\Support\Str;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\ImportAction;
use App\Filament\Imports\ManpowerdlImporter;

                       

class ManpowerDlResource extends Resource
{
    protected static ?string $model = Manpower_dl::class;

    protected static ?string $navigationLabel = 'Manpower DL';
    protected static ?string $navigationIcon = 'heroicon-s-identification';
    protected static ?string $label = 'Manpower DL';
    protected static ?string $navigationGroup = 'Kelola';
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
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->placeholder('Nama Manpower DL')
                    ->label('Nama Manpower DL'),
                Forms\Components\Select::make('proyek_id')
                    ->relationship('proyek', 'nama_proyek')
                    ->required()
                    ->placeholder('Pilih Proyek')
                    ->native(false)
                    ->label('Proyek'),
                Forms\Components\Select::make('manpower_idl_id')
                    ->relationship('manpower_idl', 'nama')
                    ->required()
                    ->placeholder('Pilih Manpower IDL')
                    ->native(false)
                    ->label('Manpower IDL'),
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
                    ->placeholder('Devisi')
                    ->native(false)
                    ->label('Devisi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Manpower DL')
                    ->sortable()
                    ->disabled(fn () => self::isExcludedUser()),
                    
                    
                Tables\Columns\TextColumn::make('proyek.nama_proyek')
                    ->label('Proyek')
                    ->sortable(),
                // Tables\Columns\TextColumn::make('devisi')
                //     ->label('Devisi')
                //     ->sortable(),
                Tables\Columns\TextColumn::make('manpower_idl.nama')
    ->label('Manpower IDL')
    ->sortable(),
                    ])
                ->filters([
                    SelectFilter::make('proyek_id')
                        ->label('Filter By Proyek')
                        ->relationship('proyek', 'nama_proyek')
                        ->preload()
                        ->indicator('Proyek'),
                    SelectFilter::make('devisi')
                        ->label('Filter By Devisi')
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
                        ->indicator('Devisi'),
                ])
                    ->actions([
                        Tables\Actions\EditAction::make()
                            ->visible(fn ($record) => self::isExcludedUser()),
                        Tables\Actions\DeleteAction::make()
                            ->visible(fn ($record) => self::emailDomainCheck() && !self::isExcludedUser()),
                    ])
                    ->headerActions([
                    
                        ImportAction::make() // Konfigurasi ImportAction
                            ->importer(ManpowerdlImporter::class)
                            ->label('Import Data'),
                      // Tables\Actions\CreateAction::make(),---
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
            'index' => Pages\ListManpowerDls::route('/'),
            'create' => Pages\CreateManpowerDl::route('/create'),
            'edit' => Pages\EditManpowerDl::route('/{record}/edit'),
        ];
    }
}