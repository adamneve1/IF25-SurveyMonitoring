<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManhourResource\Pages;
use App\Filament\Resources\Collection;
use App\Models\Manhour;
use App\Models\Manpower_idl;
use App\Models\Manpower_dl;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Select;
use Illuminate\Support\Str;
use Filament\Forms\Components\DatePicker;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Filament\Tables\Filters\Filter;

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
                    ->live()
                    ->placeholder('Pilih Proyek')
                    ->required(),
                Forms\Components\Select::make('jam_absen')
                    ->native(false)
                    ->options([
                        'pagi' => 'Pagi',
                        'siang' => 'Siang',
                        'malam' => 'Malam',
                    ])
                    ->required()
                    ->placeholder('Jam Absen')
                    ->label('Jam Absen'),
                Forms\Components\Select::make('manpower_idl_id')
                    ->required()
                    ->native(false)
                    ->label('Manpower IDL')
                    ->reactive()
                    ->placeholder('Manpower IDL')
                    ->searchable()
                    ->options(fn(Get $get) => Manpower_idl::query()
                        ->where('proyek_id', $get('proyek_id'))
                        ->pluck('nama', 'id')),
                Forms\Components\Select::make('manpower_dl_id')
                    ->required()
                    ->native(false)
                    ->label('Manpower DL')
                    ->reactive()
                    ->placeholder('Manpower DL')
                    ->searchable()
                    ->options(fn(Get $get) => Manpower_dl::query()
                        ->where('proyek_id', $get('proyek_id'))
                        ->pluck('nama', 'id')),
                Forms\Components\DatePicker::make('tanggal')
                    ->required()
                    ->default(today()),
                Forms\Components\TextInput::make('overtime')
                    ->numeric()
                    ->required()
                    ->placeholder('Jam Overtime')
                    ->label('Overtime Hours'),
                Forms\Components\TextInput::make('pic')
                    ->required()
                    ->placeholder('Person In Charge')
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
                    ->placeholder('Devisi')
                    ->native(false)
                    ->label('Devisi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('proyek.nama_proyek')
                    ->label('Proyek')
                    ->sortable(),
                // Tables\Columns\TextColumn::make('manpower_idl.nama')->label('Manpower IDL')->sortable(),
                Tables\Columns\TextColumn::make('manpower_dl.nama')
                    ->label('Manpower DL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('overtime')
                    ->label('Overtime Hours'),
                Tables\Columns\TextColumn::make('pic')
                    ->label('PIC')
                    ->sortable(),
                Tables\Columns\TextColumn::make('devisi')
                    ->label('Devisi')
                    ->sortable(),
                    ])
                    ->filters([
                        SelectFilter::make('proyek_id')
                            ->label('Filter By Proyek')
                            ->relationship('proyek', 'nama_proyek')
                            ->preload()
                            ->indicator('Proyek'),
                            Filter::make('tanggal')
                        ->form([
                            DatePicker::make('tanggal')
                                ->placeholder('Pilih Tanggal')
                            ])
                            ->query(function ($query, array $data) {
                                if (!empty($data['tanggal'])) {
                                    $query->whereDate('tanggal', $data['tanggal']);
                                }
                            })
                            ->indicateUsing(function (array $data): ?string {
                                if (empty($data['tanggal'])) {
                                    return null;
                                }
                                return 'Tanggal: ' . Carbon::parse($data['tanggal'])->toFormattedDateString();
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
                    ]);
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
            'edit' => Pages\EditManhour::route('/{record}/edit'),
        ];
    }
}
