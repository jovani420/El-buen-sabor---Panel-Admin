<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages\CreateOrder;
use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Pages\ViewOrder;
use App\Filament\Resources\Orders\Schemas\OrderForm;
use App\Filament\Resources\Orders\Schemas\OrderInfolist;
use App\Filament\Resources\Orders\Tables\OrdersTable;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Order';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('status')
                    ->options([
                        'pending' => 'Pendiente',
                        'processing' => 'En Proceso',
                        'ready' => 'Listo para Recoger/Enviar',
                        'completed' => 'Completado',
                    ])
                    ->required(),
                TextInput::make('tracking_code')->required()->maxLength(255),
                TextInput::make('total_price')->required()->numeric()->disabled()->prefix('$'),
                Select::make('delivery_option')
                    ->options([
                        'pickup' => 'Recoger en Tienda',
                        'delivery' => 'Pedido a Domicilio',
                    ])
                    ->required(),
                TextInput::make('delivery_address')
                    ->visible(fn ($get) => $get('delivery_option') === 'delivery'),
                TextInput::make('pickup_time')
                    ->visible(fn ($get) => $get('delivery_option') === 'pickup'),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OrderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
         return $table
            ->columns([
                TextColumn::make('tracking_code')->searchable(),
                TextColumn::make('user.name'),
                BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'pending',
                        'warning' => 'processing',
                        'success' => 'ready',
                        'info' => 'completed',
                    ]),
                TextColumn::make('total_price')->money('usd')->sortable(),
                TextColumn::make('delivery_option')
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
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'view' => ViewOrder::route('/{record}'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
}
