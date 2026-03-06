#!/bin/bash

# Rehace la base de datos limpiando y creando todas las tablas desde cerooo
php artisan migrate:fresh

# Siembra la base de datos con información por defecto (cuando esté hecho xd)
# php artisan db:seed

# Mensaje de exito
echo "Base de datos creada exitosamente :D!!"
