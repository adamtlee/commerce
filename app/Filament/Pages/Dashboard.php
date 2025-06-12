<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\RevenueChartWidget;
use App\Filament\Widgets\SalesStatsWidget;
use App\Filament\Widgets\TrendingProductsWidget;
use App\Filament\Widgets\WaitlistStatsWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard';
    protected static ?int $navigationSort = -2;

    public function getWidgets(): array
    {
        return [
            RevenueChartWidget::class,
            TrendingProductsWidget::class,
            SalesStatsWidget::class,
            WaitlistStatsWidget::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return [
            'default' => 1,
            'sm' => 1,
            'md' => 2,
            'lg' => 2,
            'xl' => 2,
            '2xl' => 2,
        ];
    }

    public function getHeaderWidgetsColumns(): int | string | array
    {
        return [
            'default' => 1,
            'sm' => 1,
            'md' => 2,
            'lg' => 2,
            'xl' => 2,
            '2xl' => 2,
        ];
    }
} 