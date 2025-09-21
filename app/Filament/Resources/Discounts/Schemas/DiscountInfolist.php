<?php

namespace App\Filament\Resources\Discounts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DiscountInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('code'),
                TextEntry::make('value')
                    ->numeric(),
                TextEntry::make('type'),
                TextEntry::make('expires_at')
                    ->date(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
