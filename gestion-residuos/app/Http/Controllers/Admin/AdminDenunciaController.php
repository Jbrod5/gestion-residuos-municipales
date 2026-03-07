<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DenunciaService;
use Illuminate\Http\Request;

class AdminDenunciaController extends Controller
{
    protected $denunciaService;

    public function __construct(DenunciaService $denunciaService)
    {
        $this->denunciaService = $denunciaService;
    }

    // muestra el dashboard de administracion con estadisticas basicas
    public function dashboard()
    {
        $totalDenuncias = $this->denunciaService->contarTodas();
        return view('admin.dashboard', compact('totalDenuncias'));
    }

    // muestra el listado global de todas las denuncias
    public function index()
    {
        $denuncias = $this->denunciaService->listarTodas();
        $estados = \App\Models\EstadoDenuncia::all();
        return view('admin.denuncias.index', compact('denuncias', 'estados'));
    }

    // procesa el cambio de estado de una denuncia
    public function updateStatus(Request $request, $id_denuncia)
    {
        $request->validate([
            'id_estado_denuncia' => 'required|exists:estado_denuncias,id_estado_denuncia'
        ]);

        $this->denunciaService->actualizarEstado($id_denuncia, $request->id_estado_denuncia);

        return redirect()->back()->with('success', 'estado de la denuncia actualizado correctamente');
    }
}
