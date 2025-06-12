<?php

namespace App\Filament\Widgets;

use App\Models\SaleItem;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RevenueChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Revenue Over Time';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = [
        'default' => 2,
        'sm' => 2,
        'md' => 2,
        'lg' => 2,
        'xl' => 2,
        '2xl' => 2,
    ];

    protected function getData(): array
    {
        $data = SaleItem::selectRaw('DATE(sale_date) as date, SUM(total_price) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Daily Revenue',
                    'data' => $data->pluck('revenue')->toArray(),
                    'borderColor' => '#10B981',
                    'backgroundColor' => '#10B981',
                    'fill' => false,
                ],
            ],
            'labels' => $data->pluck('date')->map(function ($date) {
                return Carbon::parse($date)->format('M d, Y');
            })->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) { return "$" + value.toLocaleString(); }',
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
        ];
    }
} 