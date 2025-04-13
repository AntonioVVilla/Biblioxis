<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDocumentos = Documento::where('user_id', Auth::id())->count();
        $totalPdfs = Documento::where('user_id', Auth::id())
            ->where('tipo', 'pdf')
            ->count();
        $totalEpubs = Documento::where('user_id', Auth::id())
            ->where('tipo', 'epub')
            ->count();
        $documentosRecientes = Documento::where('user_id', Auth::id())
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