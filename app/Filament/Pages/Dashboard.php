<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Forms\Components\Section;
use App\Models\Proyek;
use App\Models\Divisi;
use Filament\Forms\Components\Select;
use App\Filament\Widgets\ManhourChart;
use App\Filament\Widgets\ManpowerChart;
use Carbon\Carbon;
use Filament\Forms\Get;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            Section::make('Filter Data')
                ->schema([
                    Select::make('proyek_id')
                        ->label('Nama Proyek')
                        ->options(Proyek::pluck('nama_proyek', 'id')->toArray())
                        ->searchable()
                        ->default(Proyek::first()?->id)
                        ->live(),

                    Select::make('divisi_id')
                        ->label('Divisi')
                        ->options(Divisi::pluck('name', 'id')->toArray())
                        ->placeholder('Semua Divisi')
                        ->live(),

                    Select::make('view_mode')
                        ->label('Mode Tampilan')
                        ->options([
                            'daily' => 'Harian (per Bulan)',
                            'monthly' => 'Bulanan (per Tahun)',
                            'yearly' => 'Tahunan (Total Proyek)', // <-- OPSI BARU
                        ])
                        ->default('daily')
                        ->live(),

                    Select::make('year')
                        ->label('Tahun')
                        ->options(function (Get $get) {
                            $proyekId = $get('proyek_id');
                            if (!$proyekId) {
                                return [now()->year => now()->year];
                            }

                            $proyek = Proyek::find($proyekId);

                            if (!$proyek || !$proyek->tanggal_mulai || !$proyek->estimasi_selesai) {
                                return collect(range(now()->year - 2, now()->year + 2))->mapWithKeys(fn ($y) => [$y => $y])->toArray();
                            }

                            $startYear = Carbon::parse($proyek->tanggal_mulai)->year;
                            $endYear = Carbon::parse($proyek->estimasi_selesai)->year;

                            if ($startYear > $endYear) {
                                $startYear = $endYear;
                            }

                            return collect(range($startYear, $endYear))->mapWithKeys(fn ($y) => [$y => $y])->toArray();
                        })
                        ->default(now()->year)
                        ->live()
                        // Sembunyikan jika mode 'yearly' dipilih
                        ->visible(fn (Get $get) => $get('view_mode') !== 'yearly'),

                    Select::make('month')
                        ->label('Bulan')
                        ->options(collect(range(1, 12))->mapWithKeys(fn ($m) => [$m => Carbon::create(null, $m)->monthName])->toArray())
                        ->default(date('n'))
                        ->visible(fn (Get $get) => $get('view_mode') === 'daily'),

                ])->columns(5)
        ]);
    }

    public function getWidgets(): array
    {
        return [
            ManhourChart::class,
            ManpowerChart::class,
        ];
    }
}
