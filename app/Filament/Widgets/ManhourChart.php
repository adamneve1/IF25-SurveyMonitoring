<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Manhour;
use App\Models\Proyek; // Tambahkan Model Proyek
use Carbon\Carbon;
use App\Models\ProyekPlan; // Import model ProyekPlan
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ManhourChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Manhour';

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $proyekId = $this->filters['proyek_id'] ?? null;
        $start = $this->filters['start'];
        $end = $this->filters['end'];

        // Ambil Data Overtime
        $query = Manhour::query()
            ->when($proyekId, function ($query, $proyekId) {
                return $query->where('proyek_id', $proyekId);
            })
            ->whereNotNull('tanggal');

        $dataOvertime = Trend::query($query)
            ->between(
                start: $start ? Carbon::parse($start) : now()->subMonths(6),
                end: $end ? Carbon::parse($end) : now(),
            )
            ->perMonth()
            ->dateColumn('tanggal')
            ->sum('overtime');

        // Ambil Plan dari `proyek_plans`
        $planValues = [];
        $labels = [];

        foreach ($dataOvertime as $value) {
            $bulan = Carbon::parse($value->date)->month;
            $tahun = Carbon::parse($value->date)->year;

            // Ambil jumlah_plan dari tabel proyek_plans
            $plan = ProyekPlan::where('proyek_id', $proyekId)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->value('jumlah_plan') ?? 0;

            $planValues[] = $plan;
            $labels[] = Carbon::parse($value->date)->format('F Y');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Manhours',
                    'data' => $dataOvertime->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#4CAF50',
                    'backgroundColor' => 'rgba(76, 175, 80, 0.5)', // Warna hijau dengan 50% transparansi
                    'type' => 'bar',
                ],
                [
                    'label' => 'Plan Manpower',
                    'data' => $planValues,
                    'borderColor' => '#FF9800',
                    'backgroundColor' => 'transparent',
                    'borderWidth' => 2,
                    'pointRadius' => 5,
                    'borderDash' => [5, 5], 
                    'type' => 'line',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}