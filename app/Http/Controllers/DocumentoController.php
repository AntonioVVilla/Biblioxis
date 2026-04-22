<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentoController extends Controller
{
    use AuthorizesRequests;

    private const MAX_FILE_SIZE_KB = 20480; // 20 MB

    private const ALLOWED_MIMES = [
        'pdf' => ['application/pdf'],
        'epub' => ['application/epub+zip', 'application/octet-stream'],
    ];

    public function index()
    {
        $documentos = Documento::where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

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

        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'tipo' => ['required', 'in:pdf,epub'],
            'archivo' => [
                'required',
                'file',
                'max:'.self::MAX_FILE_SIZE_KB,
                function ($attribute, $value, $fail) use ($request) {
                    $tipo = $request->input('tipo');
                    $extension = strtolower((string) $value->getClientOriginalExtension());
                    $mimeType = $value->getMimeType();

                    if (! isset(self::ALLOWED_MIMES[$tipo])) {
                        $fail('Tipo de documento no soportado.');

                        return;
                    }

                    if ($extension !== $tipo) {
                        $fail("La extensión del archivo no coincide con el tipo seleccionado ({$tipo}).");

                        return;
                    }

                    if (! in_array($mimeType, self::ALLOWED_MIMES[$tipo], true)) {
                        $fail("El archivo no es un {$tipo} válido.");
                    }
                },
            ],
        ]);

        try {
            $archivo = $request->file('archivo');
            $nombreSeguro = $this->sanitizeFilename($archivo->getClientOriginalName());
            $nombreArchivo = now()->format('YmdHis').'_'.Str::random(8).'_'.$nombreSeguro;

            $ruta = $archivo->storeAs('documentos/'.Auth::id(), $nombreArchivo, 'private');

            if ($ruta === false) {
                throw new \RuntimeException('No se pudo guardar el archivo en el almacenamiento.');
            }

            Documento::create([
                'titulo' => $validated['titulo'],
                'tipo' => $validated['tipo'],
                'ruta_archivo' => $ruta,
                'user_id' => Auth::id(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Error al subir documento', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            if (isset($ruta) && $ruta && Storage::disk('private')->exists($ruta)) {
                Storage::disk('private')->delete($ruta);
            }

            return back()
                ->withInput()
                ->with('error', 'Ha ocurrido un error al subir el documento. Inténtalo de nuevo.');
        }

        return redirect()
            ->route('documentos.index')
            ->with('success', 'Documento añadido correctamente');
    }

    public function show(Documento $documento)
    {
        $this->authorize('view', $documento);

        if (! Storage::disk('private')->exists($documento->ruta_archivo)) {
            Log::warning('Archivo físico no encontrado', [
                'documento_id' => $documento->id,
                'ruta' => $documento->ruta_archivo,
            ]);
            abort(404, 'El archivo no existe');
        }

        $rutaArchivo = Storage::disk('private')->path($documento->ruta_archivo);
        $nombreDescarga = Str::slug($documento->titulo).'.'.$documento->tipo;

        return response()->file($rutaArchivo, [
            'Content-Type' => $documento->tipo === 'pdf' ? 'application/pdf' : 'application/epub+zip',
            'Content-Disposition' => 'inline; filename="'.$nombreDescarga.'"',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function destroy(Documento $documento)
    {
        $this->authorize('delete', $documento);

        try {
            DB::transaction(function () use ($documento) {
                if (Storage::disk('private')->exists($documento->ruta_archivo)) {
                    Storage::disk('private')->delete($documento->ruta_archivo);
                }
                $documento->delete();
            });
        } catch (\Throwable $e) {
            Log::error('Error al eliminar documento', [
                'documento_id' => $documento->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'No se pudo eliminar el documento.');
        }

        return redirect()
            ->route('documentos.index')
            ->with('success', 'Documento eliminado correctamente');
    }

    private function sanitizeFilename(string $filename): string
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $base = pathinfo($filename, PATHINFO_FILENAME);
        $slug = Str::slug($base) ?: 'archivo';

        return $slug.($extension ? '.'.strtolower($extension) : '');
    }
}
