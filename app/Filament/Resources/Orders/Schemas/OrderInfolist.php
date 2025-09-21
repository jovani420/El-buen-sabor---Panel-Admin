<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->numeric(),
                TextEntry::make('discount.id')
                    ->numeric(),
                TextEntry::make('status'),
                TextEntry::make('total_price')
                    ->numeric(),
                TextEntry::make('delivery_option'),
                TextEntry::make('delivery_address'),
                TextEntry::make('pickup_time')
                    ->time(),
                TextEntry::make('tracking_code'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
