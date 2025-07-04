<?php

namespace App\Filament\Resources\SalesChannelResource\Pages;

use App\Filament\Resources\SalesChannelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSalesChannels extends ListRecords
{
    protected static string $resource = SalesChannelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('exportSalesChannels')
                ->label('Export Sales Channels')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalHeading('Export Sales Channels')
                ->modalDescription('Download a CSV file of all sales channels.')
                ->modalButton('Export')
                ->action(function () {
                    return self::exportSalesChannelsCsv();
                }),
            Actions\Action::make('importSalesChannels')
                ->label('Import Sales Channels')
                ->icon('heroicon-o-arrow-down-tray')
                ->modalHeading('Import Sales Channels from CSV')
                ->form([
                    \Filament\Forms\Components\FileUpload::make('csv_file')
                        ->label('CSV File')
                        ->acceptedFileTypes(['text/csv', 'application/vnd.ms-excel', '.csv'])
                        ->required(),
                ])
                ->action(function (array $data) {
                    self::handleCsvImport($data['csv_file']);
                })
                ->modalButton('Import'),
        ];
    }

    public static function exportSalesChannelsCsv()
    {
        $channels = \App\Models\SalesChannel::all();
        $headers = [
            'id', 'name', 'code', 'description', 'type', 'status', 'settings', 'created_at', 'updated_at',
        ];
        $rows = [];
        foreach ($channels as $channel) {
            $rows[] = [
                $channel->id,
                $channel->name,
                $channel->code,
                $channel->description,
                $channel->type,
                $channel->status,
                is_array($channel->settings) ? json_encode($channel->settings) : $channel->settings,
                $channel->created_at,
                $channel->updated_at,
            ];
        }
        $filename = 'sales_channels_export_' . now()->format('Ymd_His') . '.csv';
        $filepath = storage_path('app/public/' . $filename);
        $handle = fopen($filepath, 'w');
        fputcsv($handle, $headers);
        foreach ($rows as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
        return response()->download($filepath)->deleteFileAfterSend();
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
                \App\Models\SalesChannel::create([
                    'name' => $data['name'] ?? '',
                    'code' => $data['code'] ?? '',
                    'description' => $data['description'] ?? '',
                    'type' => $data['type'] ?? '',
                    'status' => $data['status'] ?? '',
                    'settings' => isset($data['settings']) ? json_decode($data['settings'], true) : null,
                ]);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = ($data['code'] ?? 'Unknown Code') . ': ' . $e->getMessage();
            }
        }
        fclose($handle);

        if ($imported > 0) {
            \Filament\Notifications\Notification::make()
                ->title("Imported {$imported} sales channels successfully.")
                ->success()
                ->send();
        }
        if (!empty($errors)) {
            \Filament\Notifications\Notification::make()
                ->title('Some sales channels could not be imported:')
                ->body(implode("\n", $errors))
                ->danger()
                ->send();
        }
    }
} 