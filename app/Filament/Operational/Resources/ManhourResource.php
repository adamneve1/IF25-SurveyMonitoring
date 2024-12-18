<?php

namespace App\Filament\Operational\Resources;

use App\Filament\Operational\Resources\ManhourResource\Pages;
use App\Models\Manhour;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Support\Str;


class ManhourResource extends Resource
{
    protected static ?string $model = Manhour::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationLabel = 'Manhour';

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
                Forms\Components\Select::make('proyek_id')
                    ->relationship('proyek', 'nama_proyek')
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('manpower_idl_id')
                    ->relationship('manpower_idl', 'nama')
                    ->required()
                    ->native(false)
                    ->label('Manpower IDL'),
                Forms\Components\Select::make('manpower_dl_id')
                    ->relationship('manpower_dl', 'nama')
                    ->required()
                    ->native(false)
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
                TextColumn::make('proyek.nama_proyek')->label('Proyek')->sortable(),
                TextColumn::make('manpower_idl.nama')->label('Manpower IDL')->sortable(),
                TextColumn::make('manpower_dl.nama')->label('Manpower DL')->sortable(),
                TextColumn::make('tanggal')->date()->sortable(),
                TextColumn::make('overtime')->label('Overtime Hours'),
                TextColumn::make('pic')->label('PIC')->sortable(),
                TextColumn::make('devisi')->label('Divisi')->sortable(),
            ])
            ->filters([
                // Add any filters you need here
            ])
            ->actions([]) // No actions (Edit action removed)
            ->bulkActions([]); // No bulk actions (Delete action removed)
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
            // Remove 'edit' page so records can't be edited
        ];
    }
}
