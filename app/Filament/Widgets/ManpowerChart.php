<?php
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Manhour;
use Carbon\Carbon;

class ManpowerChart extends ChartWidget
{
    protected static ?string $heading = 'Manpower';

    protected function getData(): array
    {
        $dataLangsung = Trend::model(Manhour::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('jumlah_tenaga_langsung');

        $dataTidakLangsung = Trend::model(Manhour::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('jumlah_tenaga_tidak_langsung');

        return [
            'datasets' => [
                [
                    'label' => 'IDL',
                    'data' => $dataLangsung->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#4CAF50',
                ],
                [
                    'label' => 'DL',
                    'data' => $dataTidakLangsung->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#FF5722',
                ],
            ],
            'labels' => $dataLangsung->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('F')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
