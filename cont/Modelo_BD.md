Esquema: gestion_residuos


- ROL -
id_rol (pk)

nombre
descripcion

//Habran roles operativos con funcionalidades y otros que no
//Los que SI: Administrador Municipal, Coordinador de rutas, Operador de punto verde, ciudadano, auditor
//Los que no:conductor, empleado cuadrilla





- USUARIO -
id_usuario (pk)
id_rol (fk)

nombre
correo
password
telefono
activo


- CUADRILLA -
id_cuadrilla (pk)

nombre
disponible


- CUADRILLA_TRABAJADOR -
id_cuadrilla_trabajador (pk)
id_cuadrilla (fk)
id_usuario (fk)


- ZONA -
id_zona (pk)
id_tipo_zona (fk)

nombre
latitud
longitud


- TIPO_ZONA -
id_tipo_zona (pk)

nombre
descripcion


- TIPO_RESIDUO -
id_tipo_residuo (pk)

nombre
descripcion


- RUTA - //El inicio y el fin son marcados por PUNTO_RECOLECCION
id_ruta (pk)
id_zona (fk)
id_tipo_residuo (fk)

nombre
poblacion_estimada
distancia_km



- DIA_SEMANA -
id_dia_semana (pk)

nombre


- RUTA_DIA -
id_ruta_dia (pk)
id_ruta (fk)
id_dia_semana (fk)

hora_inicio
hora_fin


- PUNTO_RECOLECCION -
id_punto_recoleccion (pk)
id_ruta (fk)

posicion_orden
latitud
longitud


- ESTADO_CAMION -
id_estado_camion (pk)

nombre
descripcion


- CAMION -
id_camion (pk)
id_estado_camion (fk)

placa
capacidad_toneladas


- ESTADO_ASIGNACION_RUTA -
id_estado_asignacion_ruta (pk)

nombre
descripcion


- ASIGNACION_RUTA -
id_asignacion_ruta (pk)
id_ruta (fk)
id_camion (fk)
id_cuadrilla (fk)
id_conductor (fk)
id_estado_asignacion_ruta (fk)

fecha
hora_inicio
hora_fin
basura_estimada_ton
basura_recolectada_ton
notas_incidencias


- ESTADO_DENUNCIA -
id_estado_denuncia (pk)

nombre
descripcion


- TAMANO_DENUNCIA -
id_tamano_denuncia (pk)

nombre
descripcion


- DENUNCIA -
id_denuncia (pk)
id_usuario (fk)
id_estado_denuncia (fk)
id_tamano_denuncia (fk)

descripcion
fecha
foto_antes
foto_despues
latitud
longitud


- ASIGNACION_DENUNCIA -
id_asignacion_denuncia (pk)
id_denuncia (fk)
id_cuadrilla (fk)

fecha_asignacion
fecha_atencion


- MATERIAL -
id_material (pk)

nombre
descripcion


- PUNTO_VERDE -
id_punto_verde (pk)
id_encargado (fk)

nombre
direccion
horario
capacidad_total_m3
latitud
longitud


- CONTENEDOR -
id_contenedor (pk)
id_punto_verde (fk)
id_material (fk)

capacidad_maxima_m3
nivel_actual_m3


- ENTREGA_RECICLAJE -
id_entrega (pk)
id_punto_verde (fk)
id_material (fk)
id_usuario (fk)

cantidad_kg
fecha
observaciones