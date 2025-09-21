<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';
    protected function getStats(): array
    {
          // Contamos los pedidos que están en estado 'pending'
        $pendingOrders = Order::where('status', 'pending')->count();
        
        // Sumamos el total de los precios de todos los pedidos
        $totalSales = Order::sum('total_price');

        return [
            Stat::make('Pedidos Pendientes', $pendingOrders)
                ->description('Órdenes en espera de ser preparadas')
                ->icon('heroicon-o-clock')
                ->color('warning'),
            
            Stat::make('Ventas Totales', '$' . number_format($totalSales, 2))
                ->description('Ganancias totales hasta la fecha')
                ->icon('heroicon-o-currency-dollar')
                ->color('success'),
        ];
    }
}
