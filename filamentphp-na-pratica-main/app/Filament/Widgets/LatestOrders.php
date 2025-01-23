<?php

namespace App\Filament\Widgets;

use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Models\UserOrder as Order;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    protected static ?string $heading = 'Últimos pedidos realizados';

    protected function getTableQuery(): Builder
    {
        return Order::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('user.name'),
            Tables\Columns\TextColumn::make('items_count')->searchable(),
            Tables\Columns\TextColumn::make('orderTotal')->money('BRL'),
            Tables\Columns\TextColumn::make('created_at')->date('d/m/Y H:i:s')
        ];
    }
}
