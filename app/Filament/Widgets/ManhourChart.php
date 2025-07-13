<?php

namespace App\Filament\Widgets;

use App\Models\Manhour;
use App\Models\Proyek;
use App\Models\ProyekPlan;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;

class ManhourChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Manhour';
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
        static::$heading = 'Rekap Tahunan Manhour: ' . ($proyek->nama_proyek ?? '');

        // Tentukan rentang tahun dari proyek
        $startYear = Carbon::parse($proyek->tanggal_mulai)->year;
        $endYear = Carbon::parse($proyek->estimasi_selesai)->year;
        $yearRange = range($startYear, $endYear);

        $query = Manhour::where('proyek_id', $proyekId)
            ->when($divisiId, fn($q) => $q->whereHas('manpower_idl.divisi', fn($sub) => $sub->where('id', $divisiId)));

        // Ambil total realisasi per tahun
        $actuals = Trend::query($query)
            ->between(
                start: Carbon::create($startYear)->startOfYear(),
                end: Carbon::create($endYear)->endOfYear()
            )
            ->perYear()->dateColumn('tanggal')->sum('overtime');
        
        $actualsMap = $actuals->mapWithKeys(fn ($value) => [Carbon::parse($value->date)->year => $value->aggregate]);
        
        // Ambil total plan per tahun
        $plans = ProyekPlan::where('proyek_id', $proyekId)
            ->whereIn('tahun', $yearRange)
            ->groupBy('tahun')
            ->selectRaw('tahun, SUM(jumlah_plan) as total_plan')
            ->pluck('total_plan', 'tahun');

        $actualValues = collect($yearRange)->map(fn ($year) => $actualsMap->get($year) ?? 0);
        $planValues = collect($yearRange)->map(fn ($year) => $plans->get($year) ?? 0);

        $totalActual = $actualValues->sum();
        $totalPlan = $planValues->sum();
        static::$description = 'Total Realisasi Proyek: ' . $totalActual . ' Jam | Total Plan Proyek: ' . $totalPlan . ' Jam';

        return [
            'datasets' => [
                ['label' => 'Realisasi Manhours', 'data' => $actualValues->all(), 'backgroundColor' => '#36A2EB'],
                ['label' => 'Plan Manhours', 'data' => $planValues->all(), 'backgroundColor' => '#FF6384'],
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
        static::$heading = 'Progres Harian: ' . ($proyek->nama_proyek ?? '') . ' - ' . $start->format('F Y');

        $query = Manhour::where('proyek_id', $proyekId)
            ->when($divisiId, fn($q) => $q->whereHas('manpower_idl.divisi', fn($sub) => $sub->where('id', $divisiId)));

        $monthlyPlan = ProyekPlan::where('proyek_id', $proyekId)->where('tahun', $start->year)->where('bulan', $start->month)->value('jumlah_plan') ?? 0;
        $actualDataPerDay = Trend::query($query)->between(start: $start, end: $end)->perDay()->dateColumn('tanggal')->sum('overtime');
        $totalActualManhours = $actualDataPerDay->sum('aggregate');

        if ($monthlyPlan > 0) {
            $variance = $totalActualManhours - $monthlyPlan;
            $planInfo = '(Plan: ' . $monthlyPlan . ' Jam)';
            $summary = '| Total Realisasi: ' . $totalActualManhours . ' Jam';
            static::$description = ($totalActualManhours > $monthlyPlan)
                ? '❌ Status: Over Budget ' . abs($variance) . ' Jam ' . $planInfo . $summary
                : '✅ Status: Sesuai Target (Hemat ' . abs($variance) . ' Jam) ' . $planInfo . $summary;
        } else {
            static::$description = 'Info: Belum ada plan untuk bulan ini.';
        }
        
        $actualsMap = $actualDataPerDay->mapWithKeys(fn ($value) => [Carbon::parse($value->date)->format('Y-m-d') => $value->aggregate]);
        $labels = []; $cumulativeActualValues = []; $idealPlanValues = []; $dailyActualValues = [];
        $cumulativeActual = 0; $daysInMonth = $start->daysInMonth;
        $idealDailyIncrement = ($monthlyPlan > 0 && $daysInMonth > 0) ? $monthlyPlan / $daysInMonth : 0;
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDate = $start->copy()->day($day); $dailyActual = $actualsMap->get($currentDate->format('Y-m-d'), 0);
            $labels[] = $currentDate->format('d M'); $dailyActualValues[] = $dailyActual;
            $cumulativeActual += $dailyActual; $cumulativeActualValues[] = $cumulativeActual;
            $idealPlanValues[] = round($idealDailyIncrement * $day, 2);
        }
        return ['datasets' => [['label' => 'Manhour Harian', 'data' => $dailyActualValues, 'backgroundColor' => 'rgba(128, 128, 128, 0.2)', 'type' => 'bar', 'order' => 2], ['label' => 'Realisasi (Akumulatif)', 'data' => $cumulativeActualValues, 'borderColor' => '#1E90FF', 'backgroundColor' => 'rgba(30, 144, 255, 0.1)', 'fill' => true, 'type' => 'line', 'order' => 1], ['label' => 'Budget Ideal', 'data' => $idealPlanValues, 'borderColor' => '#FF4136', 'borderWidth' => 2, 'borderDash' => [5, 5], 'pointRadius' => 0, 'type' => 'line', 'order' => 1, 'hidden' => true], ['label' => 'Target Akhir', 'data' => array_fill(0, count($labels), $monthlyPlan), 'borderColor' => 'rgba(75, 192, 192, 0.5)', 'borderWidth' => 2, 'pointRadius' => 0, 'type' => 'line', 'order' => 1, 'hidden' => true]], 'labels' => $labels];
    }

    protected function getMonthlyData(): array
    {
        $proyekId = $this->filters['proyek_id'];
        $divisiId = $this->filters['divisi_id'] ?? null;
        $year = $this->filters['year'] ?? now()->year;
        $start = Carbon::create($year)->startOfYear();
        $end = Carbon::create($year)->endOfYear();

        $proyek = Proyek::find($proyekId);
        static::$heading = 'Rekap Bulanan: ' . ($proyek->nama_proyek ?? '') . ' - Tahun ' . $year;

        $query = Manhour::where('proyek_id', $proyekId)
            ->when($divisiId, fn($q) => $q->whereHas('manpower_idl.divisi', fn($sub) => $sub->where('id', $divisiId)));
            
        $actuals = Trend::query($query)->between(start: $start, end: $end)->perMonth()->dateColumn('tanggal')->sum('overtime');
            
        $plans = ProyekPlan::where('proyek_id', $proyekId)->where('tahun', $year)->get()->keyBy('bulan');
        $labels = collect(range(1, 12))->map(fn ($month) => Carbon::create($year, $month)->format('M'));
        $actualsMap = $actuals->mapWithKeys(fn ($value) => [Carbon::parse($value->date)->month => $value->aggregate]);
        $actualValues = collect(range(1, 12))->map(fn ($month) => $actualsMap->get($month) ?? 0);
        $planValues = collect(range(1, 12))->map(fn ($month) => $plans->get($month)?->jumlah_plan ?? 0);
        $totalActual = $actualValues->sum(); $totalPlan = $planValues->sum();
        static::$description = 'Total Realisasi: ' . $totalActual . ' Jam | Total Plan: ' . $totalPlan . ' Jam';

        return ['datasets' => [['label' => 'Realisasi Manhours', 'data' => $actualValues->all(), 'backgroundColor' => '#36A2EB', 'type' => 'bar'], ['label' => 'Plan Manhours', 'data' => $planValues->all(), 'backgroundColor' => '#FF6384', 'type' => 'bar']], 'labels' => $labels->all()];
    }

    protected function getType(): string
    {
        // Saat mode yearly, lebih baik menggunakan 'bar'
        return $this->filters['view_mode'] === 'monthly' || $this->filters['view_mode'] === 'yearly' ? 'bar' : 'line';
    }
}
