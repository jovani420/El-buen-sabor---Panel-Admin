<?php

namespace App\Filament\Resources\Discounts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class DiscountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                TextInput::make('value')
                    ->required()
                    ->numeric(),
                DatePicker::make('expires_at'),
                Select::make('type')
                    ->multiple()
                    ->required()
                    ->searchable()
                    ->label('Tamaños disponibles')
                    ->options([
                    'percentage' => 'Descuento Porcentual', // Value: 'percentage', Label: 'Descuento Porcentual'
                        'fixed' => 'Monto Fijo',               // Value: 'fixed', Label: 'Monto Fijo'
                        'free_shipping' => 'Envío Gratuito',
                    ]),
            ]);
    }
}
