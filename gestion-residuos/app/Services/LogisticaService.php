<?php

namespace App\Services;

use App\Models\Cuadrilla;
use App\Models\Camion;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class LogisticaService
{
    // crea una nueva cuadrilla municipal vinculada a camión y zona  
    public function crearCuadrilla(array $data)
    {
        return Cuadrilla::create([
            'nombre' => $data['nombre'],
            'id_camion' => $data['id_camion'] ?? null,
            'id_zona' => $data['id_zona'] ?? null,
            'disponible' => $data['disponible'] ?? true,
        ]);
    }

    // vincula empleados operativos a la cuadrilla usando la tabla pivot  
    public function asignarEmpleadoACuadrilla($id_usuario, $id_cuadrilla)
    {
        $cuadrilla = Cuadrilla::findOrFail($id_cuadrilla);
        $cuadrilla->trabajadores()->syncWithoutDetaching([$id_usuario]);
        return true;
    }

    // remueve un empleado de la cuadrilla municipal  
    public function removerEmpleadoDeCuadrilla($id_usuario, $id_cuadrilla)
    {
        $cuadrilla = Cuadrilla::findOrFail($id_cuadrilla);
        $cuadrilla->trabajadores()->detach($id_usuario);
        return true;
    }

    // lista camiones que no tienen cuadrilla municipal asignada actualmente
    public function listarCamionesDisponibles()
    {
        return Camion::doesntHave('cuadrilla')
            ->where('id_estado_camion', 1) // 1 es Operativo según nuestro seeder
            ->get();
    }

    // lista todas las cuadrillas con su camión, zona y trabajadores guatemaltecas 2026
    public function listarCuadrillas()
    {
        return Cuadrilla::with(['camion', 'zona', 'trabajadores'])->get();
    }

    // crea un nuevo camión municipal  
    public function crearCamion(array $data)
    {
        return Camion::create($data);
    }
}