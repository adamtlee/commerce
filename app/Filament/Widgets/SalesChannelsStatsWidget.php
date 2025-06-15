<?php

namespace App\Filament\Widgets;

use App\Models\SalesChannel;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesChannelsStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Sales Channels', SalesChannel::count())
                ->description('Active sales channels in the system')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('success'),
        ];
    }
} 