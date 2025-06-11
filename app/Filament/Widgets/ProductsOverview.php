<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Products', Product::count())
                ->description('Total number of products in the system')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('success'),
        ];
    }
} 