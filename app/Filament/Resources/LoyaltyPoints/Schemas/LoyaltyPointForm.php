<?php

namespace App\Filament\Resources\LoyaltyPoints\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LoyaltyPointForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('points_earned')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('points_redeemed')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
