<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Commerce</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles -->
        <style>
            body {
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                margin: 0;
                padding: 0;
                display: flex;
                flex-direction: column;
                min-height: 100vh;
                background-color: #FDFDFC;
            }
            
            .dark body {
                background-color: #0a0a0a;
            }
            
            header {
                width: 100%;
                padding: 1rem;
                display: flex;
                justify-content: center;
                background-color: white;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }
            
            .dark header {
                background-color: #1a1a1a;
            }
            
            nav {
                display: flex;
                gap: 0.5rem;
                max-width: 1200px;
                width: 100%;
                justify-content: flex-end;
                padding: 0 1rem;
            }
            
            a {
                text-decoration: none;
                color: #1b1b18;
                padding: 0.5rem 1rem;
                border-radius: 0.25rem;
                font-size: 0.875rem;
                line-height: 1.5;
                white-space: nowrap;
            }
            
            .dark a {
                color: #EDEDEC;
            }
            
            a.border {
                border: 1px solid #19140035;
            }
            
            .dark a.border {
                border-color: #3E3E3A;
            }
            
            a:hover.border {
                border-color: #1915014a;
                background-color: #f8f8f8;
            }
            
            .dark a:hover.border {
                border-color: #62605b;
                background-color: #2a2a2a;
            }

            form {
                margin: 0;
            }

            button.sign-out {
                background: none;
                border: 1px solid #19140035;
                color: #1b1b18;
                padding: 0.5rem 1rem;
                border-radius: 0.25rem;
                font-size: 0.875rem;
                line-height: 1.5;
                cursor: pointer;
                font-family: inherit;
            }

            .dark button.sign-out {
                border-color: #3E3E3A;
                color: #EDEDEC;
            }

            button.sign-out:hover {
                border-color: #1915014a;
                background-color: #f8f8f8;
            }

            .dark button.sign-out:hover {
                border-color: #62605b;
                background-color: #2a2a2a;
            }
            
            .main-content {
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 2rem;
                gap: 1rem;
            }
            
            .center-text {
                font-size: 3rem;
                font-weight: 700;
                text-align: center;
                color: #1b1b18;
                margin: 0;
            }
            
            .dark .center-text {
                color: #EDEDEC;
            }

            .tagline {
                font-size: 1.25rem;
                font-weight: 500;
                text-align: center;
                color: #1b1b18;
                opacity: 0.8;
            }

            .dark .tagline {
                color: #EDEDEC;
            }

            .shop-button {
                background-color: #1b1b18;
                color: white;
                border: 1px solid #19140035;
                padding: 0.5rem 1rem;
                border-radius: 0.25rem;
                font-size: 0.875rem;
                font-weight: 500;
                cursor: pointer;
                text-decoration: none;
                display: inline-block;
                transition: all 0.2s ease;
            }

            .shop-button:hover {
                border-color: #1915014a;
                background-color: #f8f8f8;
                color: #1b1b18;
            }

            .dark .shop-button {
                background-color: #1a1a1a;
                border-color: #3E3E3A;
                color: #EDEDEC;
            }

            .dark .shop-button:hover {
                border-color: #62605b;
                background-color: #2a2a2a;
            }

            @media (max-width: 640px) {
                header {
                    padding: 0.5rem;
                }
                
                nav {
                    padding: 0 0.5rem;
                }
                
                a {
                    padding: 0.5rem 0.75rem;
                    font-size: 0.8125rem;
                }

                button.sign-out {
                    padding: 0.5rem 0.75rem;
                    font-size: 0.8125rem;
                }

                .center-text {
                    font-size: 2.5rem;
                }

                .tagline {
                    font-size: 1rem;
                }
            }
        </style>
    </head>
    <body>
        <header>
            @if (Route::has('login'))
                <nav>
                    @auth
                        <a href="{{ url('/admin') }}" class="border">
                            Dashboard
                        </a>
                        <a href="{{ route('filament.admin.resources.products.index') }}" class="border">
                            Products
                        </a>
                        <a href="{{ route('filament.admin.resources.inventories.index') }}" class="border">
                            Inventory
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <input type="hidden" name="redirect" value="{{ url('/') }}">
                            <button type="submit" class="sign-out">
                                Sign out
                            </button>
                        </form>
                    @else
                        <a href="{{ url('/admin/login') }}" class="border">
                            Sign in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="border">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
        
        <div class="main-content">
            <div class="center-text">
                <strong>Commerce</strong>
            </div>
            <div class="tagline">
                Your one-stop solution for managing products and inventory.
            </div>
            <a href="{{ route('products.index') }}" class="shop-button">
                Shop
            </a>
        </div>
    </body>
</html> 