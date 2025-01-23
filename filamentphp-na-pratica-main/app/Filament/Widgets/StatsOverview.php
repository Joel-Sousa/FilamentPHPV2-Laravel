<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use App\Models\UserOrder;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getCards(): array
    {
        return [
            Card::make('Total de Pedidos', UserOrder::count()),
            Card::make(
                'Total Ganho (30 dias)',
                'R$ ' . $this->getThirtyDaysOrders()
            )
            // ->description('Total Vendido Geral')
            // ->chart([10, 30, 20])
            // ->color('success')
        ];
    }

    protected function getThirtyDaysOrders()
    {
        $result = OrderItem::where('created_at', '>', now()->subDays(30))
            ->sum('order_value');

        return number_format($result / 100, 2, ',', '.');
    }
}
