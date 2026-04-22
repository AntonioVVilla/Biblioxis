<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $stats = Documento::ofUser($userId)
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("SUM(CASE WHEN tipo = 'pdf' THEN 1 ELSE 0 END) as total_pdfs")
            ->selectRaw("SUM(CASE WHEN tipo = 'epub' THEN 1 ELSE 0 END) as total_epubs")
            ->first();

        $totalDocumentos = (int) ($stats->total ?? 0);
        $totalPdfs = (int) ($stats->total_pdfs ?? 0);
        $totalEpubs = (int) ($stats->total_epubs ?? 0);

        $documentosRecientes = Documento::ofUser($userId)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalDocumentos',
            'totalPdfs',
            'totalEpubs',
            'documentosRecientes'
        ));
    }
}
