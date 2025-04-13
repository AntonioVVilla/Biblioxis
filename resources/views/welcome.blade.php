<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BiblioXis - Tu gestor de documentos PDF y EPUB</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .nav-buttons {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .nav-buttons .btn {
            margin-left: 10px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            transition: all 0.3s ease;
        }

        .nav-buttons .btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .main-content {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 3rem;
        }

        .logo-container img {
            width: 150px;
            height: 150px;
            margin-bottom: 1rem;
        }

        .logo-container h1 {
            color: white;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .features-container {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 2rem;
            width: 300px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-card i {
            font-size: 2.5rem;
            color: white;
            margin-bottom: 1rem;
        }

        .feature-card h3 {
            color: white;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: rgba(255, 255, 255, 0.8);
        }
    </style>
</head>
<body>
    <div class="nav-buttons">
        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="btn">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn">
                    <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn">
                        <i class="bi bi-person-plus"></i> Registrarse
                    </a>
                @endif
            @endauth
        @endif
    </div>

    <div class="main-content">
        <div class="logo-container">
            <img src="{{ asset('images/book-logo.svg') }}" alt="BiblioXis Logo">
            <h1>BiblioXis</h1>
        </div>

        <div class="features-container">
            <div class="feature-card">
                <i class="bi bi-file-earmark-pdf"></i>
                <h3>Visualización PDF</h3>
                <p>Visualiza tus documentos PDF de forma rápida y segura</p>
            </div>
            <div class="feature-card">
                <i class="bi bi-book"></i>
                <h3>Soporte EPUB</h3>
                <p>Lee tus libros electrónicos directamente en el navegador</p>
            </div>
            <div class="feature-card">
                <i class="bi bi-shield-lock"></i>
                <h3>Seguridad</h3>
                <p>Tus documentos están protegidos y solo tú puedes acceder a ellos</p>
            </div>
        </div>
    </div>
</body>
</html>
