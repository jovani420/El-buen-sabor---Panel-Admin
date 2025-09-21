<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name'),
                Select::make('discount_id')
                    ->relationship('discount', 'id'),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                TextInput::make('total_price')
                    ->required()
                    ->numeric(),
                TextInput::make('delivery_option')
                    ->required(),
                TextInput::make('delivery_address'),
                TimePicker::make('pickup_time'),
                TextInput::make('tracking_code')
                    ->required(),
            ]);
    }
}
