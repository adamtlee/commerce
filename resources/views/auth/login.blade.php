<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login - Commerce</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <style>
            body {
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                margin: 0;
                padding: 0;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                background-color: #FDFDFC;
            }
            .dark body {
                background-color: #0a0a0a;
            }
            .container {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem;
            }
            .form-container {
                width: 100%;
                max-width: 400px;
                padding: 2rem;
                background: white;
                border-radius: 0.5rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }
            .dark .form-container {
                background: #1a1a1a;
            }
            h1 {
                margin: 0 0 1.5rem;
                font-size: 1.5rem;
                font-weight: 600;
                color: #1b1b18;
            }
            .dark h1 {
                color: #EDEDEC;
            }
            .form-group {
                margin-bottom: 1rem;
            }
            label {
                display: block;
                margin-bottom: 0.5rem;
                font-size: 0.875rem;
                font-weight: 500;
                color: #1b1b18;
            }
            .dark label {
                color: #EDEDEC;
            }
            input {
                width: 100%;
                padding: 0.5rem;
                border: 1px solid #19140035;
                border-radius: 0.25rem;
                font-size: 0.875rem;
                color: #1b1b18;
                background: white;
            }
            .dark input {
                border-color: #3E3E3A;
                color: #EDEDEC;
                background: #2a2a2a;
            }
            input:focus {
                outline: none;
                border-color: #1915014a;
            }
            .dark input:focus {
                border-color: #62605b;
            }
            button {
                width: 100%;
                padding: 0.5rem 1rem;
                background: #1b1b18;
                color: white;
                border: none;
                border-radius: 0.25rem;
                font-size: 0.875rem;
                font-weight: 500;
                cursor: pointer;
            }
            .dark button {
                background: #EDEDEC;
                color: #1b1b18;
            }
            button:hover {
                opacity: 0.9;
            }
            .links {
                margin-top: 1rem;
                text-align: center;
            }
            .links a {
                color: #1b1b18;
                text-decoration: none;
                font-size: 0.875rem;
            }
            .dark .links a {
                color: #EDEDEC;
            }
            .links a:hover {
                text-decoration: underline;
            }
            .error {
                color: #dc2626;
                font-size: 0.875rem;
                margin-top: 0.25rem;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="form-container">
                <h1>Login to Commerce</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        @error('password')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit">Log in</button>
                    <div class="links">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Don't have an account? Register</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </body>
</html> 