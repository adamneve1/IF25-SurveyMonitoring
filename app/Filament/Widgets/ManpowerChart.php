<?php

namespace App\Filament\Widgets;

use App\Models\Manpower;
use App\Models\ManpowerIdlAbsensi;
use App\Models\Proyek;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;

class ManpowerChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Kehadiran Manpower';
    protected static ?string $description = null;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $maxHeight = '300px';
    protected static ?string $pollingInterval = '15s';

    protected function getData(): array
    {
        $proyekId = $this->filters['proyek_id'] ?? null;
        if (!$proyekId) {
            static::$heading = 'Pilih Proyek pada filter di atas.';
            static::$description = null;
            return ['datasets' => [], 'labels' => []];
        }

        $viewMode = $this->filters['view_mode'] ?? 'daily';
        
        return match ($viewMode) {
            'monthly' => $this->getMonthlyData(),
            'yearly' => $this->getYearlyData(), // <-- PANGGIL METHOD BARU
            default => $this->getDailyData(),
        };
    }

    /**
     * --- METHOD BARU UNTUK TAMPILAN TAHUNAN ---
     */
    protected function getYearlyData(): array
    {
        $proyekId = $this->filters['proyek_id'];
        $divisiId = $this->filters['divisi_id'] ?? null;

        $proyek = Proyek::find($proyekId);
        static::$heading = 'Rekap Tahunan Kehadiran: ' . ($proyek->nama_proyek ?? '');

        // Tentukan rentang tahun dari proyek
        $startYear = Carbon::parse($proyek->tanggal_mulai)->year;
        $endYear = Carbon::parse($proyek->estimasi_selesai)->year;
        $yearRange = range($startYear, $endYear);

        $manpowerQuery = Manpower::where('proyek_id', $proyekId)->where('hadir', 1)
            ->when($divisiId, fn($q) => $q->whereHas('manpower_dl.manpower_idl.divisi', fn($sub) => $sub->where('id', $divisiId)));
            
        $idlQuery = ManpowerIdlAbsensi::where('proyek_id', $proyekId)->where('hadir', 1)
            ->when($divisiId, fn($q) => $q->whereHas('manpower_idl.divisi', fn($sub) => $sub->where('id', $divisiId)));

        // Ambil total kehadiran per tahun
        $actualManpower = Trend::query($manpowerQuery)
            ->between(start: Carbon::create($startYear)->startOfYear(), end: Carbon::create($endYear)->endOfYear())
            ->perYear()->dateColumn('tanggal')->count();
        
        $actualIdl = Trend::query($idlQuery)
            ->between(start: Carbon::create($startYear)->startOfYear(), end: Carbon::create($endYear)->endOfYear())
            ->perYear()->dateColumn('tanggal')->count();

        $manpowerMap = $actualManpower->mapWithKeys(fn ($value) => [Carbon::parse($value->date)->year => $value->aggregate]);
        $idlMap = $actualIdl->mapWithKeys(fn ($value) => [Carbon::parse($value->date)->year => $value->aggregate]);

        $manpowerValues = collect($yearRange)->map(fn ($year) => $manpowerMap->get($year) ?? 0);
        $idlValues = collect($yearRange)->map(fn ($year) => $idlMap->get($year) ?? 0);

        $totalHadir = $manpowerValues->sum() + $idlValues->sum();
        static::$description = 'Total Kehadiran (Man-days) Selama Proyek: ' . $totalHadir . ' Orang';

        return [
            'datasets' => [
                ['label' => 'Manpower', 'data' => $manpowerValues->all(), 'backgroundColor' => '#36A2EB', 'stack' => 'A'],
                ['label' => 'Manpower IDL', 'data' => $idlValues->all(), 'backgroundColor' => '#FF6384', 'stack' => 'A'],
            ],
            'labels' => $yearRange,
        ];
    }

    protected function getDailyData(): array
    {
        $proyekId = $this->filters['proyek_id'];
        $divisiId = $this->filters['divisi_id'] ?? null;
        $year = $this->filters['year'] ?? now()->year;
        $month = $this->filters['month'] ?? now()->month;
        
        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $proyek = Proyek::find($proyekId);
        static::$heading = 'Kehadiran Harian: ' . ($proyek->nama_proyek ?? '') . ' - ' . $start->format('F Y');

        $manpowerQuery = Manpower::where('proyek_id', $proyekId)->where('hadir', 1)
            ->when($divisiId, fn($q) => $q->whereHas('manpower_dl.manpower_idl.divisi', fn($sub) => $sub->where('id', $divisiId)));
        $idlQuery = ManpowerIdlAbsensi::where('proyek_id', $proyekId)->where('hadir', 1)
            ->when($divisiId, fn($q) => $q->whereHas('manpower_idl.divisi', fn($sub) => $sub->where('id', $divisiId)));

        $manpowerData = Trend::query($manpowerQuery)->between(start: $start, end: $end)->perDay()->dateColumn('tanggal')->count();
        $idlData = Trend::query($idlQuery)->between(start: $start, end: $end)->perDay()->dateColumn('tanggal')->count();
        
        $labels = $manpowerData->map(fn ($value) => Carbon::parse($value->date)->format('d M'));
        $manpowerValues = $manpowerData->map(fn ($value) => $value->aggregate);
        $idlValues = $idlData->map(fn ($value) => $value->aggregate);

        $dailyTotals = $manpowerValues->map(fn ($item, $key) => $item + ($idlValues[$key] ?? 0));
        $workingDays = $dailyTotals->filter(fn ($dailyCount) => $dailyCount > 0)->count();
        $totalManDays = $dailyTotals->sum();
        $averageAttendance = ($workingDays > 0) ? round($totalManDays / $workingDays, 1) : 0;
        $peakAttendance = $dailyTotals->max();
        static::$description = 'Rata-rata Kehadiran: ' . $averageAttendance . ' Orang/Hari | Puncak: ' . $peakAttendance . ' Orang';

        return [
            'datasets' => [
                ['label' => 'Manpower', 'data' => $manpowerValues->all(), 'backgroundColor' => '#36A2EB', 'stack' => 'A'],
                ['label' => 'Manpower IDL', 'data' => $idlValues->all(), 'backgroundColor' => '#FF6384', 'stack' => 'A'],
            ],
            'labels' => $labels->all(),
        ];
    }

    protected function getMonthlyData(): array
    {
        $proyekId = $this->filters['proyek_id'];
        $divisiId = $this->filters['divisi_id'] ?? null;
        $year = $this->filters['year'] ?? now()->year;
        $start = Carbon::create($year)->startOfYear();
        $end = Carbon::create($year)->endOfYear();

        $proyek = Proyek::find($proyekId);
        static::$heading = 'Total Kehadiran Bulanan: ' . ($proyek->nama_proyek ?? '') . ' - Tahun ' . $year;

        $manpowerQuery = Manpower::where('proyek_id', $proyekId)->where('hadir', 1)
            ->when($divisiId, fn($q) => $q->whereHas('manpower_dl.manpower_idl.divisi', fn($sub) => $sub->where('id', $divisiId)));
        $idlQuery = ManpowerIdlAbsensi::where('proyek_id', $proyekId)->where('hadir', 1)
            ->when($divisiId, fn($q) => $q->whereHas('manpower_idl.divisi', fn($sub) => $sub->where('id', $divisiId)));

        $manpowerMonthly = Trend::query($manpowerQuery)->between(start: $start, end: $end)->perMonth()->dateColumn('tanggal')->count();
        $idlMonthly = Trend::query($idlQuery)->between(start: $start, end: $end)->perMonth()->dateColumn('tanggal')->count();

        $labels = collect(range(1, 12))->map(fn ($month) => Carbon::create($year, $month)->format('M'));
        $manpowerMap = $manpowerMonthly->mapWithKeys(fn ($value) => [Carbon::parse($value->date)->month => $value->aggregate]);
        $idlMap = $idlMonthly->mapWithKeys(fn ($value) => [Carbon::parse($value->date)->month => $value->aggregate]);
        
        $manpowerValues = collect(range(1, 12))->map(fn ($month) => $manpowerMap->get($month) ?? 0);
        $idlValues = collect(range(1, 12))->map(fn ($month) => $idlMap->get($month) ?? 0);

        $totalHadir = $manpowerValues->sum() + $idlValues->sum();
        static::$description = 'Total Kehadiran (Man-days) Tahun Ini: ' . $totalHadir . ' Orang';

        return [
            'datasets' => [
                ['label' => 'Manpower', 'data' => $manpowerValues->all(), 'backgroundColor' => '#36A2EB', 'stack' => 'A'],
                ['label' => 'Manpower IDL', 'data' => $idlValues->all(), 'backgroundColor' => '#FF6384', 'stack' => 'A'],
            ],
            'labels' => $labels->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
