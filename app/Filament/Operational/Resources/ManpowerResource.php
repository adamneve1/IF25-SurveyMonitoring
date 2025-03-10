<?php

namespace App\Filament\Operational\Resources;

use App\Filament\Operational\Resources\ManpowerResource\Pages;
use App\Models\Manpower;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use Filament\Tables\Actions\CreateAction;

class ManpowerResource extends Resource
{
    protected static ?string $model = Manpower::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Absensi';
    protected static ?string $label = 'Absensi';


     public static function canCreate(): bool
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
                    ->required()
                    ->label('Proyek'),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->label('Manpower'),
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
                TextColumn::make('proyek.nama_proyek')
                    ->label('Nama Proyek')
                    ->sortable(),
                TextColumn::make('manpower_dl.nama')
                    ->label('Manpower DL')
                    ->sortable()
                    ->searchable(),
                 TextColumn::make('manpower_idl.nama')
                    ->label('Manpower IDL')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('hadir')
                     ->label('Hadir')
                    ->sortable()
                     ->formatStateUsing(fn (string $state): string => $state === '1' ? 'Hadir' : 'Tidak Hadir'),
                TextColumn::make('manpower_idl.devisi')
                    ->label('Devisi')
                    ->sortable(),
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->sortable(),
                  TextColumn::make('remark')
                     ->label('Remarks')
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
             ->actions([])
              ->headerActions([
                   CreateAction::make()
                        ->visible(fn () => self::emailDomainCheck() && !self::isExcludedUser()),
              ])
            ->bulkActions([]);
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
        // ✅ Ubah halaman index langsung ke create
        'index' => Pages\CreateManpower::route('/'),
            'create' => Pages\CreateManpower::route('/create'),
    ];
}
}
