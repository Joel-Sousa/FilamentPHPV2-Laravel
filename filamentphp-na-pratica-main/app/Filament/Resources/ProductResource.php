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

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'Admin';

    protected static ?string $navigationIcon = 'heroicon-o-desktop-computer';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Produtos';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form->columns(1)
            ->schema([


                Forms\Components\Section::make('Heading 1')
                    ->description('Descrição área...')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, $set) {
                                $state = Str::slug($state);

                                $set('slug', $state);
                            })
                            ->label('Nome Produto'),
                        TextInput::make('description')->label('Descrição Produto'),
                        TextInput::make('price')->required()->label('Preço Produto'),
                        TextInput::make('amount')->required()->label('Quantidade Produto'),
                    ]),

                Forms\Components\Section::make('Heading 2')
                    ->description('Cabeçalho sessão 2...')
                    ->schema([
                        TextInput::make('slug')->disabled(),
                        FileUpload::make('photo')
                            ->image()
                            ->directory('products'),
                    ])


                // Forms\Components\Wizard::make()->schema([
                //     Forms\Components\Wizard\Step::make('Tab1')->schema([
                //         TextInput::make('name')
                //             ->required()
                //             ->reactive()
                //             ->afterStateUpdated(function ($state, $set) {
                //                 $state = Str::slug($state);

                //                 $set('slug', $state);
                //             })
                //             ->label('Nome Produto'),
                //         TextInput::make('description')->label('Descrição Produto'),
                //         TextInput::make('price')->required()->label('Preço Produto'),
                //     ]),

                //     Forms\Components\Wizard\Step::make('Tab2')->schema([
                //         TextInput::make('amount')->required()->label('Quantidade Produto'),
                //         TextInput::make('slug')->disabled(),
                //         FileUpload::make('photo')
                //             ->image()
                //             ->directory('products'),
                //     ])
                // ])


                // Forms\Components\Tabs::make('Tabs')->tabs([
                //     Forms\Components\Tabs\Tab::make('Tab1')->schema([
                //         TextInput::make('name')
                //             ->required()
                //             ->reactive()
                //             ->afterStateUpdated(function ($state, $set) {
                //                 $state = Str::slug($state);

                //                 $set('slug', $state);
                //             })
                //             ->label('Nome Produto'),
                //         TextInput::make('description')->label('Descrição Produto'),
                //         TextInput::make('price')->required()->label('Preço Produto'),
                //     ]),

                //     Forms\Components\Tabs\Tab::make('Tab2')->schema([
                //         TextInput::make('amount')->required()->label('Quantidade Produto'),
                //         TextInput::make('slug')->disabled(),
                //         FileUpload::make('photo')
                //             ->image()
                //             ->directory('products'),
                //     ])
                // ])









                // Forms\Components\Card::make()->schema([
                //     TextInput::make('name')
                //         ->required()
                //         ->reactive()
                //         ->afterStateUpdated(function ($state, $set) {
                //             $state = Str::slug($state);

                //             $set('slug', $state);
                //         })
                //         ->label('Nome Produto'),
                //     TextInput::make('description')->label('Descrição Produto'),
                //     TextInput::make('price')->required()->label('Preço Produto'),
                //     TextInput::make('amount')->required()->label('Quantidade Produto'),
                // ]),
                // Forms\Components\Fieldset::make('Dados 2')->schema([
                //     TextInput::make('slug')->disabled(),
                //     FileUpload::make('photo')
                //         ->image()
                //         ->directory('products'),
                // ])

                //Select::make('categories')->relationship('categories', 'name')->multiple()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')->circular()->height(80),
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('price')->searchable()
                    ->sortable()
                    ->money('BRL'),
                TextColumn::make('amount'),
                TextColumn::make('created_at')->date('d/m/Y H:i:s')
            ])
            ->filters([
                Filter::make('amount')
                    ->toggle()
                    ->label('Qtd Maior Que 9')
                    ->query(fn (Builder $query) => $query->where('amount', '>=', 9)),

                Filter::make('amount_mq') //->default()
                    ->toggle()
                    ->label('Qtd Menor Que 9')
                    ->query(fn (Builder $query) => $query->where('amount', '<', 9))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'DESC');
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
            'produ' => Pages\Produ::route('/produ')
        ];
    }

    protected static function getNavigationBadge(): ?string
    {
        return self::getModel()::count();
    }
}
