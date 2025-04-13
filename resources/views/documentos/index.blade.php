<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Mis Documentos</h2>
            <a href="{{ route('documentos.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i>Nuevo Documento
            </a>
        </div>
    </x-slot>

    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($documentos->isEmpty())
            <div class="card shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-folder-x text-muted display-1 mb-3"></i>
                    <h3 class="h4">No hay documentos</h3>
                    <p class="text-muted">Comienza subiendo tu primer documento</p>
                    <a href="{{ route('documentos.create') }}" class="btn btn-primary mt-3">
                        <i class="bi bi-cloud-upload me-2"></i>Subir Documento
                    </a>
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($documentos as $doc)
                    <div class="col">
                        <div class="card h-100 shadow-sm hover-card">
                            <!-- Imagen de portada -->
                            <div class="card-img-top position-relative" style="height: 200px; overflow: hidden;">
                                @if($doc->tipo == 'pdf')
                                    <img src="{{ asset('images/pdf-preview.svg') }}" 
                                         class="w-100 h-100 object-fit-cover" 
                                         alt="Vista previa PDF">
                                @elseif($doc->tipo == 'epub')
                                    <img src="{{ asset('images/epub-preview.svg') }}" 
                                         class="w-100 h-100 object-fit-cover" 
                                         alt="Vista previa EPUB">
                                @else
                                    <img src="{{ asset('images/docx-preview.svg') }}" 
                                         class="w-100 h-100 object-fit-cover" 
                                         alt="Vista previa DOCX">
                                @endif
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-{{ $doc->tipo == 'pdf' ? 'danger' : ($doc->tipo == 'epub' ? 'info' : 'secondary') }}">
                                        {{ strtoupper($doc->tipo) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Contenido de la tarjeta -->
                            <div class="card-body">
                                <h5 class="card-title text-truncate">{{ $doc->titulo }}</h5>
                                <p class="card-text text-muted small">
                                    <i class="bi bi-calendar me-1"></i>
                                    Subido el {{ $doc->created_at->format('d/m/Y') }}
                                </p>
                            </div>

                            <!-- Acciones -->
                            <div class="card-footer bg-transparent border-top-0">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('documentos.show', $doc) }}" 
                                       class="btn btn-outline-primary">
                                        <i class="bi bi-eye me-2"></i>Leer
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <style>
        .hover-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        .object-fit-cover {
            object-fit: cover;
        }
    </style>
</x-app-layout>
