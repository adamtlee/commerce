<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('exportOrders')
                ->label('Export Orders')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalHeading('Export Orders')
                ->modalDescription('Download a CSV file of all orders.')
                ->modalButton('Export')
                ->action(function () {
                    return self::exportOrdersCsv();
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // Add a widget to show new order notifications
        ];
    }

    public function mount(): void
    {
        parent::mount();
        
        // Check for new orders and show notification
        $newOrdersCount = \App\Models\Order::where('status', 'pending')->count();
        if ($newOrdersCount > 0) {
            Notification::make()
                ->title("You have {$newOrdersCount} pending order(s)")
                ->body("Click here to review new orders")
                ->warning()
                ->persistent()
                ->send();
        }
    }

    public static function exportOrdersCsv()
    {
        $orders = \App\Models\Order::with('product')->get();
        $headers = [
            'id', 'product', 'first_name', 'last_name', 'email', 'phone', 'address', 'note', 'status', 'user_id', 'created_at', 'updated_at',
        ];
        $rows = [];
        foreach ($orders as $order) {
            $rows[] = [
                $order->id,
                $order->product ? $order->product->name : '',
                $order->first_name,
                $order->last_name,
                $order->email,
                $order->phone,
                $order->address,
                $order->note,
                $order->status,
                $order->user_id,
                $order->created_at,
                $order->updated_at,
            ];
        }
        $filename = 'orders_export_' . now()->format('Ymd_His') . '.csv';
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
