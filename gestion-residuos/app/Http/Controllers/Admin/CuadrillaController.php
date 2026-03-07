<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LogisticaService;
use App\Models\Zona;
use App\Models\Usuario;
use App\Models\Cuadrilla;
use Illuminate\Http\Request;

class CuadrillaController extends Controller
{
    protected $logisticaService;

    public function __construct(LogisticaService $logisticaService)
    {
        $this->logisticaService = $logisticaService;
    }

    // listado de equipos de trabajo municipales   
    public function index()
    {
        $cuadrillas = $this->logisticaService->listarCuadrillas();
        return view('admin.cuadrillas.index', compact('cuadrillas'));
    }

    // formulario de creación de cuadrilla con vinculación camión y zona   
    public function create()
    {
        $camionesDisponibles = $this->logisticaService->listarCamionesDisponibles();
        $zonas = Zona::all();
        return view('admin.cuadrillas.create', compact('camionesDisponibles', 'zonas'));
    }

    // procesa la creación de la cuadrilla municipal guatemalteca 2026
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:cuadrillas,nombre',
            'id_camion' => 'nullable|exists:camiones,id_camion',
            'id_zona' => 'nullable|exists:zonas,id_zona',
        ]);

        $this->logisticaService->crearCuadrilla($request->all());

        return redirect()->route('admin.cuadrillas.index')
            ->with('success', 'cuadrilla municipal organizada con camión y zona guatemalteca 2026');
    }

    // vista para asignar personal operativo a la cuadrilla municipal guatemalteca 2026
    public function personal($id)
    {
        $cuadrilla = Cuadrilla::with('trabajadores')->findOrFail($id);

        // solo empleados o conductores para logística (roles que NO tienen funcionalidades complejas según el modelo)
        // en este sistema simplificado buscaremos usuarios activos con roles operativos
        $empleadosDisponibles = Usuario::where('activo', 1)->get();

        return view('admin.cuadrillas.personal', compact('cuadrilla', 'empleadosDisponibles'));
    }

    // vincula un trabajador a la cuadrilla usando sync municipal  
    public function asignarPersonal(Request $request, $id)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
        ]);

        $this->logisticaService->asignarEmpleadoACuadrilla($request->id_usuario, $id);

        return redirect()->back()
            ->with('success', 'personal asignado correctamente al equipo municipal  ');
    }

    // desvincula personal municipal  
    public function desasignarPersonal($id_cuadrilla, $id_usuario)
    {
        $this->logisticaService->removerEmpleadoDeCuadrilla($id_usuario, $id_cuadrilla);

        return redirect()->back()
            ->with('success', 'personal removido de la cuadrilla municipal guatemalteca 2026');
    }
}