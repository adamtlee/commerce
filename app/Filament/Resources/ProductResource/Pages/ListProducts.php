<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('importProducts')
                ->label('Import Products')
                ->icon('heroicon-o-arrow-down-tray')
                ->modalHeading('Import Products from CSV')
                ->form([
                    \Filament\Forms\Components\FileUpload::make('csv_file')
                        ->label('CSV File')
                        ->acceptedFileTypes(['text/csv', 'application/vnd.ms-excel', '.csv'])
                        ->required(),
                ])
                ->action(function (array $data) {
                    // Handler will be implemented in a controller or service
                    \App\Filament\Resources\ProductResource\Pages\ListProducts::handleCsvImport($data['csv_file']);
                })
                ->modalButton('Import'),
            Actions\Action::make('exportProducts')
                ->label('Export Products')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalHeading('Export Products and Inventory')
                ->modalDescription('Download a CSV file of all products and their inventory.')
                ->modalButton('Export')
                ->action(function () {
                    return self::exportProductsCsv();
                }),
        ];
    }

    public static function handleCsvImport($csvFilePath)
    {
        $storagePath = storage_path('app/public/' . $csvFilePath);
        if (!file_exists($storagePath)) {
            \Filament\Notifications\Notification::make()
                ->title('CSV file not found.')
                ->danger()
                ->send();
            return;
        }

        $handle = fopen($storagePath, 'r');
        if ($handle === false) {
            \Filament\Notifications\Notification::make()
                ->title('Unable to open CSV file.')
                ->danger()
                ->send();
            return;
        }

        $header = fgetcsv($handle);
        $imported = 0;
        $errors = [];
        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);
            try {
                $product = \App\Models\Product::create([
                    'sku' => $data['sku'],
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'price' => $data['price'],
                ]);
                $product->inventory()->create([
                    'barcode' => $data['inventory_barcode'] ?? null,
                    'quantity' => $data['inventory_quantity'] ?? 0,
                    'security_stock' => $data['inventory_security_stock'] ?? 0,
                    'location' => $data['inventory_location'] ?? '',
                    'last_updated' => now(),
                ]);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = $data['sku'] ?? 'Unknown SKU' . ': ' . $e->getMessage();
            }
        }
        fclose($handle);

        if ($imported > 0) {
            \Filament\Notifications\Notification::make()
                ->title("Imported {$imported} products successfully.")
                ->success()
                ->send();
        }
        if (!empty($errors)) {
            \Filament\Notifications\Notification::make()
                ->title('Some products could not be imported:')
                ->body(implode("\n", $errors))
                ->danger()
                ->send();
        }
    }

    public static function exportProductsCsv()
    {
        $products = \App\Models\Product::with('inventory')->get();
        $headers = [
            'sku', 'name', 'description', 'price',
            'inventory_barcode', 'inventory_quantity', 'inventory_security_stock', 'inventory_location',
        ];
        $rows = [];
        foreach ($products as $product) {
            $rows[] = [
                $product->sku,
                $product->name,
                $product->description,
                $product->price,
                $product->inventory->barcode ?? '',
                $product->inventory->quantity ?? '',
                $product->inventory->security_stock ?? '',
                $product->inventory->location ?? '',
            ];
        }
        $filename = 'products_export_' . now()->format('Ymd_His') . '.csv';
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
