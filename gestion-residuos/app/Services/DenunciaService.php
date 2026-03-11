<?php

namespace App\Services;

use App\Models\Denuncia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class DenunciaService
{
    // guarda la denuncia del ciudadano en la base de datos siguiendo esquema original
    public function crearDenuncia(array $data, ?UploadedFile $foto = null): Denuncia
    {
        $fotoPath = null;
        
        // si hay foto la guardamos en la carpeta de denuncias y usamos el campo foto_antes
        if ($foto) {
            $fotoPath = $foto->store('denuncias', 'public');
        }

        return Denuncia::create([
            'id_usuario' => Auth::id(),
            'id_estado_denuncia' => 1, // 1 es Pendiente segun EstadoDenunciaSeeder
            'id_tamano_denuncia' => $data['id_tamano_denuncia'],
            'descripcion' => $data['descripcion'],
            'fecha' => now(), // fecha actual del sistema
            'foto_antes' => $fotoPath,
            'latitud' => $data['latitud'] ?? null,
            'longitud' => $data['longitud'] ?? null,
        ]);
    }

    // obtiene todas las denuncias del sistema para el admin con sus relaciones
    public function listarTodas()
    {
        return Denuncia::with(['usuario', 'estado', 'tamano'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    // obtiene solo las denuncias que pertenecen al ciudadano especificado
    public function obtenerDenunciasCiudadano($id_usuario)
    {
        return Denuncia::with(['estado', 'tamano'])
            ->where('id_usuario', $id_usuario)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    // busca una denuncia especifica por su ID original municipal
    public function obtenerDenunciaPorId($id_denuncia)
    {
        return Denuncia::with(['usuario', 'estado', 'tamano'])
            ->findOrFail($id_denuncia);
    }

    // actualiza el estado de una denuncia especifica
    public function actualizarEstado($id_denuncia, $id_estado_denuncia)
    {
        $denuncia = Denuncia::findOrFail($id_denuncia);
        $denuncia->update([
            'id_estado_denuncia' => $id_estado_denuncia
        ]);
        return $denuncia;
    }

    // obtiene el conteo total de denuncias para el dashboard
    public function contarTodas()
    {
        return Denuncia::count();
    }

    /**
     * asigna una cuadrilla a una denuncia de forma atómica
     * garantiza que la denuncia pase a 'En Proceso' y la cuadrilla se marque como ocupada
     */
    public function asignarCuadrilla($id_denuncia, $id_cuadrilla)
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($id_denuncia, $id_cuadrilla) {
            $denuncia = Denuncia::findOrFail($id_denuncia);
            $cuadrilla = \App\Models\Cuadrilla::findOrFail($id_cuadrilla);

            // Validación de disponibilidad municipal
            if (!$cuadrilla->disponible) {
                throw new \Exception('la cuadrilla seleccionada no está disponible actualmente');
            }

            // 1. Crear el registro de asignación
            \App\Models\AsignacionDenuncia::create([
                'id_denuncia' => $id_denuncia,
                'id_cuadrilla' => $id_cuadrilla,
                'fecha_asignacion' => now(),
            ]);

            // 2. Actualizar estado de la denuncia a 'En Proceso' (ID 4)
            $denuncia->update([
                'id_estado_denuncia' => 4
            ]);

            // 3. Marcar cuadrilla como no disponible
            $cuadrilla->update([
                'disponible' => 0
            ]);

            return true;
        });
    }

    /**
 * finaliza la atención de una denuncia y libera a la cuadrilla asignada
 */
public function finalizarDenuncia($id_denuncia, UploadedFile $fotoDespues)
{
    return \Illuminate\Support\Facades\DB::transaction(function () use ($id_denuncia, $fotoDespues) {
        $denuncia = Denuncia::findOrFail($id_denuncia);
        
        // Buscar la asignación activa municipal (sin fecha_atencion)
        $asignacion = \App\Models\AsignacionDenuncia::where('id_denuncia', $id_denuncia)
            ->whereNull('fecha_atencion')
            ->latest()
            ->first();
        
        // Si no hay asignación activa, buscar cualquier asignación
        if (!$asignacion) {
            $asignacion = \App\Models\AsignacionDenuncia::where('id_denuncia', $id_denuncia)
                ->latest()
                ->first();
                
            if (!$asignacion) {
                // Si no existe ninguna asignación, crear una automática
                // Buscar cualquier cuadrilla disponible
                $cuadrilla = \App\Models\Cuadrilla::where('disponible', 1)->first();
                
                if (!$cuadrilla) {
                    throw new \Exception('No hay cuadrillas disponibles para asignar a esta denuncia');
                }
                
                // Crear asignación automática
                $asignacion = \App\Models\AsignacionDenuncia::create([
                    'id_denuncia' => $id_denuncia,
                    'id_cuadrilla' => $cuadrilla->id_cuadrilla,
                    'fecha_asignacion' => now(),
                ]);
                
                // Marcar cuadrilla como no disponible
                $cuadrilla->update(['disponible' => 0]);
            }
        }

        // Obtener la cuadrilla (puede ser de la asignación existente o la que acabamos de crear)
        $cuadrilla = \App\Models\Cuadrilla::findOrFail($asignacion->id_cuadrilla);

        // 1. Guardar evidencia visual del trabajo municipal
        $fotoPath = $fotoDespues->store('denuncias/evidencia', 'public');

        // 2. Actualizar denuncia: marcar como 'Atendida' (ID 3) y subir foto
        $denuncia->update([
            'id_estado_denuncia' => 3, // Atendida
            'foto_despues' => $fotoPath
        ]);

        // 3. Liberar cuadrilla municipal para nuevos servicios
        $cuadrilla->update([
            'disponible' => 1
        ]);

        // 4. Registrar fecha de finalización en la asignación
        $asignacion->update([
            'fecha_atencion' => now()
        ]);

        return true;
    });
}
}
