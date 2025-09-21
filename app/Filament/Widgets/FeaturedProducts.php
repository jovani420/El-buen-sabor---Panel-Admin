<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class FeaturedProducts extends BaseWidget
{
      protected static ?int $sort = 2;

    public function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        // Filtramos para obtener solo los productos que son destacados o son ofertas del día
        return Product::query()
            ->where('is_featured', true)
            ->orWhere('is_daily_deal', true);
    }
    
    public function getTableColumns(): array
    {
        return [
            ImageColumn::make('image'),
            TextColumn::make('name')->searchable(),
            TextColumn::make('price')->money('usd')->sortable(),
            IconColumn::make('is_daily_deal')
                ->boolean()
                ->label('Oferta del Día')
                ->sortable(),
        ];
    }

}
