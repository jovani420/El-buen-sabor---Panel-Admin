<?php

namespace App\Filament\Resources\LoyaltyPoints;

use App\Filament\Resources\LoyaltyPoints\Pages\CreateLoyaltyPoint;
use App\Filament\Resources\LoyaltyPoints\Pages\EditLoyaltyPoint;
use App\Filament\Resources\LoyaltyPoints\Pages\ListLoyaltyPoints;
use App\Filament\Resources\LoyaltyPoints\Pages\ViewLoyaltyPoint;
use App\Filament\Resources\LoyaltyPoints\Schemas\LoyaltyPointForm;
use App\Filament\Resources\LoyaltyPoints\Schemas\LoyaltyPointInfolist;
use App\Filament\Resources\LoyaltyPoints\Tables\LoyaltyPointsTable;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;
use App\Models\LoyaltyPoint;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LoyaltyPointResource extends Resource
{
    protected static ?string $model = LoyaltyPoint::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'LoyaltyPoint';

    public static function form(Schema $schema): Schema
    {
         return $schema
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('points_earned')->required()->numeric()->default(0),
                TextInput::make('points_redeemed')->required()->numeric()->default(0),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LoyaltyPointInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
           return $table
            ->columns([
                TextColumn::make('user.name')->searchable(),
                TextColumn::make('points_earned')->label('Puntos Obtenidos')->sortable(),
                TextColumn::make('points_redeemed')->label('Puntos Canjeados')->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
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
            'index' => ListLoyaltyPoints::route('/'),
            'create' => CreateLoyaltyPoint::route('/create'),
            'view' => ViewLoyaltyPoint::route('/{record}'),
            'edit' => EditLoyaltyPoint::route('/{record}/edit'),
        ];
    }
}
