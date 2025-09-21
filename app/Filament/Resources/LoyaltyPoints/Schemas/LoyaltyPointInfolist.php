<?php

namespace App\Filament\Resources\LoyaltyPoints\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LoyaltyPointInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->numeric(),
                TextEntry::make('points_earned')
                    ->numeric(),
                TextEntry::make('points_redeemed')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
