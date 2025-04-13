<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - BiblioXis</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bubbles-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        
        .bubble {
            position: absolute;
            bottom: -100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: bubble 15s linear infinite;
        }
        
        .bubble:nth-child(1) {
            width: 80px;
            height: 80px;
            left: 5%;
            animation-duration: 7s;
        }
        
        .bubble:nth-child(2) {
            width: 60px;
            height: 60px;
            left: 15%;
            animation-duration: 8s;
            animation-delay: 1s;
        }
        
        .bubble:nth-child(3) {
            width: 100px;
            height: 100px;
            left: 30%;
            animation-duration: 11s;
            animation-delay: 2s;
        }
        
        .bubble:nth-child(4) {
            width: 50px;
            height: 50px;
            left: 45%;
            animation-duration: 6s;
            animation-delay: 0s;
        }
        
        .bubble:nth-child(5) {
            width: 70px;
            height: 70px;
            left: 60%;
            animation-duration: 9s;
            animation-delay: 1s;
        }
        
        .bubble:nth-child(6) {
            width: 90px;
            height: 90px;
            left: 75%;
            animation-duration: 10s;
            animation-delay: 3s;
        }
        
        .bubble:nth-child(7) {
            width: 40px;
            height: 40px;
            left: 90%;
            animation-duration: 8s;
            animation-delay: 2s;
        }
        
        @keyframes bubble {
            0% {
                bottom: -100px;
                transform: translateX(0);
            }
            50% {
                transform: translateX(100px);
            }
            100% {
                bottom: 1080px;
                transform: translateX(-200px);
            }
        }
    </style>
</head>
<body class="antialiased">
    <div class="bubbles-container">
        <span class="bubble"></span>
        <span class="bubble"></span>
        <span class="bubble"></span>
        <span class="bubble"></span>
        <span class="bubble"></span>
        <span class="bubble"></span>
        <span class="bubble"></span>
    </div>

    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center">
                            <img src="{{ asset('images/book-logo.svg') }}" alt="BiblioXis Logo" class="h-8 w-8">
                            <span class="ml-2 text-xl font-semibold text-gray-800">BiblioXis</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-app-layout>
                    <x-slot name="header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="mb-0">Dashboard</h2>
                        </div>
                    </x-slot>

                    <div class="container py-4 position-relative">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card hover-card bg-primary text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="bi bi-file-earmark-text me-2"></i>
                                            Documentos
                                        </h5>
                                        <p class="card-text display-4">{{ $totalDocumentos }}</p>
                                        <a href="{{ route('documentos.index') }}" class="btn btn-light">
                                            Ver Documentos
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="card hover-card bg-success text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="bi bi-file-earmark-pdf me-2"></i>
                                            PDFs
                                        </h5>
                                        <p class="card-text display-4">{{ $totalPdfs }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <div class="card hover-card bg-info text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="bi bi-book me-2"></i>
                                            EPUBs
                                        </h5>
                                        <p class="card-text display-4">{{ $totalEpubs }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card hover-card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="bi bi-clock-history me-2"></i>
                                            Documentos Recientes
                                        </h5>
                                        <div class="list-group">
                                            @forelse($documentosRecientes as $doc)
                                                <a href="{{ route('documentos.show', $doc) }}" class="list-group-item list-group-item-action">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <h6 class="mb-1">{{ $doc->titulo }}</h6>
                                                        <small class="text-muted">{{ $doc->created_at->diffForHumans() }}</small>
                                                    </div>
                                                    <small class="text-muted">{{ strtoupper($doc->tipo) }}</small>
                                                </a>
                                            @empty
                                                <div class="text-center py-3">
                                                    <p class="text-muted mb-0">No hay documentos recientes</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card hover-card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="bi bi-graph-up me-2"></i>
                                            Estadísticas
                                        </h5>
                                        <canvas id="documentosChart" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        .bubbles-container {
                            position: fixed;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            z-index: -1;
                            background: linear-gradient(45deg, #1a1a2e, #16213e, #0f3460);
                            overflow: hidden;
                        }

                        .bubbles {
                            position: relative;
                            display: flex;
                            width: 100%;
                            height: 100%;
                        }

                        .bubbles span {
                            position: relative;
                            width: 30px;
                            height: 30px;
                            background: rgba(255, 255, 255, 0.1);
                            margin: 0 4px;
                            border-radius: 50%;
                            box-shadow: 0 0 0 10px rgba(255, 255, 255, 0.1),
                                        0 0 50px rgba(255, 255, 255, 0.1),
                                        0 0 100px rgba(255, 255, 255, 0.1);
                            animation: animate 15s linear infinite;
                            animation-duration: calc(125s / var(--i));
                        }

                        .bubbles span:nth-child(even) {
                            background: rgba(255, 255, 255, 0.2);
                            box-shadow: 0 0 0 10px rgba(255, 255, 255, 0.2),
                                        0 0 50px rgba(255, 255, 255, 0.2),
                                        0 0 100px rgba(255, 255, 255, 0.2);
                        }

                        @keyframes animate {
                            0% {
                                transform: translateY(100vh) scale(0);
                            }
                            100% {
                                transform: translateY(-10vh) scale(1);
                            }
                        }

                        .hover-card {
                            transition: transform 0.3s ease, box-shadow 0.3s ease;
                            background: rgba(255, 255, 255, 0.9);
                            backdrop-filter: blur(10px);
                        }

                        .hover-card:hover {
                            transform: translateY(-5px);
                            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
                        }

                        .card {
                            border: none;
                            border-radius: 15px;
                        }

                        .card-body {
                            padding: 1.5rem;
                        }

                        .display-4 {
                            font-size: 2.5rem;
                            font-weight: 600;
                        }

                        .list-group-item {
                            border: none;
                            border-radius: 10px;
                            margin-bottom: 5px;
                            background: rgba(255, 255, 255, 0.8);
                        }

                        .list-group-item:hover {
                            background: rgba(255, 255, 255, 0.9);
                        }
                    </style>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const ctx = document.getElementById('documentosChart').getContext('2d');
                            new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                                    datasets: [{
                                        label: 'Documentos Subidos',
                                        data: [12, 19, 3, 5, 2, 3],
                                        borderColor: 'rgb(75, 192, 192)',
                                        tension: 0.1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            display: false
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                </x-app-layout>
            </div>
        </main>
    </div>
</body>
</html>
