<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProyekResource\Pages;
use App\Models\Proyek;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Tables\Actions\Action;


class ProyekResource extends Resource
{
    protected static ?string $model = Proyek::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationLabel = 'Proyek';
    protected static ?string $navigationGroup = 'Kelola Proyek';
    protected static ?int $navigationSort = 1; 
    

    // Batasi akses Create
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
                Forms\Components\TextInput::make('nama_proyek')
                    ->required()
                    ->placeholder('Nama Proyek'),
                Forms\Components\TextInput::make('alamat_proyek')->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'berjalan' => 'Berjalan',
                        'batal' => 'Batal',
                        'belum_mulai' => 'Belum Mulai',
                        'selesai' => 'Selesai'
                    ])
                    ->placeholder('Status Proyek')
                    ->native(false)
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_mulai')
                    ->required()
                    ->placeholder('Tanggal Mulai Proyek'),
                Forms\Components\DatePicker::make('estimasi_selesai')
                    ->required()
                    ->placeholder('Estimasi Selesai Proyek'),
                    Forms\Components\Hidden::make('jumlah_manpower')
                    ->default(0),
                
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_proyek')->sortable(),
                Tables\Columns\TextColumn::make('tanggal_mulai')->sortable()->date(),
                Tables\Columns\TextColumn::make('estimasi_selesai')->sortable()->date(),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'berjalan' => 'Berjalan',
                        'batal' => 'Batal',
                        'belum_mulai' => 'Belum Mulai',
                        'selesai' => 'Selesai'
                    ])
                    ->selectablePlaceholder(false)
                    ->sortable()
                    ->disabled(fn () => self::isExcludedUser()),
            ])
            ->filters([
                // Tambahkan filter jika perlu
            ])
            ->actions([
                Action::make('Lihat Plan Manpower')
                    ->label('Lihat Plan Manpower')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => route('filament.admin.resources.proyek-plans.index', [
                        'record' => $record->id,
                        'tableFilters' => [
                            'proyek_id' => ['value' => $record->id]
                        ]
                    ]))
                    ->openUrlInNewTab(),
            
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->visible(fn ($record) => self::emailDomainCheck() && !self::isExcludedUser()),
            
                    Tables\Actions\DeleteAction::make()
                        ->visible(fn ($record) => self::emailDomainCheck() && !self::isExcludedUser()),
                ])->icon('heroicon-o-ellipsis-vertical'), // Dropdown untuk Edit & Delete
            ])
                
        ;
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
            'index' => Pages\ListProyeks::route('/'),
            'create' => Pages\CreateProyek::route('/create'),
            'edit' => Pages\EditProyek::route('/{record}/edit'),
        ];
    }
}
