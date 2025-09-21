<?php

namespace App\Filament\Resources\Addons;

use App\Filament\Resources\Addons\Pages\CreateAddon;
use App\Filament\Resources\Addons\Pages\EditAddon;
use App\Filament\Resources\Addons\Pages\ListAddons;
use App\Filament\Resources\Addons\Pages\ViewAddon;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\Addons\Schemas\AddonForm;
use App\Filament\Resources\Addons\Schemas\AddonInfolist;
use App\Filament\Resources\Addons\Tables\AddonsTable;
use App\Models\Addon;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class AddonResource extends Resource
{
    protected static ?string $model = Addon::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Addon';

    public static function form(Schema $schema): Schema
    {
         return $schema
            ->schema([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('price')->required()->numeric()->prefix('$'),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AddonInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('price')->money('usd')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAddons::route('/'),
            'create' => CreateAddon::route('/create'),
            'view' => ViewAddon::route('/{record}'),
            'edit' => EditAddon::route('/{record}/edit'),
        ];
    }
}
