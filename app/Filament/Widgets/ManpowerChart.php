<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Manpower;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ManpowerChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Manpower';

    protected function getData(): array
{
    $proyek = $this->filters['proyek_id'] ?? null;
    $start = $this->filters['start'];
    $end = $this->filters['end'];

    // Query untuk Manpower
    $manpowerQuery = \App\Models\Manpower::query()
        ->selectRaw('DATE(tanggal) as tanggal, COUNT(id) as total_hadir')
        ->where('hadir', 1)
        ->when($proyek, fn ($q) => $q->where('proyek_id', $proyek))
        ->when($start, fn ($q) => $q->where('tanggal', '>=', Carbon::parse($start)))
        ->when($end, fn ($q) => $q->where('tanggal', '<=', Carbon::parse($end)))
        ->groupBy('tanggal');

    // Query untuk Manpower IDL
    $manpowerIdlQuery = \App\Models\ManpowerIdlAbsensi::query()
        ->selectRaw('DATE(tanggal) as tanggal, COUNT(id) as total_hadir')
        ->where('hadir', 1)
        ->when($proyek, fn ($q) => $q->where('proyek_id', $proyek))
        ->when($start, fn ($q) => $q->where('tanggal', '>=', Carbon::parse($start)))
        ->when($end, fn ($q) => $q->where('tanggal', '<=', Carbon::parse($end)))
        ->groupBy('tanggal');

    // Gabungkan kedua query
    $query = $manpowerQuery->unionAll($manpowerIdlQuery)->get();

    // Hitung total hadir per tanggal
    $data = collect($query)->groupBy('tanggal')->map(function ($items) {
        return $items->sum('total_hadir');
    });

    return [
        'datasets' => [
            [
                'label' => 'Total Kehadiran Manpower & Manpower IDL',
                'data' => $data->values(),
                'borderColor' => '#4CAF50',
                'backgroundColor' => '#4CAF50',
            ],
        ],
        'labels' => $data->keys(),
    ];
}


    protected function getType(): string
    {
        return 'bar';
    }
}
