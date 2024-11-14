<?php
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Manhour;
use Carbon\Carbon;

class ManhourChart extends ChartWidget
{
    protected static ?string $heading = 'Manhour';

    protected function getData(): array
    {
        // Sum overtime hours per month
        $dataOvertime = Trend::model(Manhour::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('overtime');

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Manhours',
                    'data' => $dataOvertime->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#4CAF50',
                    'backgroundColor' => '#4CAF50',
                ],
            ],
            'labels' => $dataOvertime->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('F')),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
