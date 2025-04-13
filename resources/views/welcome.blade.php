<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VisorDocs - Tu gestor de documentos PDF y EPUB</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .bubbles-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        
        .bubble {
            position: absolute;
            bottom: -100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: bubble 15s linear infinite;
        }
        
        .bubble:nth-child(1) { width: 80px; height: 80px; left: 5%; animation-duration: 7s; }
        .bubble:nth-child(2) { width: 60px; height: 60px; left: 15%; animation-duration: 8s; animation-delay: 1s; }
        .bubble:nth-child(3) { width: 100px; height: 100px; left: 30%; animation-duration: 11s; animation-delay: 2s; }
        .bubble:nth-child(4) { width: 50px; height: 50px; left: 45%; animation-duration: 6s; animation-delay: 0s; }
        .bubble:nth-child(5) { width: 70px; height: 70px; left: 60%; animation-duration: 9s; animation-delay: 1s; }
        .bubble:nth-child(6) { width: 90px; height: 90px; left: 75%; animation-duration: 10s; animation-delay: 3s; }
        .bubble:nth-child(7) { width: 40px; height: 40px; left: 90%; animation-duration: 8s; animation-delay: 2s; }
        
        @keyframes bubble {
            0% { bottom: -100px; transform: translateX(0); }
            50% { transform: translateX(100px); }
            100% { bottom: 1080px; transform: translateX(-200px); }
        }

        .content-wrapper {
            position: relative;
            z-index: 2;
            color: white;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .btn-custom {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="bubbles-container">
            <span class="bubble"></span>
            <span class="bubble"></span>
            <span class="bubble"></span>
            <span class="bubble"></span>
            <span class="bubble"></span>
            <span class="bubble"></span>
            <span class="bubble"></span>
        </div>

        <div class="container content-wrapper">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <img src="{{ asset('images/book-logo.svg') }}" alt="VisorDocs Logo" class="mb-4" style="width: 120px; height: 120px;">
                    <h1 class="display-4 fw-bold mb-4">VisorDocs</h1>
                    <p class="lead mb-5">Tu gestor de documentos PDF y EPUB en la nube</p>
                    
                    <div class="d-flex justify-content-center gap-3 mb-5">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-custom btn-lg">
                                    <i class="bi bi-speedometer2 me-2"></i>Ir al Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-custom btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-custom btn-lg">
                                        <i class="bi bi-person-plus me-2"></i>Registrarse
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-4 mb-4">
                    <div class="feature-card p-4 rounded-4 text-center">
                        <i class="bi bi-file-earmark-pdf display-4 mb-3"></i>
                        <h3>Visualización PDF</h3>
                        <p>Visualiza tus documentos PDF de forma rápida y segura</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card p-4 rounded-4 text-center">
                        <i class="bi bi-book display-4 mb-3"></i>
                        <h3>Soporte EPUB</h3>
                        <p>Lee tus libros electrónicos directamente en el navegador</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card p-4 rounded-4 text-center">
                        <i class="bi bi-shield-lock display-4 mb-3"></i>
                        <h3>Seguridad</h3>
                        <p>Tus documentos están protegidos y solo tú puedes acceder a ellos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
