<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Commerce</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8fafc;
            color: #1f2937;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .header p {
            font-size: 1.1rem;
            color: #6b7280;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background-color: #f3f4f6;
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .product-sku {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.75rem;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #059669;
            margin-bottom: 1rem;
        }

        .product-description {
            color: #4b5563;
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .inventory-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #e5e7eb;
            font-size: 0.875rem;
        }

        .stock-status {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-weight: 500;
        }

        .in-stock {
            background-color: #dcfce7;
            color: #166534;
        }

        .low-stock {
            background-color: #fef3c7;
            color: #92400e;
        }

        .out-of-stock {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .location {
            color: #6b7280;
        }

        .no-products {
            text-align: center;
            padding: 4rem 2rem;
            color: #6b7280;
        }

        .no-products h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1rem;
            }

            .header h1 {
                font-size: 2rem;
            }
        }
    </style>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body x-data="{ open: false, selectedProduct: null }">
    <div class="container">
        <div class="header">
            <h1>Our Products</h1>
            <p>Discover our collection of high-quality products</p>
        </div>

        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center;">
                {{ session('success') }}
            </div>
        @endif

        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                        @else
                            <div class="product-image" style="display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                <span>No Image</span>
                            </div>
                        @endif
                        <div class="product-info">
                            <h2 class="product-name">{{ $product->name }}</h2>
                            <p class="product-sku">SKU: {{ $product->sku }}</p>
                            <div class="product-price">${{ number_format($product->price, 2) }}</div>
                            <p class="product-description">{{ strip_tags($product->description) }}</p>
                            @if($product->inventory)
                                <div class="inventory-info">
                                    @php
                                        $quantity = $product->inventory->quantity;
                                        $securityStock = $product->inventory->security_stock;
                                        if ($quantity > $securityStock) {
                                            $stockClass = 'in-stock';
                                            $stockText = 'In Stock';
                                        } elseif ($quantity > 0) {
                                            $stockClass = 'low-stock';
                                            $stockText = 'Low Stock';
                                        } else {
                                            $stockClass = 'out-of-stock';
                                            $stockText = 'Out of Stock';
                                        }
                                    @endphp
                                    <span class="stock-status {{ $stockClass }}">{{ $stockText }}</span>
                                    <span class="location">{{ $product->inventory->location }}</span>
                                </div>
                            @endif
                            <button type="button" @click="selectedProduct = { id: {{ $product->id }}, name: '{{ addslashes($product->name) }}' }; open = true" style="margin-top: 1rem; background: #2563eb; color: white; border: none; padding: 0.5rem 1.5rem; border-radius: 6px; font-weight: 600; cursor: pointer;">Order</button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-products">
                <h2>No products available.</h2>
                <p>Please check back later.</p>
            </div>
        @endif

        <!-- Single Modal at Page Level -->
        <div 
            x-show="open" 
            x-cloak
            style="
                position: fixed; 
                inset: 0; 
                background: rgba(31,41,55,0.5); 
                display: flex; 
                align-items: center; 
                justify-content: center; 
                z-index: 1000;
            "
        >
            <div 
                style="
                    background: white; 
                    border-radius: 12px; 
                    padding: 2rem; 
                    width: 100%; 
                    max-width: 400px; 
                    box-shadow: 0 10px 25px -3px rgba(0,0,0,0.1); 
                    position: relative;
                    margin: 0 auto;
                    display: flex;
                    flex-direction: column;
                "
            >
                <button @click="open = false" style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; font-size: 1.5rem; color: #6b7280; cursor: pointer;">&times;</button>
                <template x-if="selectedProduct">
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem;">Order <span x-text="selectedProduct.name"></span></h3>
                </template>
                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf
                    <input type="hidden" name="product_id" :value="selectedProduct ? selectedProduct.id : ''">
                    <div style="margin-bottom: 0.75rem;">
                        <label>First Name</label>
                        <input type="text" name="first_name" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px;">
                    </div>
                    <div style="margin-bottom: 0.75rem;">
                        <label>Last Name</label>
                        <input type="text" name="last_name" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px;">
                    </div>
                    <div style="margin-bottom: 0.75rem;">
                        <label>Email</label>
                        <input type="email" name="email" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px;">
                    </div>
                    <div style="margin-bottom: 0.75rem;">
                        <label>Phone <span style="color: #9ca3af; font-size: 0.85em;">(optional)</span></label>
                        <input type="text" name="phone" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px;">
                    </div>
                    <div style="margin-bottom: 0.75rem;">
                        <label>Address</label>
                        <input type="text" name="address" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px;">
                    </div>
                    <div style="margin-bottom: 1rem;">
                        <label>Note <span style="color: #9ca3af; font-size: 0.85em;">(optional)</span></label>
                        <textarea name="note" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px;"></textarea>
                    </div>
                    <button type="submit" style="background: #059669; color: white; border: none; padding: 0.5rem 1.5rem; border-radius: 6px; font-weight: 600; cursor: pointer; width: 100%;">Submit Order</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 