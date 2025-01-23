<?php

namespace App\Filament\Widgets;

use App\Models\UserOrder;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrdersChart extends LineChartWidget
{
    protected static ?string $heading = 'Vendas por Mês';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

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
                    'label' => 'Vendas por Mês',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ]
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
}
