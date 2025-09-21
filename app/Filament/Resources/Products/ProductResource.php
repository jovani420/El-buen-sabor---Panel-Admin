<?php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Pages\EditProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Filament\Resources\Products\Pages\ViewProduct;
use App\Filament\Resources\Products\Schemas\ProductInfolist;
use App\Filament\Resources\Products\Tables\ProductsTable;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Product';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')->required()->maxLength(255),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                RichEditor::make('description')->required(),
                TextInput::make('price')->required()->numeric()->prefix('$'),
                FileUpload::make('image')->image()->directory('product-images'),
                Toggle::make('is_featured')->label('Producto Destacado'),
                Toggle::make('is_daily_deal')->label('Oferta del Día'),
                Select::make('allergens')
                    ->multiple()
                    ->searchable()
                    ->options([
                        'milk' => 'Leche',
                        'nuts' => 'Frutos Secos',
                        'gluten' => 'Gluten',
                    ]),
                Select::make('addons')
                    ->multiple()
                    ->relationship('addons', 'name')
                    ->preload()
                    ->label('Extras Disponibles'),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProductInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),
                TextColumn::make('name')->searchable(),
                TextColumn::make('category.name'),
                TextColumn::make('price')->money('usd')->sortable(),
                IconColumn::make('is_featured')->boolean()->label('Destacado'),
                IconColumn::make('is_daily_deal')->boolean()->label('Oferta'),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
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
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'view' => ViewProduct::route('/{record}'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
