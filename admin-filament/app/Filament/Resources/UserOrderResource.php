<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserOrderResource\Pages;
use App\Filament\Resources\UserOrderResource\RelationManagers;
use App\Models\UserOrder;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserOrderResource extends Resource
{
    protected static ?string $model = UserOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id'),
                Tables\Columns\TextColumn::make('user.name')
                    // ->url('/ok')
                    ->url(fn (UserOrder $record) => UserResource::getUrl('edit', ['record' => $record->user]))
                    ->label('name'),
                Tables\Columns\TextColumn::make('order_code')
                    ->label('order_code'),
                Tables\Columns\TextColumn::make('orderTotal')->money('BRL'),
                Tables\Columns\TextColumn::make('items_count'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserOrders::route('/'),
            'create' => Pages\CreateUserOrder::route('/create'),
            'edit' => Pages\EditUserOrder::route('/{record}/edit'),
        ];
    }
}
