<?php

namespace App\Filament\Resources\Discounts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
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
                TextInput::make('type')
                    ->required(),
                DatePicker::make('expires_at'),
            ]);
    }
}
