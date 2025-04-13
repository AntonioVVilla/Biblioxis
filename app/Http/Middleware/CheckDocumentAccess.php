<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Documento;
use Illuminate\Support\Facades\Auth;

class CheckDocumentAccess
{
    public function handle(Request $request, Closure $next)
    {
        $documento = Documento::where('ruta_archivo', $request->path())->first();
        
        if (!$documento || $documento->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para acceder a este documento');
        }

        return $next($request);
    }
} 