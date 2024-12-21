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
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;

class ManpowerIdlResource extends Resource
{
    protected static ?string $model = Manpower_idl::class;

    protected static ?string $navigationLabel = 'Manpower IDL';
    protected static ?string $navigationIcon = 'heroicon-s-identification';
    protected static ?string $label = 'Manpower IDL';
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
                    ->label('Nama Manpower IDL'),
                Forms\Components\Select::make('proyek_id')
                    ->relationship('proyek', 'nama_proyek')
                    ->required() // Menandakan bahwa proyek_id wajib diisi
                    ->label('Proyek'),
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
                Tables\Columns\TextColumn::make('nama')->label('Manpower IDL')
                    ->sortable()
                    ->disabled(fn () => self::isExcludedUser()),
                    
            ])
            ->filters([
                //
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
            'index' => Pages\ListManpowerIdls::route('/'),
            'create' => Pages\CreateManpowerIdl::route('/create'),
            'edit' => Pages\EditManpowerIdl::route('/{record}/edit'),
        ];
    }
}