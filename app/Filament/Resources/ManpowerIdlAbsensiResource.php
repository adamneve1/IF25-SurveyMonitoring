<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManpowerIdlAbsensiResource\Pages;
use App\Models\ManpowerIdlAbsensi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get; // <-- TAMBAHKAN IMPORT INI
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class ManpowerIdlAbsensiResource extends Resource
{
    protected static ?string $model = ManpowerIdlAbsensi::class;
    protected static ?string $navigationLabel = 'Absensi IDL'; //sidebar
    protected static ?string $label = 'Absensi Supervisor'; 
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
     

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('proyek_id')
                    ->relationship('proyek', 'nama_proyek')
                    ->searchable()
                    ->preload()
                    ->live() // ->live() penting agar field lain bisa bereaksi
                    ->required()
                    ->label('Proyek'),

                // --- PERBAIKAN: Dropdown ini sekarang reaktif ---
                Forms\Components\Select::make('manpower_idl_id')
                    ->label('Nama Supervisor (IDL)')
                    ->options(function (Get $get) {
                        $proyekId = $get('proyek_id');
                        if (!$proyekId) {
                            return []; // Kosongkan jika proyek belum dipilih
                        }
                        return \App\Models\Manpower_idl::where('proyek_id', $proyekId)->pluck('nama', 'id');
                    })
                    ->searchable()
                    ->required(),

                Forms\Components\DatePicker::make('tanggal')
                    ->label('Tanggal Absensi')
                    ->default(now())
                    ->required(),

                Forms\Components\Toggle::make('hadir')
                    ->label('Hadir')
                    ->default(true)
                    ->live(), // ->live() agar remark bisa bereaksi

                // --- PERBAIKAN: Remark sekarang muncul jika tidak hadir ---
                Forms\Components\Textarea::make('remark')
                    ->label('Keterangan (jika tidak hadir)')
                    ->visible(fn (Get $get) => !$get('hadir')) // Hanya muncul jika 'hadir' = false
                    ->requiredIf('hadir', false), // Wajib diisi jika tidak hadir
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('proyek.nama_proyek')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('manpower_idl.nama')->label('Supervisor')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('tanggal')->date('d M Y')->sortable(),
                Tables\Columns\IconColumn::make('hadir')
                    ->boolean() // Tampilkan sebagai ikon centang/silang
                    ->label('Kehadiran'),
                Tables\Columns\TextColumn::make('remark')->wrap()->limit(50),
            ])
            ->filters([
                SelectFilter::make('proyek')
                    ->relationship('proyek', 'nama_proyek')
                    ->searchable()->preload(),
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
            ->actions([
                // --- PERBAIKAN: Tambahkan aksi Edit dan Delete ---
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('tanggal', 'desc')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListManpowerIdlAbsensis::route('/'),
            'create' => Pages\CreateManpowerIdlAbsensi::route('/create'),
            'edit' => Pages\EditManpowerIdlAbsensi::route('/{record}/edit'), // <-- Tambahkan halaman edit
        ];
    }

    /**
     * --- PERBAIKAN: Menambahkan Eager Loading untuk Performa ---
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['proyek', 'manpower_idl']);
    }
}
