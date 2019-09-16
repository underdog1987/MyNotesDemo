# My Notes Demo

My Notes Demo es una aplicación sencilla para hacer pequeñas notas y presentarlas con estilo *Post-it* en la página inicial.

# Cómo funciona
  - Para agregar y editar notas se requiere iniciar sesión (Laravel Auth Controller)
  - Un usuario solo piede editar sus propias notas
  - Para ver las notas de todos los usuarios no hace falta estar autenticado

# ¿Por qué la hice?
Porque estoy aprendiendo Laravel (dah!). Traté de hacerla lo mas "*Single Page App*" que puede. 

# To Do
  - Validar los campos de la nota al crear y editar.
  - Eliminar la vuln de Session Hijacking que tiene Laravel.
  
# Instalación
 - Crear una base de datos vacía
 - Clonar el repositorio
 - Crear o editar el archivo .env para configurar la base de datos
 - Con Composer instalado, ir a la carpeta raíz del proyecto y ejecutar
```composer install 
php artisan migrate
php artisan db:seed
```
