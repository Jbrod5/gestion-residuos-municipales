<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DenunciasSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener IDs de ciudadanos
        $ciudadanos = DB::table('usuarios')
            ->where('id_rol', 4)
            ->pluck('id_usuario')
            ->toArray();

        if (empty($ciudadanos)) {
            $ciudadanos = [4, 4, 4]; // fallback
        }

        $descripciones = [
            'Basurero clandestino en terreno baldío cerca de la escuela',
            'Acumulación de desechos en la orilla del río',
            'Colchones y muebles viejos abandonados en la vía pública',
            'Bolsas de basura rotas en la esquina, regando desechos',
            'Neumáticos viejos acumulados en un lote vacío',
            'Residuos de construcción tirados en el barranco',
            'Animales muertos en la cuneta, mal olor',
            'Acumulación de basura cerca del mercado municipal',
            'Desechos hospitalarios en contenedor de basura común',
            'Vertedero ilegal en área protegida',
            'Basura acumulada en el parque infantil',
            'Restos de poda y jardinería bloqueando la acera',
            'Electrodomésticos viejos abandonados en la calle',
            'Basura quemándose en terreno baldío, humo tóxico',
            'Acumulación de envases plásticos en el río',
            'Desechos de restaurante tirados en la vía pública',
            'Muebles viejos y colchones en el parque',
            'Basura esparcida por perros en la colonia',
            'Acumulación de llantas usadas en terreno privado',
            'Residuos peligrosos (baterías, aceites) en contenedor incorrecto',
        ];

        // Usar rutas relativas al storage público
        $fotos_antes = [
            'denuncias/antes/1.jpg',
            'denuncias/antes/2.jpg',
            'denuncias/antes/3.jpg',
            'denuncias/antes/4.jpg',
            'denuncias/antes/5.jpg',
        ];

        $fotos_despues = [
            'denuncias/despues/6.jpg',
            'denuncias/despues/7.jpg',
            'denuncias/despues/8.jpg',
            'denuncias/despues/9.jpg',
            'denuncias/despues/10.jpg',
        ];

        $denuncias = [];
        
        for ($i = 1; $i <= 20; $i++) {
            $estado = rand(1, 6);
            $fecha = now()->subDays(rand(0, 60));
            
            $tieneFotoAntes = $i <= 10;
            $foto_antes = $tieneFotoAntes ? $fotos_antes[($i - 1) % 5] : null;
            
            $tieneFotoDespues = ($estado >= 5) && ($i <= 8);
            $foto_despues = $tieneFotoDespues ? $fotos_despues[($i - 1) % 5] : null;
            
            $denuncias[] = [
                'id_denuncia' => $i,
                'id_usuario' => $ciudadanos[array_rand($ciudadanos)],
                'id_estado_denuncia' => $estado,
                'id_tamano_denuncia' => rand(1, 3),
                'descripcion' => $descripciones[($i - 1) % count($descripciones)],
                'fecha' => $fecha->toDateString(),
                'foto_antes' => $foto_antes,
                'foto_despues' => $foto_despues,
                'latitud' => 14.8300 + (rand(-50, 50) / 1000),
                'longitud' => -91.5200 + (rand(-30, 30) / 1000),
                'created_at' => $fecha,
                'updated_at' => $fecha,
            ];
        }

        foreach ($denuncias as $denuncia) {
            DB::table('denuncias')->updateOrInsert(
                ['id_denuncia' => $denuncia['id_denuncia']],
                $denuncia
            );
        }
    }
}