<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\RevenueChartWidget;
use App\Filament\Widgets\SalesStatsWidget;
use App\Filament\Widgets\WaitlistStatsWidget;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard';
    protected static ?int $navigationSort = -2;

    protected static string $view = 'filament.pages.dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            RevenueChartWidget::class,
            SalesStatsWidget::class,
            WaitlistStatsWidget::class,
        ];
    }

    protected function getColumns(): int | string | array
    {
        return [
            'default' => 1,
            'sm' => 1,
            'md' => 1,
            'lg' => 1,
            'xl' => 1,
            '2xl' => 1,
        ];
    }
} 