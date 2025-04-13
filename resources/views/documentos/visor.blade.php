<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Lectura: {{ $documento->titulo }}</h2>
            <a href="{{ route('documentos.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Volver
            </a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="row">
            <!-- Panel lateral de controles -->
            <div class="col-md-3 col-lg-2">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Controles</h5>
                        
                        <!-- Controles de zoom -->
                        <div class="mb-4">
                            <label class="form-label">Zoom</label>
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-outline-secondary" id="zoom-out">
                                    <i class="bi bi-zoom-out"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="zoom-reset">
                                    <i class="bi bi-zoom-reset"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="zoom-in">
                                    <i class="bi bi-zoom-in"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Controles de navegación -->
                        <div class="mb-4">
                            <label class="form-label">Navegación</label>
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-outline-secondary" id="prev-page">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <input type="number" class="form-control text-center" id="current-page" min="1" value="1">
                                <span class="input-group-text">/</span>
                                <span class="input-group-text" id="total-pages">1</span>
                                <button type="button" class="btn btn-outline-secondary" id="next-page">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Modo de visualización -->
                        <div class="mb-4">
                            <label class="form-label">Modo de Visualización</label>
                            <select class="form-select" id="view-mode">
                                <option value="single">Página única</option>
                                <option value="double">Doble página</option>
                                <option value="continuous">Continuo</option>
                            </select>
                        </div>

                        <!-- Rotación -->
                        <div class="mb-4">
                            <label class="form-label">Rotación</label>
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-outline-secondary" id="rotate-left">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="rotate-right">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Búsqueda -->
                        <div class="mb-4">
                            <label class="form-label">Buscar</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="search-input" placeholder="Buscar...">
                                <button class="btn btn-outline-secondary" type="button" id="search-button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Área de visualización -->
            <div class="col-md-9 col-lg-10">
                <div class="card shadow">
                    <div class="card-body">
                        @if($documento->tipo == 'pdf')
                            <div id="pdf-viewer" class="ratio ratio-16x9">
                                <canvas class="border rounded"></canvas>
                            </div>

                            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
                            <script>
                                let pdfDoc = null;
                                let pageNum = 1;
                                let pageRendering = false;
                                let pageNumPending = null;
                                let scale = 1.5;
                                let rotation = 0;
                                let viewMode = 'single';

                                const url = "{{ $rutaCompleta }}";
                                pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

                                // Cargar el documento
                                pdfjsLib.getDocument(url).promise.then(function(pdf) {
                                    pdfDoc = pdf;
                                    document.getElementById('total-pages').textContent = pdf.numPages;
                                    
                                    // Renderizar la primera página
                                    renderPage(pageNum);
                                });

                                function renderPage(num) {
                                    pageRendering = true;
                                    pdfDoc.getPage(num).then(function(page) {
                                        const viewport = page.getViewport({ 
                                            scale: scale,
                                            rotation: rotation
                                        });

                                        const canvas = document.querySelector('canvas');
                                        const context = canvas.getContext('2d');
                                        canvas.height = viewport.height;
                                        canvas.width = viewport.width;

                                        const renderContext = {
                                            canvasContext: context,
                                            viewport: viewport
                                        };

                                        const renderTask = page.render(renderContext);
                                        renderTask.promise.then(function() {
                                            pageRendering = false;
                                            if (pageNumPending !== null) {
                                                renderPage(pageNumPending);
                                                pageNumPending = null;
                                            }
                                        });
                                    });
                                }

                                function queueRenderPage(num) {
                                    if (pageRendering) {
                                        pageNumPending = num;
                                    } else {
                                        renderPage(num);
                                    }
                                }

                                // Controles de zoom
                                document.getElementById('zoom-in').onclick = function() {
                                    scale += 0.25;
                                    renderPage(pageNum);
                                };

                                document.getElementById('zoom-out').onclick = function() {
                                    if (scale > 0.5) {
                                        scale -= 0.25;
                                        renderPage(pageNum);
                                    }
                                };

                                document.getElementById('zoom-reset').onclick = function() {
                                    scale = 1.5;
                                    renderPage(pageNum);
                                };

                                // Controles de navegación
                                document.getElementById('prev-page').onclick = function() {
                                    if (pageNum <= 1) {
                                        return;
                                    }
                                    pageNum--;
                                    document.getElementById('current-page').value = pageNum;
                                    queueRenderPage(pageNum);
                                };

                                document.getElementById('next-page').onclick = function() {
                                    if (pageNum >= pdfDoc.numPages) {
                                        return;
                                    }
                                    pageNum++;
                                    document.getElementById('current-page').value = pageNum;
                                    queueRenderPage(pageNum);
                                };

                                document.getElementById('current-page').onchange = function() {
                                    const num = parseInt(this.value);
                                    if (num >= 1 && num <= pdfDoc.numPages) {
                                        pageNum = num;
                                        queueRenderPage(pageNum);
                                    } else {
                                        this.value = pageNum;
                                    }
                                };

                                // Rotación
                                document.getElementById('rotate-left').onclick = function() {
                                    rotation = (rotation - 90) % 360;
                                    renderPage(pageNum);
                                };

                                document.getElementById('rotate-right').onclick = function() {
                                    rotation = (rotation + 90) % 360;
                                    renderPage(pageNum);
                                };

                                // Modo de visualización
                                document.getElementById('view-mode').onchange = function() {
                                    viewMode = this.value;
                                    // Aquí se implementaría la lógica para cambiar el modo de visualización
                                };

                                // Búsqueda
                                document.getElementById('search-button').onclick = function() {
                                    const searchTerm = document.getElementById('search-input').value;
                                    if (searchTerm) {
                                        // Aquí se implementaría la lógica de búsqueda
                                        console.log('Buscando:', searchTerm);
                                    }
                                };
                            </script>
                        @elseif($documento->tipo == 'epub')
                            <div id="epub-viewer" class="border rounded" style="height: 600px;"></div>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
                            <script src="https://cdn.jsdelivr.net/npm/epubjs/dist/epub.min.js"></script>
                            <script>
                                // Configuración del visor EPUB
                                const book = ePub("{{ $rutaCompleta }}", {
                                    openAs: 'epub',
                                    restore: true
                                });

                                const rendition = book.renderTo("epub-viewer", {
                                    width: "100%",
                                    height: "600px",
                                    spread: "none"
                                });

                                // Configurar controles de navegación
                                rendition.display();

                                // Habilitar navegación con teclado
                                rendition.on("keyup", function(e) {
                                    if (e.key === "ArrowRight") {
                                        rendition.next();
                                    }
                                    if (e.key === "ArrowLeft") {
                                        rendition.prev();
                                    }
                                });

                                // Configurar controles del panel lateral
                                document.getElementById('zoom-in').onclick = function() {
                                    rendition.zoom(1.2);
                                };

                                document.getElementById('zoom-out').onclick = function() {
                                    rendition.zoom(0.8);
                                };

                                document.getElementById('zoom-reset').onclick = function() {
                                    rendition.zoom(1);
                                };

                                document.getElementById('prev-page').onclick = function() {
                                    rendition.prev();
                                };

                                document.getElementById('next-page').onclick = function() {
                                    rendition.next();
                                };

                                document.getElementById('rotate-left').onclick = function() {
                                    rendition.rotate(-90);
                                };

                                document.getElementById('rotate-right').onclick = function() {
                                    rendition.rotate(90);
                                };

                                document.getElementById('view-mode').onchange = function() {
                                    const mode = this.value;
                                    if (mode === 'single') {
                                        rendition.spread('none');
                                    } else if (mode === 'double') {
                                        rendition.spread('auto');
                                    } else if (mode === 'continuous') {
                                        rendition.spread('none');
                                        rendition.flow('scrolled');
                                    }
                                };

                                // Configurar búsqueda
                                document.getElementById('search-button').onclick = function() {
                                    const searchTerm = document.getElementById('search-input').value;
                                    if (searchTerm) {
                                        book.search(searchTerm).then(function(results) {
                                            if (results.length > 0) {
                                                rendition.display(results[0].cfi);
                                            }
                                        });
                                    }
                                };

                                // Cargar el libro
                                book.ready.then(function() {
                                    // Actualizar el número total de páginas
                                    const totalPages = book.spine.length;
                                    document.getElementById('total-pages').textContent = totalPages;
                                    
                                    // Configurar el evento de cambio de página
                                    rendition.on('relocated', function(location) {
                                        const currentPage = book.spine.indexOf(location.start.cfi);
                                        document.getElementById('current-page').value = currentPage + 1;
                                    });
                                });
                            </script>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
