<?php

namespace App\Filament\Resources\UserOrderResource\Pages;

use App\Filament\Resources\UserOrderResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserOrder extends EditRecord
{
    protected static string $resource = UserOrderResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
