<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Storeloc Test - @yield('title', 'Recherche de magasins')</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                line-height: 1.6;
                color: #333;
                background: #f5f5f5;
            }

            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }

            .header {
                background: white;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                margin-bottom: 30px;
            }

            .header-content {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .logo {
                font-size: 1.5em;
                font-weight: bold;
                color: #007bff;
                text-decoration: none;
            }

            .nav {
                display: flex;
                gap: 20px;
            }

            .nav a {
                color: #666;
                text-decoration: none;
                padding: 8px 16px;
                border-radius: 4px;
                transition: background 0.3s ease;
            }

            .nav a:hover {
                background: #f0f0f0;
            }

            .main-content {
                min-height: calc(100vh - 200px);
            }

            .footer {
                background: white;
                border-top: 1px solid #eee;
                padding: 20px 0;
                margin-top: 50px;
                text-align: center;
                color: #666;
            }

            @media (max-width: 768px) {
                .header-content {
                    flex-direction: column;
                    gap: 15px;
                }

                .nav {
                    flex-wrap: wrap;
                    justify-content: center;
                }
            }
        </style>
        @yield('styles')
    </head>
    <body>
        <header class="header">
            <div class="header-content">
                <a href="{{ route('index') }}" class="logo">Store Locator</a>
                <nav class="nav">
                    <a href="{{ route('index') }}">Recherche</a>
                </nav>
            </div>
        </header>

        <main class="main-content">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </body>
</html>
