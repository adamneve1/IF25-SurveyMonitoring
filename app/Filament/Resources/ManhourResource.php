<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManhourResource\Pages;
use App\Models\Manhour;
use App\Models\Manpower_dl;
use App\Models\Manpower_idl;
use App\Models\Proyek; // Import model Proyek
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ExportBulkAction;
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
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Exports\ManhourExporter;

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
                    ->options(Proyek::all()->pluck('nama_proyek','id'))
                    ->label('Proyek')
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
                    ->label('Manpower IDL')
                    ->reactive()
                    ->placeholder('Manpower IDL')
                    ->searchable()
                   ->options(fn(Get $get) => Manpower_idl::query()
                        ->where('proyek_id', $get('proyek_id'))
                        ->pluck('nama', 'id'))
                    ->default(function(){
                    $user = auth()->user();
                        if ($user) {
                            $manpowerIdl = Manpower_idl::where('nama', $user->name)->first();
                                return $manpowerIdl ? $manpowerIdl->id : null;
                        }
                         return null;
                    }),
                Forms\Components\DatePicker::make('tanggal')
                    ->required()
                    ->default(Carbon::now())
                    ->disabled()
                    ->format('Y-m-d'),
                Forms\Components\TextInput::make('overtime')
                    ->numeric()
                    ->required()
                    ->placeholder('Jam Overtime')
                    ->label('Overtime Hours'),
                Forms\Components\TextInput::make('pic')
                    ->required()
                    ->placeholder('Person In Charge')
                    ->label('PIC (Person in Charge)'),
                Forms\Components\Textarea::make('remark')
                    ->label('Remark')
                    ->placeholder('Remark'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('proyek.nama_proyek')
                    ->label('Proyek')
                    ->sortable(),
                Tables\Columns\TextColumn::make('manpower_idl.nama')
                    ->label('Manpower IDL')
                    ->sortable(),
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
                Tables\Columns\TextColumn::make('manpower_idl.devisi')
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
                    ->headerActions([
                        ExportAction::make()->exporter(ManhourExporter::class)
                            ->label('Export Data'),
                    ])
                    ->bulkActions([
                        Tables\Actions\BulkActionGroup::make([
                            Tables\Actions\DeleteBulkAction::make()
                                ->visible(fn () => self::emailDomainCheck() && !self::isExcludedUser())
                                ->requiresConfirmation(),
                            ExportBulkAction::make()
                                ->exporter(ManhourExporter::class)
                                ->label('Export Data yang Dipilih')
                                ->columnMapping(false),
                            
                        ])
                            ->label('Action'),
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