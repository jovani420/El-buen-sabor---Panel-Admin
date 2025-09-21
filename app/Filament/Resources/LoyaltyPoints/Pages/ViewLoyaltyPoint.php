<?php

namespace App\Filament\Resources\LoyaltyPoints\Pages;

use App\Filament\Resources\LoyaltyPoints\LoyaltyPointResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLoyaltyPoint extends ViewRecord
{
    protected static string $resource = LoyaltyPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
