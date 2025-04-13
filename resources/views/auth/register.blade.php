<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrarse - BiblioXis</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 2.5rem;
            width: 100%;
            max-width: 400px;
            margin: 1rem;
        }

        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .register-header img {
            width: 100px;
            height: 100px;
            margin-bottom: 1rem;
        }

        .register-header h2 {
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .register-header p {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            color: white;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            color: white;
            box-shadow: none;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .btn-register {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .login-link {
            text-align: center;
            margin-top: 1rem;
        }

        .login-link a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: white;
        }

        .back-to-home {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .back-to-home a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: opacity 0.3s ease;
        }

        .back-to-home a:hover {
            opacity: 0.8;
        }

        .error-message {
            color: #ff6b6b;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .password-requirements {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="back-to-home">
        <a href="{{ url('/') }}">
            <i class="bi bi-arrow-left"></i> Volver al inicio
        </a>
    </div>

    <div class="register-container">
        <div class="register-header">
            <img src="{{ asset('images/book-logo.svg') }}" alt="BiblioXis Logo">
            <h2>Crear Cuenta</h2>
            <p>Únete a BiblioXis y comienza a gestionar tus documentos</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Nombre</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
                <div class="password-requirements">
                    La contraseña debe tener al menos 8 caracteres
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-register">
                <i class="bi bi-person-plus me-2"></i> Registrarse
            </button>

            <div class="login-link">
                ¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
            </div>
        </form>
    </div>
</body>
</html>
