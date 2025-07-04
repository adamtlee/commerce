<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Product Image -->
        <div>
            @if($product->image)
                <img src="{{ Storage::url($product->image) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-64 object-cover rounded-lg">
            @else
                <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500">No image available</span>
                </div>
            @endif
        </div>

        <!-- Product Information -->
        <div class="space-y-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ $product->name }}</h3>
                <p class="text-sm text-gray-500">SKU: {{ $product->sku }}</p>
            </div>

            <div>
                <span class="text-2xl font-bold text-green-600">${{ number_format($product->price, 2) }}</span>
            </div>

            <div>
                <h4 class="font-medium text-gray-900 mb-2">Description</h4>
                <div class="prose prose-sm max-w-none">
                    {!! $product->description !!}
                </div>
            </div>

            <!-- Inventory Information -->
            @if($product->inventory)
                <div class="border-t pt-4">
                    <h4 class="font-medium text-gray-900 mb-3">Inventory</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Quantity:</span>
                            <span class="font-medium">{{ $product->inventory->quantity }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Security Stock:</span>
                            <span class="font-medium">{{ $product->inventory->security_stock }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Location:</span>
                            <span class="font-medium">{{ $product->inventory->location }}</span>
                        </div>
                        @if($product->inventory->barcode)
                            <div>
                                <span class="text-gray-500">Barcode:</span>
                                <span class="font-medium">{{ $product->inventory->barcode }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Timestamps -->
            <div class="border-t pt-4 text-xs text-gray-500">
                <p>Created: {{ $product->created_at->format('M d, Y H:i') }}</p>
                <p>Updated: {{ $product->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>
</div> 