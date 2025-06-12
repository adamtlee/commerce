<?php

namespace App\Filament\Widgets;

use App\Models\Waitlist;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WaitlistStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalWaitlisted = Waitlist::sum('requested_quantity');
        $pendingWaitlisted = Waitlist::where('status', 'pending')->sum('requested_quantity');
        $notifiedWaitlisted = Waitlist::where('status', 'notified')->sum('requested_quantity');

        return [
            Stat::make('Total Waitlisted Items', number_format($totalWaitlisted))
                ->description('Total quantity of items waitlisted')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            
            Stat::make('Pending Waitlist Items', number_format($pendingWaitlisted))
                ->description('Items still waiting to be notified')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            
            Stat::make('Notified Waitlist Items', number_format($notifiedWaitlisted))
                ->description('Items that have been notified')
                ->descriptionIcon('heroicon-m-bell')
                ->color('success'),
        ];
    }
} 