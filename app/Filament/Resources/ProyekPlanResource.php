<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProyekPlanResource\Pages;
use App\Models\ProyekPlan;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ActionGroup;

use Filament\Tables\Actions\ViewAction;

class ProyekPlanResource extends Resource
{
    protected static ?string $model = ProyekPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Manhours Plan';

    protected static ?string $navigationGroup = 'Kelola Proyek';
    protected static ?int $navigationSort = 2;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Select::make('proyek_id')
                            ->relationship('proyek', 'nama_proyek')
                            ->required()
                            ->label('Proyek'),

                        Select::make('bulan')
                            ->options([
                                1 => 'Januari',
                                2 => 'Februari',
                                3 => 'Maret',
                                4 => 'April',
                                5 => 'Mei',
                                6 => 'Juni',
                                7 => 'Juli',
                                8 => 'Agustus',
                                9 => 'September',
                                10 => 'Oktober',
                                11 => 'November',
                                12 => 'Desember',
                            ])
                            ->required()
                            ->label('Bulan'),

                        TextInput::make('tahun')
                            ->numeric()
                            ->required()
                            ->label('Tahun'),

                        TextInput::make('jumlah_plan')
                            ->numeric()
                            ->required()
                            ->label('Jumlah Plan Manhours'),
                    ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
{
    return $table
        ->columns([
            TextColumn::make('proyek.nama_proyek')
                ->label('Proyek')
                ->badge()
                ->color('success')
                ->weight('bold'),

            TextColumn::make('bulan')
                ->label('Bulan')
                ->formatStateUsing(fn ($state) => [
                    1 => 'Januari',
                    2 => 'Februari',
                    3 => 'Maret',
                    4 => 'April',
                    5 => 'Mei',
                    6 => 'Juni',
                    7 => 'Juli',
                    8 => 'Agustus',
                    9 => 'September',
                    10 => 'Oktober',
                    11 => 'November',
                    12 => 'Desember',
                ][$state] ?? $state) // Mengubah angka bulan menjadi nama bulan
                ->badge()
                ->color('primary')
                ->weight('bold')
                ->extraAttributes(['class' => 'border border-purple-500 px-3 py-1 rounded-md']),

            TextColumn::make('tahun')
                ->label('Tahun')
                ->badge()
                ->color('green')
                ->extraAttributes(['class' => 'border border-green-500 px-3 py-1 rounded-md']),

            TextColumn::make('jumlah_plan')
                ->label('Plan Manhours')
                ->badge()
                ->color('danger')
                ->extraAttributes(['class' => 'border border-red-500 px-3 py-1 rounded-md']),
        ])
        ->defaultSort('bulan') // Pengurutan berdasarkan bulan
        ->filters([
            SelectFilter::make('proyek_id')
                ->relationship('proyek', 'nama_proyek')
                ->label('Pilih Proyek')
                ->preload()
                ->searchable(),
        ])
        ->actions([
            ViewAction::make(),
            ActionGroup::make([
                EditAction::make(),
                DeleteAction::make(),
            ]),
        ])
        ->striped(); // Biar tabel ada garis-garisnya
}

    

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProyekPlans::route('/'),
            'create' => Pages\CreateProyekPlan::route('/create'),
            'edit' => Pages\EditProyekPlan::route('/{record}/edit'),
        ];
    }
   
}
