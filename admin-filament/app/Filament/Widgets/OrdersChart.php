<?php

namespace App\Filament\Widgets;

use App\Models\UserOrder;
use Filament\Widgets\BarChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrdersChart extends BarChartWidget
{
    protected static ?string $heading = 'vpm';
    protected static ?string $color = 'info';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    public ?string $filter = 'today';


    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }

    protected function getData(): array
    {
        $data = Trend::model(UserOrder::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Vendas por mes',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor'=> 'blue',
                ],
                [
                    'label' => 'Perdas por mes',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor'=> 'red',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
}
