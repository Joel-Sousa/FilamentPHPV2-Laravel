<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Tables\Enums\FiltersLayout;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set) {
                        $state = Str::slug($state);
                        $set('slug', $state);
                    })
                    ->label('Nome categoria'),
                // TextInput::make('description')
                //     ->label('Descrição'),
                Forms\Components\TextInput::make('slug')
                    ->disabled()
                    ->label('Slug'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Nome'),
                // Tables\Columns\TextColumn::make('description')
                //     ->searchable()
                //     ->label('Descricao'),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->label('Slug'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('product')
                    ->searchable()
                    ->relationship('products', 'name')
                    // ->preload()
                    ->label('Contrato'),
                Tables\Filters\SelectFilter::make('collaborator')
                    ->searchable()
                    ->relationship('products', 'name')
                    // ->preload()
                    ->label('Colaborador'),
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->format('d/m/Y')
                            ->columnSpan(10)
                            ->label('Data Inicial'),
                        Forms\Components\DatePicker::make('until')
                            ->format('d/m/Y')
                            ->columnSpan(10)
                            ->label('Data Final'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    })
                    ->columns(20),
                ])
            // ], layout: FiltersLayout::AboveContent)
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
