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

    // obtiene denuncias con sus relaciones de estado y tamano
    public function obtenerDenunciasCiudadano()
    {
        return Denuncia::with(['estado', 'tamano'])
            ->where('id_usuario', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
