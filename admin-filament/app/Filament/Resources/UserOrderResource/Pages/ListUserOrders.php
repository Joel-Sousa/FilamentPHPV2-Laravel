<?php

namespace App\Filament\Resources\UserOrderResource\Pages;

use App\Filament\Resources\UserOrderResource;
use Filament\Forms\Components\View;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View as ViewView;

class ListUserOrders extends ListRecords
{
    protected static string $resource = UserOrderResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableContentFooter(): ?ViewView
    {
        return view('filament.resources.orders.table.footer');
    } 
}
