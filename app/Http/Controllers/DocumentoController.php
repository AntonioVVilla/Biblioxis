<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DocumentoController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $documentos = Documento::where('user_id', Auth::id())->get();
        return view('documentos.index', compact('documentos'));
    }

    public function create()
    {
        $this->authorize('create', Documento::class);
        return view('documentos.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Documento::class);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required|in:pdf,epub',
            'archivo' => [
                'required',
                'file',
                'max:10240', // máximo 10MB
                function ($attribute, $value, $fail) use ($request) {
                    $extension = strtolower($value->getClientOriginalExtension());
                    $mimeType = $value->getMimeType();
                    $tipo = $request->input('tipo');
                    
                    if ($tipo == 'pdf' && ($extension != 'pdf' || !in_array($mimeType, ['application/pdf']))) {
                        $fail('El archivo debe ser un PDF válido.');
                    }
                    
                    if ($tipo == 'epub' && ($extension != 'epub' || !in_array($mimeType, ['application/epub+zip']))) {
                        $fail('El archivo debe ser un EPUB válido.');
                    }
                }
            ]
        ]);

        $archivo = $request->file('archivo');
        $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
        $ruta = $archivo->storeAs('documentos', $nombreArchivo, 'private');

        Documento::create([
            'titulo' => $request->titulo,
            'tipo' => $request->tipo,
            'ruta_archivo' => $ruta,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('documentos.index')->with('success', 'Documento añadido correctamente');
    }

    public function show(Documento $documento)
    {
        $this->authorize('view', $documento);
        
        if (!Storage::disk('private')->exists($documento->ruta_archivo)) {
            abort(404, 'El archivo no existe');
        }

        $rutaArchivo = Storage::disk('private')->path($documento->ruta_archivo);
        
        return response()->file($rutaArchivo, [
            'Content-Type' => $documento->tipo === 'pdf' ? 'application/pdf' : 'application/epub+zip',
            'Content-Disposition' => 'inline; filename="' . basename($documento->ruta_archivo) . '"'
        ]);
    }
}
