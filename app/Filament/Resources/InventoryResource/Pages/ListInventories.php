<?php

namespace App\Filament\Resources\InventoryResource\Pages;

use App\Filament\Resources\InventoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInventories extends ListRecords
{
    protected static string $resource = InventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('exportInventories')
                ->label('Export Inventories')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalHeading('Export Inventories')
                ->modalDescription('Download a CSV file of all inventory items.')
                ->modalButton('Export')
                ->action(function () {
                    return self::exportInventoriesCsv();
                }),
        ];
    }

    public static function exportInventoriesCsv()
    {
        $inventories = \App\Models\Inventory::with('product')->get();
        $headers = [
            'product_id', 'product_name', 'barcode', 'quantity', 'security_stock', 'location', 'last_updated',
        ];
        $rows = [];
        foreach ($inventories as $inventory) {
            $rows[] = [
                $inventory->product_id,
                $inventory->product ? $inventory->product->name : '',
                $inventory->barcode,
                $inventory->quantity,
                $inventory->security_stock,
                $inventory->location,
                $inventory->last_updated,
            ];
        }
        $filename = 'inventories_export_' . now()->format('Ymd_His') . '.csv';
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
