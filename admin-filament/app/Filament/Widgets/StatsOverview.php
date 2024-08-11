<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{

    protected static ?string $pollingInterval = '10s';
    protected static ?int $sort = 1;

    // protected static bool $isLazy = false;

    protected function getCards(): array
    {
        return [
            Card::make('tst', 10)
                ->description('teste')
                ->chart([10, 20, 30, 10, 10, 20, 30, 10, 10, 20, 30, 10,])
                ->color('success'),
            Card::make('tst1', 20),
            Card::make('tst2', 30),
        ];
    }
}
