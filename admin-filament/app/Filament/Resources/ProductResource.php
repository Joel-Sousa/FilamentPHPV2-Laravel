<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Tables\Enums\FiltersLayout;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    // protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->rules([''])
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set) {
                        $state = Str::slug($state);
                        $set('slug', $state);
                    })
                    ->label('Nome'),
                Forms\Components\TextInput::make('description')
                    ->label('Descricao'),
                Forms\Components\TextInput::make('price')
                    ->label('Preco'),
                Forms\Components\TextInput::make('amount')
                    ->label('Quantidade'),
                Forms\Components\TextInput::make('slug')
                    ->disabled()
                    ->label('Slug'),
                Forms\Components\FileUpload::make('photo')
                    ->image()
                    ->directory('products'),
                // Select::make('categories')
                //     ->relationship('categories', 'name')
                //     ->preload()
                //     ->multiple(),

                // 

                // Forms\Components\Card::make([
                //     Forms\Components\TextInput::make('tst'),
                // ]),
                // Forms\Components\Fieldset::make('tst')
                //     ->schema([
                //         Forms\Components\TextInput::make('tst'),
                //     ])

                // 

                // Forms\Components\Tabs::make('Tabs')
                //     ->tabs([
                //         Forms\Components\Tabs\Tab::make('tab')
                //         ->icon('heroicon-o-collection')
                //             ->schema([
                //                 Forms\Components\TextInput::make('tst'),
                //             ]),
                //         Forms\Components\Tabs\Tab::make('tab1')
                //             ->schema([
                //                 Forms\Components\TextInput::make('tst1'),
                //                 Forms\Components\TextInput::make('tst2'),
                //             ])
                //     ])

                // 

                // Forms\Components\Wizard::make()
                //     ->schema([
                //         Forms\Components\Wizard\Step::make('step')
                //             ->schema([
                //                 Forms\Components\TextInput::make('tst')
                //                 // ->required(),
                //             ]),
                //         Forms\Components\Wizard\Step::make('step1')
                //             ->schema([
                //                 Forms\Components\TextInput::make('tst'),
                //                 Forms\Components\TextInput::make('tst1'),
                //             ]),
                //         Forms\Components\Wizard\Step::make('step2')
                //             ->schema([
                //                 Forms\Components\TextInput::make('tst'),
                //                 Forms\Components\TextInput::make('tst1'),
                //                 Forms\Components\TextInput::make('tst2'),
                //             ])
                //     ])

                // 

                // Forms\Components\Section::make('section')
                // ->description('teste')
                //     ->schema([
                //         Forms\Components\TextInput::make('tst'),
                //     ]),
                // Forms\Components\Group::make()
                //     ->schema([
                //         Forms\Components\TextInput::make('tst'),
                //     ]),
                // Forms\Components\Grid::make()
                //     ->schema([
                //         Forms\Components\TextInput::make('tst'),
                //         Forms\Components\TextInput::make('tst'),
                //     ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                /* ->sortable() */,
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('price')
                    ->searchable()
                    // ->sortable()
                    ->money('BRL', 2),
                Tables\Columns\TextColumn::make('amount'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('created_at')
                    ->date('d/m/Y'),

            ])
            ->filters([
                Tables\Filters\Filter::make('amount')
                    ->label('filtro')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('amount', '>', 6)),
                Tables\Filters\Filter::make('amount1')
                    ->label('filtro1')
                    ->toggle()
                    ->query(function (Builder $query) {
                        return $query
                            ->when(
                                fn (Builder $query): Builder => $query->where('amount', '<', 6)
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('price', 'DESC');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CategoriesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
            'prod' => Pages\Prod::route('/prod'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return self::getModel()::count();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }
}
