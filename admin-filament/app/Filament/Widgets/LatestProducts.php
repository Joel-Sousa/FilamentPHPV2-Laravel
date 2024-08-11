<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestProducts extends BaseWidget
{

    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 3;


    
    protected function getTableQuery(): Builder
    {
        return Product::query()->latest();
        // return Product::take(2)->orderBy('id', 'desc');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('name'),
        ];
    }
}
