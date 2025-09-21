<?php

namespace App\Filament\Resources\Addons\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AddonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('$'),
            ]);
    }
}
