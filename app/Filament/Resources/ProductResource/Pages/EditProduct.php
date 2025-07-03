<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $inventory = $this->record->inventory;
        if ($inventory) {
            $data['inventory'] = [
                'barcode' => $inventory->barcode,
                'quantity' => $inventory->quantity,
                'security_stock' => $inventory->security_stock,
                'location' => $inventory->location,
            ];
        }
        return $data;
    }
}
