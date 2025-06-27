<?php

namespace App\Filament\Resources\SaleItemResource\Pages;

use App\Filament\Resources\SaleItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Widgets\Widget;

class ListSaleItems extends ListRecords
{
    protected static string $resource = SaleItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('exportSaleItems')
                ->label('Export Sales Items')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalHeading('Export Sales Items')
                ->modalDescription('Download a CSV file of all sales items.')
                ->modalButton('Export')
                ->action(function () {
                    return self::exportSaleItemsCsv();
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\SalesStatsWidget::class,
        ];
    }

    public static function exportSaleItemsCsv()
    {
        $saleItems = \App\Models\SaleItem::with(['product', 'channel'])->get();
        $headers = [
            'sale_id', 'channel', 'product_name', 'product_sku', 'quantity', 'unit_price', 'total_price', 'sale_date',
        ];
        $rows = [];
        foreach ($saleItems as $item) {
            $rows[] = [
                $item->sale_id,
                $item->channel ? $item->channel->name : '',
                $item->product_name,
                $item->product_sku,
                $item->quantity,
                $item->unit_price,
                $item->total_price,
                $item->sale_date,
            ];
        }
        $filename = 'sales_items_export_' . now()->format('Ymd_His') . '.csv';
        $filepath = storage_path('app/public/' . $filename);
        $handle = fopen($filepath, 'w');
        fputcsv($handle, $headers);
        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
        return response()->download($filepath)->deleteFileAfterSend();
    }
}
