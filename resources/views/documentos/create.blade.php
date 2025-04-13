<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center mb-4">Subir Documento</h2>
    </x-slot>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                       id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                                @error('titulo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="tipo" class="form-label">Tipo de Documento</label>
                                <select class="form-select @error('tipo') is-invalid @enderror" 
                                        id="tipo" name="tipo" required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="pdf" {{ old('tipo') == 'pdf' ? 'selected' : '' }}>PDF</option>
                                    <option value="epub" {{ old('tipo') == 'epub' ? 'selected' : '' }}>EPUB</option>
                                </select>
                                @error('tipo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="archivo" class="form-label">Archivo</label>
                                <input type="file" class="form-control @error('archivo') is-invalid @enderror" 
                                       id="archivo" name="archivo" accept=".pdf,.epub" required>
                                <div class="form-text">Tamaño máximo: 10MB. Formatos permitidos: PDF, EPUB</div>
                                @error('archivo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-cloud-upload me-2"></i>Subir Documento
                                </button>
                                <a href="{{ route('documentos.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Volver
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
