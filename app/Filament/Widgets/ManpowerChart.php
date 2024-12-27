<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Manpower;
use App\Models\Manhour;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class ManpowerChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Manpower';

    protected function getData(): array
    {
       $proyek = $this->filters['proyek_id'] ?? null;
        $start = $this->filters['start'];
        $end = $this->filters['end'];

           $query = Manpower::query()
            ->selectRaw('DATE(tanggal) as tanggal, count(id) as total_hadir')
            ->when($proyek, function ($query, $proyek) {
                return $query->where('proyek_id', $proyek);
            })
           ->where('hadir', 1)
            ->when($start, function ($query, $start) {
                return $query->where('tanggal', '>=', Carbon::parse($start));
            })
             ->when($end, function ($query, $end) {
                return $query->where('tanggal', '<=', Carbon::parse($end));
            })
           ->groupBy('tanggal')
           ->orderBy('tanggal')
          ->get();
         $labels = $query->map(function ($item){
            return Carbon::parse($item->tanggal)->format('Y-m-d');
        });
    

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Manpower Hadir',
                     'data' => $query->map(fn ($item) => $item->total_hadir),
                    'borderColor' => '#4CAF50',
                    'backgroundColor' => '#4CAF50',
                ],
            ],
            'labels' =>  $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}