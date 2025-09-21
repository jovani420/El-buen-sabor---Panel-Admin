<?php

namespace App\Filament\Resources\LoyaltyPoints\Pages;

use App\Filament\Resources\LoyaltyPoints\LoyaltyPointResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLoyaltyPoint extends EditRecord
{
    protected static string $resource = LoyaltyPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
