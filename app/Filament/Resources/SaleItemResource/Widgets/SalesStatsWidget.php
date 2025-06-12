<?php

namespace App\Filament\Resources\SaleItemResource\Widgets;

use App\Models\SaleItem;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalSold = SaleItem::sum('quantity');
        $totalRevenue = SaleItem::sum('total_price');
        $averageOrderValue = $totalSold > 0 ? $totalRevenue / SaleItem::count() : 0;

        return [
            Stat::make('Total Items Sold', number_format($totalSold))
                ->description('Total quantity of items sold')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('success'),
            
            Stat::make('Total Revenue', '$' . number_format($totalRevenue, 2))
                ->description('Total revenue from sales')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
            
            Stat::make('Average Order Value', '$' . number_format($averageOrderValue, 2))
                ->description('Average value per order')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('success'),
        ];
    }
}
