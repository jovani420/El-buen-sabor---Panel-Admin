<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\Carbon; // Asegúrate de importar Carbon
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrdersChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $maxHeight = '200px'; // SIN static
    protected ?string $heading = 'Pedidos de los Últimos 7 Días'; // SIN static

    protected function getData(): array
    {
        $data = Trend::model(Order::class)
            ->between(
                start: now()->subDays(6),
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Pedidos',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('M d')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}