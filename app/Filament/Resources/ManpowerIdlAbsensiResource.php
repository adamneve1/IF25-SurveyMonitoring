<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManpowerIdlAbsensiResource\Pages;
use App\Filament\Resources\ManpowerIdlAbsensiResource\RelationManagers;
use App\Models\ManpowerIdlAbsensi;
use App\Models\Proyek;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManpowerIdlAbsensiResource extends Resource
{
    protected static ?string $model = ManpowerIdlAbsensi::class;
    protected static ?string $navigationLabel = 'Absensi IDL';    
    protected static ?string $label = 'Absensi IDL';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('proyek_id')
                    ->relationship('proyek', 'nama_proyek')
                    ->native(false)
                    ->required()
                    ->label('Proyek'),

                Forms\Components\Select::make('manpower_idl_id')
                    ->label('Manpower IDL')
                    ->options(\App\Models\Manpower_idl::all()->pluck('nama', 'id'))
                    ->required(),

                Forms\Components\DatePicker::make('tanggal')
                    ->default(now()) 
                    ->hidden(),

                Forms\Components\Toggle::make('hadir')
                    ->label('Hadir')
                    ->default(true),

                Forms\Components\TextInput::make('remark')
                    ->label('Keterangan')
                    ->nullable()
                    ->hidden(),
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

                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('hadir')
                    ->label('Kehadiran')
                    ->formatStateUsing(fn ($state) => $state ? 'Hadir' : 'Tidak Hadir')
                    ->sortable(),

                Tables\Columns\TextColumn::make('remark')
                    ->label('Keterangan')
                    ->wrap(),
            ])
            ->filters([
                // 🔍 Filter berdasarkan proyek
                SelectFilter::make('proyek_id')
                    ->label('Filter Proyek')
                    ->relationship('proyek', 'nama_proyek')
                    ->searchable()
                    ->preload(),

                // 📅 Filter berdasarkan rentang tanggal
                Filter::make('tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('to')->label('Sampai Tanggal'),
                    ])
                    ->query(fn (Builder $query, array $data) => 
                        $query
                            ->when($data['from'], fn ($q) => $q->where('tanggal', '>=', $data['from']))
                            ->when($data['to'], fn ($q) => $q->where('tanggal', '<=', $data['to']))
                    ),

                
            ])
            ->actions([])
            ->defaultSort('tanggal', 'desc')
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
            'index' => Pages\ListManpowerIdlAbsensis::route('/'),
            'create' => Pages\CreateManpowerIdlAbsensi::route('/create'),
        ];
    }
}
