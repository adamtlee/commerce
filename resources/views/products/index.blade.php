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
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Our Products</h1>
            <p>Discover our collection of high-quality products</p>
        </div>

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
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-products">
                <h2>No Products Available</h2>
                <p>We're currently updating our product catalog. Please check back soon!</p>
            </div>
        @endif
    </div>
</body>
</html> 