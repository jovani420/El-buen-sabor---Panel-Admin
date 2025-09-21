<?php

namespace App\Filament\Resources\Addons\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AddonInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('price')
                    ->money(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
