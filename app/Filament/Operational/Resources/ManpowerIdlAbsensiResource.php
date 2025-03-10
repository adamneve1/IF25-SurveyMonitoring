<?php

namespace App\Filament\Operational\Resources;

use App\Filament\Operational\Resources\ManpowerIdlAbsensiResource\Pages;
use App\Models\ManpowerIdlAbsensi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManpowerIdlAbsensiResource extends Resource
{
    protected static ?string $model = ManpowerIdlAbsensi::class;
    protected static ?string $navigationLabel = 'Absensi IDL';    
    protected static ?string $label = 'Absensi IDL';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    // ✅ Sidebar langsung mengarah ke halaman create (HARUS public)
    public static function getNavigationUrl(): string
    {
        return static::getUrl('create');
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

                Forms\Components\Select::make('manpower_idl_id')
                    ->label('Manpower IDL')
                    ->options(\App\Models\Manpower_idl::all()->pluck('nama', 'id'))
                    ->required(),

                Forms\Components\DatePicker::make('tanggal')
                    ->default(now()) // Otomatis mengisi tanggal saat ini
                    ->hidden(), // Menyembunyikan input dari user

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
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListManpowerIdlAbsensis::route('/'), // ✅ Halaman list tetap ada
            'create' => Pages\CreateManpowerIdlAbsensi::route('/create'), // ✅ Halaman create tetap ada
        ];
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('kembali_ke_list')
                ->label('Kembali ke List')
                ->url(ManpowerIdlAbsensiResource::getUrl('index')) // ✅ Kembali ke halaman list
                ->icon('heroicon-o-collection') // ✅ Tambahkan ikon daftar
                ->color('gray'), // ✅ Warna tombol
        ];
    }
}
