-- gestion_residuos.cache definition

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.cache_locks definition

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.dias_semana definition

CREATE TABLE `dias_semana` (
  `id_dia_semana` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_dia_semana`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.estado_asignacion_rutas definition

CREATE TABLE `estado_asignacion_rutas` (
  `id_estado_asignacion_ruta` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `color` varchar(20) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_estado_asignacion_ruta`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.estado_camiones definition

CREATE TABLE `estado_camiones` (
  `id_estado_camion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_estado_camion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.estado_denuncias definition

CREATE TABLE `estado_denuncias` (
  `id_estado_denuncia` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_estado_denuncia`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.failed_jobs definition

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.job_batches definition

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.jobs definition

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.materiales definition

CREATE TABLE `materiales` (
  `id_material` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `densidad_kg_m3` double NOT NULL DEFAULT 100,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_material`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.migrations definition

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.password_reset_tokens definition

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.roles definition

CREATE TABLE `roles` (
  `id_rol` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.sessions definition

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.tamanos_denuncia definition

CREATE TABLE `tamanos_denuncia` (
  `id_tamano_denuncia` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_tamano_denuncia`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.tipo_residuos definition

CREATE TABLE `tipo_residuos` (
  `id_tipo_residuo` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_tipo_residuo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.tipo_zonas definition

CREATE TABLE `tipo_zonas` (
  `id_tipo_zona` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_tipo_zona`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.camiones definition

CREATE TABLE `camiones` (
  `id_camion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_estado_camion` bigint(20) unsigned NOT NULL,
  `placa` varchar(255) NOT NULL,
  `capacidad_toneladas` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_camion`),
  UNIQUE KEY `camiones_placa_unique` (`placa`),
  KEY `camiones_id_estado_camion_foreign` (`id_estado_camion`),
  CONSTRAINT `camiones_id_estado_camion_foreign` FOREIGN KEY (`id_estado_camion`) REFERENCES `estado_camiones` (`id_estado_camion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.usuarios definition

CREATE TABLE `usuarios` (
  `id_usuario` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_rol` bigint(20) unsigned NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_punto_verde` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `usuarios_correo_unique` (`correo`),
  KEY `usuarios_id_rol_foreign` (`id_rol`),
  KEY `usuarios_id_punto_verde_foreign` (`id_punto_verde`),
  CONSTRAINT `usuarios_id_punto_verde_foreign` FOREIGN KEY (`id_punto_verde`) REFERENCES `puntos_verde` (`id_punto_verde`) ON DELETE SET NULL,
  CONSTRAINT `usuarios_id_rol_foreign` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.zonas definition

CREATE TABLE `zonas` (
  `id_zona` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_tipo_zona` bigint(20) unsigned NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `latitud` double DEFAULT NULL,
  `longitud` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_zona`),
  KEY `zonas_id_tipo_zona_foreign` (`id_tipo_zona`),
  CONSTRAINT `zonas_id_tipo_zona_foreign` FOREIGN KEY (`id_tipo_zona`) REFERENCES `tipo_zonas` (`id_tipo_zona`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.cuadrillas definition

CREATE TABLE `cuadrillas` (
  `id_cuadrilla` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_camion` bigint(20) unsigned DEFAULT NULL,
  `id_zona` bigint(20) unsigned DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_cuadrilla`),
  KEY `cuadrillas_id_camion_foreign` (`id_camion`),
  KEY `cuadrillas_id_zona_foreign` (`id_zona`),
  CONSTRAINT `cuadrillas_id_camion_foreign` FOREIGN KEY (`id_camion`) REFERENCES `camiones` (`id_camion`) ON DELETE SET NULL,
  CONSTRAINT `cuadrillas_id_zona_foreign` FOREIGN KEY (`id_zona`) REFERENCES `zonas` (`id_zona`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.denuncias definition

CREATE TABLE `denuncias` (
  `id_denuncia` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) unsigned NOT NULL,
  `id_estado_denuncia` bigint(20) unsigned NOT NULL,
  `id_tamano_denuncia` bigint(20) unsigned NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` date NOT NULL,
  `foto_antes` varchar(255) DEFAULT NULL,
  `foto_despues` varchar(255) DEFAULT NULL,
  `latitud` double DEFAULT NULL,
  `longitud` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_denuncia`),
  KEY `denuncias_id_usuario_foreign` (`id_usuario`),
  KEY `denuncias_id_estado_denuncia_foreign` (`id_estado_denuncia`),
  KEY `denuncias_id_tamano_denuncia_foreign` (`id_tamano_denuncia`),
  CONSTRAINT `denuncias_id_estado_denuncia_foreign` FOREIGN KEY (`id_estado_denuncia`) REFERENCES `estado_denuncias` (`id_estado_denuncia`),
  CONSTRAINT `denuncias_id_tamano_denuncia_foreign` FOREIGN KEY (`id_tamano_denuncia`) REFERENCES `tamanos_denuncia` (`id_tamano_denuncia`),
  CONSTRAINT `denuncias_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.puntos_verde definition

CREATE TABLE `puntos_verde` (
  `id_punto_verde` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_encargado` bigint(20) unsigned NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `horario` varchar(255) DEFAULT NULL,
  `capacidad_total_m3` double NOT NULL,
  `latitud` double DEFAULT NULL,
  `longitud` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_punto_verde`),
  KEY `puntos_verde_id_encargado_foreign` (`id_encargado`),
  CONSTRAINT `puntos_verde_id_encargado_foreign` FOREIGN KEY (`id_encargado`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.rutas definition

CREATE TABLE `rutas` (
  `id_ruta` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_zona` bigint(20) unsigned NOT NULL,
  `id_tipo_residuo` bigint(20) unsigned NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `poblacion_estimada` int(11) DEFAULT NULL,
  `distancia_km` double DEFAULT NULL,
  `latitud_inicio` decimal(10,8) DEFAULT NULL,
  `longitud_inicio` decimal(11,8) DEFAULT NULL,
  `latitud_fin` decimal(10,8) DEFAULT NULL,
  `longitud_fin` decimal(11,8) DEFAULT NULL,
  `basura_total_estimada` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_punto_verde` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_ruta`),
  KEY `rutas_id_zona_foreign` (`id_zona`),
  KEY `rutas_id_tipo_residuo_foreign` (`id_tipo_residuo`),
  KEY `rutas_id_punto_verde_foreign` (`id_punto_verde`),
  CONSTRAINT `rutas_id_punto_verde_foreign` FOREIGN KEY (`id_punto_verde`) REFERENCES `puntos_verde` (`id_punto_verde`) ON DELETE SET NULL,
  CONSTRAINT `rutas_id_tipo_residuo_foreign` FOREIGN KEY (`id_tipo_residuo`) REFERENCES `tipo_residuos` (`id_tipo_residuo`),
  CONSTRAINT `rutas_id_zona_foreign` FOREIGN KEY (`id_zona`) REFERENCES `zonas` (`id_zona`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.asignacion_denuncias definition

CREATE TABLE `asignacion_denuncias` (
  `id_asignacion_denuncia` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_denuncia` bigint(20) unsigned NOT NULL,
  `id_cuadrilla` bigint(20) unsigned NOT NULL,
  `fecha_asignacion` date NOT NULL,
  `fecha_atencion` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_asignacion_denuncia`),
  KEY `asignacion_denuncias_id_denuncia_foreign` (`id_denuncia`),
  KEY `asignacion_denuncias_id_cuadrilla_foreign` (`id_cuadrilla`),
  CONSTRAINT `asignacion_denuncias_id_cuadrilla_foreign` FOREIGN KEY (`id_cuadrilla`) REFERENCES `cuadrillas` (`id_cuadrilla`) ON DELETE CASCADE,
  CONSTRAINT `asignacion_denuncias_id_denuncia_foreign` FOREIGN KEY (`id_denuncia`) REFERENCES `denuncias` (`id_denuncia`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.asignacion_rutas definition

CREATE TABLE `asignacion_rutas` (
  `id_asignacion_ruta` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_ruta` bigint(20) unsigned NOT NULL,
  `id_camion` bigint(20) unsigned NOT NULL,
  `id_cuadrilla` bigint(20) unsigned DEFAULT NULL,
  `id_conductor` bigint(20) unsigned DEFAULT NULL,
  `id_estado_asignacion_ruta` bigint(20) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `basura_estimada_ton` double DEFAULT NULL,
  `basura_recolectada_ton` double DEFAULT NULL,
  `notas_incidencias` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_asignacion_ruta`),
  KEY `asignacion_rutas_id_ruta_foreign` (`id_ruta`),
  KEY `asignacion_rutas_id_camion_foreign` (`id_camion`),
  KEY `asignacion_rutas_id_cuadrilla_foreign` (`id_cuadrilla`),
  KEY `asignacion_rutas_id_conductor_foreign` (`id_conductor`),
  KEY `asignacion_rutas_id_estado_asignacion_ruta_foreign` (`id_estado_asignacion_ruta`),
  CONSTRAINT `asignacion_rutas_id_camion_foreign` FOREIGN KEY (`id_camion`) REFERENCES `camiones` (`id_camion`) ON DELETE CASCADE,
  CONSTRAINT `asignacion_rutas_id_conductor_foreign` FOREIGN KEY (`id_conductor`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL,
  CONSTRAINT `asignacion_rutas_id_cuadrilla_foreign` FOREIGN KEY (`id_cuadrilla`) REFERENCES `cuadrillas` (`id_cuadrilla`) ON DELETE SET NULL,
  CONSTRAINT `asignacion_rutas_id_estado_asignacion_ruta_foreign` FOREIGN KEY (`id_estado_asignacion_ruta`) REFERENCES `estado_asignacion_rutas` (`id_estado_asignacion_ruta`),
  CONSTRAINT `asignacion_rutas_id_ruta_foreign` FOREIGN KEY (`id_ruta`) REFERENCES `rutas` (`id_ruta`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.contenedores definition

CREATE TABLE `contenedores` (
  `id_contenedor` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_punto_verde` bigint(20) unsigned NOT NULL,
  `id_material` bigint(20) unsigned NOT NULL,
  `capacidad_maxima_m3` double NOT NULL,
  `nivel_actual_m3` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_contenedor`),
  KEY `contenedores_id_punto_verde_foreign` (`id_punto_verde`),
  KEY `contenedores_id_material_foreign` (`id_material`),
  CONSTRAINT `contenedores_id_material_foreign` FOREIGN KEY (`id_material`) REFERENCES `materiales` (`id_material`) ON DELETE CASCADE,
  CONSTRAINT `contenedores_id_punto_verde_foreign` FOREIGN KEY (`id_punto_verde`) REFERENCES `puntos_verde` (`id_punto_verde`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.cuadrilla_trabajador definition

CREATE TABLE `cuadrilla_trabajador` (
  `id_cuadrilla_trabajador` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_cuadrilla` bigint(20) unsigned NOT NULL,
  `id_usuario` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_cuadrilla_trabajador`),
  KEY `cuadrilla_trabajador_id_cuadrilla_foreign` (`id_cuadrilla`),
  KEY `cuadrilla_trabajador_id_usuario_foreign` (`id_usuario`),
  CONSTRAINT `cuadrilla_trabajador_id_cuadrilla_foreign` FOREIGN KEY (`id_cuadrilla`) REFERENCES `cuadrillas` (`id_cuadrilla`) ON DELETE CASCADE,
  CONSTRAINT `cuadrilla_trabajador_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.entregas_reciclaje definition

CREATE TABLE `entregas_reciclaje` (
  `id_entrega` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_punto_verde` bigint(20) unsigned NOT NULL,
  `id_material` bigint(20) unsigned NOT NULL,
  `id_usuario` bigint(20) unsigned DEFAULT NULL,
  `cantidad_kg` double NOT NULL,
  `fecha` datetime NOT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_entrega`),
  KEY `entregas_reciclaje_id_punto_verde_foreign` (`id_punto_verde`),
  KEY `entregas_reciclaje_id_material_foreign` (`id_material`),
  KEY `entregas_reciclaje_id_usuario_foreign` (`id_usuario`),
  CONSTRAINT `entregas_reciclaje_id_material_foreign` FOREIGN KEY (`id_material`) REFERENCES `materiales` (`id_material`) ON DELETE CASCADE,
  CONSTRAINT `entregas_reciclaje_id_punto_verde_foreign` FOREIGN KEY (`id_punto_verde`) REFERENCES `puntos_verde` (`id_punto_verde`) ON DELETE CASCADE,
  CONSTRAINT `entregas_reciclaje_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.punto_verde_horario definition

CREATE TABLE `punto_verde_horario` (
  `id_punto_verde_horario` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_punto_verde` bigint(20) unsigned NOT NULL,
  `id_dia_semana` bigint(20) unsigned NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_punto_verde_horario`),
  KEY `punto_verde_horario_id_punto_verde_foreign` (`id_punto_verde`),
  KEY `punto_verde_horario_id_dia_semana_foreign` (`id_dia_semana`),
  CONSTRAINT `punto_verde_horario_id_dia_semana_foreign` FOREIGN KEY (`id_dia_semana`) REFERENCES `dias_semana` (`id_dia_semana`) ON DELETE CASCADE,
  CONSTRAINT `punto_verde_horario_id_punto_verde_foreign` FOREIGN KEY (`id_punto_verde`) REFERENCES `puntos_verde` (`id_punto_verde`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.puntos_recoleccion definition

CREATE TABLE `puntos_recoleccion` (
  `id_punto_recoleccion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_ruta` bigint(20) unsigned NOT NULL,
  `posicion_orden` int(11) NOT NULL,
  `latitud` double NOT NULL,
  `longitud` double NOT NULL,
  `volumen_estimado_kg` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_punto_recoleccion`),
  KEY `puntos_recoleccion_id_ruta_foreign` (`id_ruta`),
  CONSTRAINT `puntos_recoleccion_id_ruta_foreign` FOREIGN KEY (`id_ruta`) REFERENCES `rutas` (`id_ruta`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.ruta_dia definition

CREATE TABLE `ruta_dia` (
  `id_ruta_dia` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_ruta` bigint(20) unsigned NOT NULL,
  `id_dia_semana` bigint(20) unsigned NOT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_ruta_dia`),
  KEY `ruta_dia_id_ruta_foreign` (`id_ruta`),
  KEY `ruta_dia_id_dia_semana_foreign` (`id_dia_semana`),
  CONSTRAINT `ruta_dia_id_dia_semana_foreign` FOREIGN KEY (`id_dia_semana`) REFERENCES `dias_semana` (`id_dia_semana`) ON DELETE CASCADE,
  CONSTRAINT `ruta_dia_id_ruta_foreign` FOREIGN KEY (`id_ruta`) REFERENCES `rutas` (`id_ruta`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- gestion_residuos.ruta_trayectorias definition

CREATE TABLE `ruta_trayectorias` (
  `id_trayectoria` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_ruta` bigint(20) unsigned NOT NULL,
  `latitud` decimal(10,8) NOT NULL,
  `longitud` decimal(11,8) NOT NULL,
  `orden` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_trayectoria`),
  KEY `ruta_trayectorias_id_ruta_foreign` (`id_ruta`),
  CONSTRAINT `ruta_trayectorias_id_ruta_foreign` FOREIGN KEY (`id_ruta`) REFERENCES `rutas` (`id_ruta`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;