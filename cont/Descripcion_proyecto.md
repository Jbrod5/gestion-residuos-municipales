Sistema de Gestión de Residuos y Reciclaje Municipal
Contexto Nacional
Guatemala enfrenta una crisis de manejo de desechos. Las municipalidades carecen de sistemas para optimizar rutas de recolección, monitorear el reciclaje, y gestionar puntos verdes. La basura en barrancos y ríos es un problema crítico.

Descripción General del Sistema
Sistema web para gestionar integralmente los residuos municipales, optimizando rutas de recolección, promoviendo el reciclaje y facilitando la participación ciudadana.

MÓDULOS DEL SISTEMA
1. Módulo de Rutas de Recolección
Gestión de Zonas y Rutas:

Definir zonas/colonias de la ciudad con coordenadas geográficas
Crear rutas predefinidas (Ruta 1, Ruta 2, Ruta 3, etc.)
Definición de rutas mediante mapa interactivo:
Utilizar API de mapas (Google Maps, Leaflet + OpenStreetMap, Mapbox)
Trazar rutas visualmente haciendo clic en el mapa
Puntos de inicio y fin marcados en el mapa
Sistema calcula automáticamente la distancia de la ruta
Visualización de la ruta completa en el mapa
Cada ruta incluye:
Nombre identificador (ej: "Ruta Centro-Norte")
Coordenadas de inicio (latitud, longitud)
Coordenadas de fin (latitud, longitud)
Array de coordenadas intermedias (puntos de la ruta trazada)
Distancia calculada automáticamente por la API en kilómetros
Días de recolección asignados (Lunes-Miércoles-Viernes, etc.)
Horario de recolección (6:00 AM - 12:00 PM, etc)
Tipo de residuo a recolectar (orgánico, inorgánico, mixto)
Generación Dinámica de Basura:

Cuando se asigna una ruta a un camión, el sistema genera automáticamente:
Cantidad de puntos de recolección en esa ruta (entre 15-30 puntos aleatorios)
Volumen estimado de basura por punto (entre 50-500 kg)
Total estimado de basura en la ruta (suma de todos los puntos)
La generación considera:
Densidad poblacional de la zona (residencial, comercial, industrial)
Día de la semana (fines de semana pueden tener más basura)
Historial previo de recolección en esa ruta
Los puntos de basura se distribuyen aleatoriamente a lo largo de la ruta trazada
Cada punto se visualiza en el mapa con marcador identificador
Asignación de Camiones:

Registrar camiones recolectores con:
Placa/identificador
Capacidad de carga (toneladas)
Estado del vehículo (operativo, en mantenimiento, fuera de servicio)
Conductor asignado
Asignar camión a ruta específica
Validar que capacidad del camión sea suficiente para la ruta
Proceso de Recolección:

Estados de recolección:
Programada: Ruta asignada, esperando inicio
En proceso: Camión recorriendo la ruta
Completada: Recolección finalizada
Incompleta: Ruta no finalizada por problemas
Registrar:
Hora de inicio y finalización
Basura efectivamente recolectada (en toneladas)
Observaciones del conductor
Incidencias durante el recorrido
Consulta Ciudadana de Rutas:

Portal público con mapa interactivo donde ciudadanos pueden:
Ver todas las rutas de recolección en el mapa
Filtrar rutas por zona/colonia
Ver calendario y horarios de cada ruta
Visualizar la ruta completa que pasa por su dirección
Identificar el día y hora aproximada en que pasará el camión
2. Módulo de Puntos Verdes (Reciclaje)
Gestión de Puntos de Reciclaje:

Registrar ubicaciones de puntos verdes:
Nombre del punto
Dirección completa
Coordenadas GPS (obligatorio)
Ubicación seleccionada directamente en el mapa
Visualización de todos los puntos verdes en mapa general
Capacidad total en metros cúbicos
Horario de atención
Encargado del punto
Tipos de Materiales Reciclables:

Papel y cartón
Plástico (PET, HDPE, etc.)
Vidrio
Metal (aluminio, hierro)
Orgánico (compostaje)
Electrónicos (opcional)
Registro de Entregas:

Ciudadanos entregan material reciclable
El operador registra:
Tipo de material
Cantidad (en kilogramos)
Fecha y hora de entrega
Código de ciudadano (opcional: sistema de incentivos)
Actualización automática del nivel de llenado
Control de Contenedores:

Cada tipo de material tiene su contenedor
Porcentaje de llenado (0-100%)
Notificaciones automáticas:
Al 75%: Alerta temprana
Al 90%: Notificación urgente para vaciado
Al 100%: Contenedor lleno, requiere atención inmediata
Programar vaciado de contenedores
3. Módulo de Denuncias Ciudadanas
Registro de Denuncias:

Formulario ciudadano con:
Ubicación del basurero clandestino (dirección o mapa)
Foto del lugar (upload de imagen)
Descripción del problema
Tamaño estimado del basurero (pequeño, mediano, grande)
Datos del denunciante (nombre, teléfono, email)
Fecha de la denuncia
Gestión de Denuncias:

Estados:
Recibida: Denuncia ingresada, pendiente de revisión
En revisión: Coordinador evaluando la situación
Asignada: Cuadrilla designada para limpieza
En atención: Trabajo de limpieza en proceso
Atendida: Limpieza completada
Cerrada: Caso finalizado y verificado
Asignar cuadrilla de limpieza:
Seleccionar equipo disponible
Programar fecha de intervención
Estimar recursos necesarios
Seguimiento:

Ciudadano puede consultar estado de su denuncia
Notificaciones por email cuando cambia el estado
Fotos del antes y después de la limpieza
4. Módulo de Reportes
Reportes de Recolección:

Toneladas de basura recolectada:
Por día, semana, mes
Por zona/colonia
Por ruta específica
Comparativas mensuales/anuales
Reportes de Reciclaje:

Cantidad de material reciclado por tipo
Puntos verdes más activos
Tendencias de reciclaje ciudadano
Comparativa entre materiales
Reportes de Denuncias:

Denuncias atendidas vs pendientes
Tiempo promedio de atención
Zonas con mayor cantidad de denuncias
ROLES DEL SISTEMA
Administrador Municipal
Acceso total al sistema
Gestión de usuarios y permisos
Configuración general del sistema
Generación de reportes estratégicos
Auditoría de actividades
Coordinador de Rutas
Planificación de rutas de recolección
Asignación de camiones y conductores
Monitoreo en tiempo real de recolección
Resolución de incidencias
Reportes operativos
Operador de Punto Verde
Registro de entregas de material reciclable
Control de nivel de contenedores
Solicitar vaciado de contenedores
Atención a ciudadanos
Ciudadano
Consulta de horarios y rutas de recolección
Reporte de basureros clandestinos
Seguimiento de denuncias propias
Consulta de puntos verdes cercanos
Visualización de estadísticas públicas
Auditor
Consulta de todos los reportes
Validación de información registrada
Exportación de datos para análisis
Sin permisos de modificación
REQUISITOS TÉCNICOS
Backend:

PHP 7.4 o superior (Laravel opcional)
XAMPP (Apache + MySQL)/Cualquier servidor y DBMS de su preferencia
Arquitectura N-Capas:
Capa de Presentación (Views)
Capa de Lógica de Negocio (Controllers/Services)
Capa de Acceso a Datos (Models/DAO)
Frontend:

HTML5, CSS3, JavaScript ES6+
Framework de su Preferencia (Pueden usar solo laravel si lo desean)
Seguridad:

Contraseñas encriptadas (password_hash)
Control de acceso basado en roles
Control de Versiones:

Git/GitHub
Commits descriptivos y frecuentes
Entregables:
ENTREGABLE 1: Análisis y Diseño del Sistema
Contenido:

Diagramas UML:
Diagrama de Casos de Uso (por cada rol)
Diagrama de Clases
Diagrama de Secuencia (para procesos principales)
Diagrama de Despliegue
Diagrama de Paquetes/Componentes
Modelo de Base de Datos:
Diagrama Entidad-Relación
Modelo Relacional normalizado
Diccionario de datos
Arquitectura del Sistema:
Diagrama de arquitectura N-Capas
Descripción de cada capa
Tecnologías a utilizar
Formato: Documento PDF profesional con índice, numeración de páginas.

Fecha de Entrega Entregable 1:
24 de Febrero del 2026 a las 23:59 horas

ENTREGABLE 2: Implementación del Sistema
Contenido:

Código Fuente:
Repositorio GitHub organizado
Mínimo 15 commits significativos con mensajes descriptivos
Estructura de carpetas clara (N-Capas)
Base de Datos (No aplica si usa migraciones y seeds):
Script SQL completo de creación
Script de inserción de datos de prueba realistas:
Al menos 5 zonas/colonias
8-10 rutas predefinidas
5 camiones
6-8 puntos verdes
15-20 denuncias de ejemplo
3-5 usuarios por rol
Procedimientos almacenados (si aplica)
Sistema Funcional:
Aplicación web completamente operativa
Implementación de todos los módulos descritos
Validaciones del lado cliente y servidor
Manual de Usuario
Manual Técnico
Fecha de Entrega Entregable 2:
11 de Marzo del 2026 a las 23:59 horas