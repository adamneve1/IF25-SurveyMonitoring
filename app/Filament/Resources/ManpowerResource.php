<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManpowerResource\Pages;
use App\Models\Manpower;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\DateFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ManpowerResource extends Resource
{
    protected static ?string $model = Manpower::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Manpower';
    protected static ?string $label = 'Manpower';


    public static function canCreate(): bool
    {
        return self::emailDomainCheck() && !self::isExcludedUser();
    }

    public static function canEdit($record): bool
    {
        return self::emailDomainCheck() && !self::isExcludedUser();
    }

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
                     ->label('Absensi') // Mengubah label menjadi 'Absensi'
                    ->sortable()
                      ->formatStateUsing(fn (string $state): string => $state === '1' ? 'Hadir' : 'Tidak Hadir'),
                TextColumn::make('manpower_idl.devisi')
                    ->label('Devisi')
                    ->sortable(),
                    TextColumn::make('remark')
                    ->label('Remarks')
                    ->sortable(),
                    TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date()
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
             
            // Filter berdasarkan Tanggal
            Filter::make('tanggal')
            ->label('Filter By Tanggal')
            ->form([
                DatePicker::make('start_date')
                    ->label('Start Date')
                    ->required(),

                DatePicker::make('end_date')
                    ->label('End Date')
                    ->required(),
            ])
            ->query(function (Builder $query, array $data) {
                // Pastikan kedua tanggal tersedia
                if (isset($data['start_date']) && isset($data['end_date'])) {
                    return $query->whereBetween('tanggal', [$data['start_date'], $data['end_date']]);
                }

                return $query;
            }),
        
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
            ])
            ->defaultSort('tanggal', 'desc'); 
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
            'index' => Pages\ListManpowers::route('/'),
            'create' => Pages\CreateManpower::route('/create'),
            'edit' => Pages\EditManpower::route('/{record}/edit'),
        ];
    }
}