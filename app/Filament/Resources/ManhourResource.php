<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManhourResource\Pages;
use App\Models\Manhour;
use App\Models\Manpower_dl;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Support\Str;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class ManhourResource extends Resource
{
    protected static ?string $model = Manhour::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationLabel = 'Manhour';

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
                Forms\Components\Repeater::make('manpower_dls')
                    ->label('Manpower DL')
                    ->schema([
                        Forms\Components\Select::make('manpower_dl_id')
                            ->required()
                            ->native(false)
                            ->label('Manpower DL')
                            ->searchable()
                            ->options(fn (Get $get) => Manpower_dl::query()
                                ->where('proyek_id', $get('proyek_id'))
                                ->pluck('nama', 'id')),
                    ])
                   ->columnSpanFull()
                    ->addActionLabel('Tambah Manpower DL'),
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
                 TextColumn::make('proyek.nama_proyek')
                    ->label('Proyek')
                    ->sortable(),
                TextColumn::make('manpower_dls')
                    ->label('Manpower DL')
                    ->getStateUsing(fn (Manhour $record): string => $record->manpower_dls()->pluck('nama')->implode(', ')),
                TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                TextColumn::make('overtime')
                    ->label('Overtime Hours'),
                TextColumn::make('pic')
                    ->label('PIC')
                    ->sortable(),
                SelectColumn::make('devisi')
                    ->label('Devisi')
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
                    ->selectablePlaceholder(false)
                    ->sortable()
                    ->disabled(fn() => self::isExcludedUser()),
            ])
            ->filters([
                Filter::make('today')
                    ->label('Today')
                    ->query(fn(Builder $query): Builder => $query->whereDate('tanggal', today())),
                Filter::make('this_week')
                    ->label('This Week')
                    ->query(fn(Builder $query): Builder => $query->whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()])),
                Filter::make('this_month')
                    ->label('This Month')
                    ->query(fn(Builder $query): Builder => $query->whereMonth('tanggal', now()->month)),
                Filter::make('this_year')
                    ->label('This Year')
                    ->query(fn(Builder $query): Builder => $query->whereYear('tanggal', now()->year)),
                Filter::make('custom_date')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('to'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal', '>=', $date),
                            )
                            ->when(
                                $data['to'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn($record) => self::isExcludedUser()),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn($record) => self::emailDomainCheck() && !self::isExcludedUser()),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn() => self::emailDomainCheck() && !self::isExcludedUser()),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
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