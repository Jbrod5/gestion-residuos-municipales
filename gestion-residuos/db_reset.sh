#!/bin/bash

# Limpiar caché de Laravel para evitar conflictos de rutas o modelos viejos
php artisan config:clear
php artisan cache:clear

# Rehace la base de datos limpiando y creando todas las tablas desde cerooo ademas de agregar los datos por defecto :3
php artisan migrate:fresh --seed

# Mensaje de exito
echo "Base de datos creada exitosamente :D!!"
