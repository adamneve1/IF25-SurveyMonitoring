<?php
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Manhour;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ManhourChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Manhour';

    protected int | string | array  $columnSpan = 1 ;

    protected function getData(): array
    {
        $proyek = $this->filters['proyek'];
        $start = $this->filters['start'];
        $end = $this->filters['end'];
        

        // Sum overtime hours per month
        $dataOvertime = Trend::model(Manhour::class)
            ->between(
                start: $start ? Carbon::parse($start) : now()->subMonths(6),
                end: $end ? Carbon::parse($end) : now(),
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
