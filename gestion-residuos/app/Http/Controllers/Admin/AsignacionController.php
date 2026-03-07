<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DenunciaService;
use App\Services\LogisticaService;
use Illuminate\Http\Request;

class AsignacionController extends Controller
{
    protected $denunciaService;
    protected $logisticaService;

    public function __construct(DenunciaService $denunciaService, LogisticaService $logisticaService)
    {
        $this->denunciaService = $denunciaService;
        $this->logisticaService = $logisticaService;
    }

    /**
     * procesa la asignación de una cuadrilla a una denuncia municipal
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_denuncia' => 'required|exists:denuncias,id_denuncia',
            'id_cuadrilla' => 'required|exists:cuadrillas,id_cuadrilla',
        ]);

        try {
            $this->denunciaService->asignarCuadrilla($request->id_denuncia, $request->id_cuadrilla);

            return redirect()->back()
                ->with('success', 'cuadrilla asignada exitosamente a la denuncia municipal');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'error al asignar: ' . $e->getMessage());
        }
    }
}
