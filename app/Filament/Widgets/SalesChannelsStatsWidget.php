<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\SalesChannel;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesChannelsStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Products', Product::count())
                ->description('Products in the system')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),
                
            Stat::make('Total Sales Channels', SalesChannel::count())
                ->description('Active sales channels')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('success'),
        ];
    }
} 