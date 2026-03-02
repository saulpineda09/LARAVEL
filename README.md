# LARAVEL
Laravel es un framework de desarrollo web en PHP, es decir, un conjunto de herramientas, librerías y reglas que te ayudan a crear aplicaciones web de forma más rápida, organizada y segura que si escribieras todo el código PHP desde cero.

Lo primero que se debe hacer es: 
- instalar composer  
Una vez instalado debemos instalar laravel de forma global para no tener ningun problema, lo hacemos con el siguiente comando:

```bash
composer  global require laravel/installer
```
----
# CREAR UN PROYECTO POR TERMINAL 
```bash
Laravel new <name_proyect>
```
----
# CORRER UN SERVIDOR PHP POR CONSOLA 
```bash
php -S localhost:8080 -t public 
```
----
Para correr el sistema y ver que funciona debemos tomar en cuenta varios factores:  
- Tener encendido xamp
- revisar el archivo .env que esta en la raiz del proyecto que creaste
- crear la BD en phpmyAdmin con el mismo nombre que viene en ese archivo en la parte de BD
- usar el puerto correspondiente (en mi caso es el 3307)
----

# CREAR UN CONTROLADOR EN LARAVEL 
```bash
php artisan make:controller MiControlador
```

# EJECUTAR MIGRACIONES 

```bash
php artisan migrate 
```
Es una herramienta de Laravel para crear las tablas de la base de datos automáticamente según lo que hayas definido en tus archivos de migraciones.


## ¿Qué hace? 
1. **Busca las migraciones**   
Laravel guarda en la carpeta database/migrations archivos que definen cómo deben crearse las tablas (usuarios, sesiones, posts, etc.).
2. **Ejecuta esas instrucciones en la base de datos**  
Crea las tablas con sus columnas, tipos de datos, índices y relaciones
3. **Lleva un control de qué migraciones se han aplicado**  
Laravel guarda en la tabla migrations un registro de todas las migraciones ya ejecutadas para no repetirlas.

## ¿Para que sirve? 
1. Evita escribir SQL a mano cada vez que creas una tabla.
2. Permite versionar tu base de datos, ideal si trabajas en equipo.
3. Facilita migrar cambios a producción sin perder datos.
4. Con el mismo comando puedes deshacer migraciones si algo salió mal (php artisan migrate:rollback).
----
# CREAR UNA MIGRACION 
Por ejemplo, si quiero crear una nueva tabla llamada ```product```

```bash
php artisan make:migration create_product_table
```

podemos agregar nuevos atributos a la tabla en el metodo up:  
[![up.jpg](https://i.postimg.cc/NfKVSYrc/up.jpg)](https://postimg.cc/9rjJw6p8)  

Y para que esos cambios se actualicen en la bd tenemos que ejecutar el comando visto anteriormente:  
```bash
php artisan migrate 
```
----
# CREAR FOREIGN KEY CON MIGRACIONES 

---- 
# REVERTIR MIGRACIONES 
```bash
php artisan migrate:rollback
```
----


# CREAR UN SEEDER 
En Laravel, un Seeder sirve para insertar datos automáticamente en tu base de datos, ya sea datos de prueba (dummy data) o datos iniciales necesarios para que la aplicación funcione.

Piensa en él como un script que llena la base de datos sin que tengas que escribir cada registro a mano.  

```bash
php artisan make:seeder (nobre de la tabla)
```
----
# EJECUTAR TODOS LOS SEEDER
```bash
php artisan make:seeder
```
----
# EJECUTAAR UN SOLO SEEDER 
```bash
php artisan db:seed --class=ProductTableSeeder
```
----
# BORRAR Y RECONSTRUIR LA BD CON SEEDER 
Esto lo que hace borrar totalmente todas las tablas y volverlas a crear con --seed 
```bash
php artisan migrate:fresh --seed
```
----
# CREAR MODELOS 
```bash
php artisan make:model (nombre de la tabla) 
```
# CREAR UN FACTORY

```bash
php artisan make:factory (nombre del factory)
```
# CREAR RESOURCE 

```bash
php artisan make:resource RolResource
```
# CREAR UN COLLECTION 

```bash
php artisan make:resource RolCollection
```

# CREAR UN REQUEST 

```bash
php artisan make:request UpdateProductRequest
```
# MIDDLEWARE  
Un middleware en Laravel (y en general en frameworks web) es como un filtro o guardia que se ejecuta antes o después de que una petición llegue a tu controlador. 


## Funciones principales del middleware  
1. Autenticación y autorización
   - Verifica si el usuario tiene un token válido.
   - Checa si el usuario tiene permisos para acceder a un recurso (puedes bloquear algunos endpoints para ciertos usuarios con roles)
2. Validaciones globales
    - Rechazar peticiones si no cumplen con ciertas reglas.  
    ```jemplo: evitar acceso desde ciertas IPs.```
3. Transformar la petición o respuesta
    - Modificar headers, sanitizar datos o añadir información extra.
    
4. Manejo de logs
    - Registrar cada petición (quién accede, cuándo, qué hizo).
5. Seguridad
     - Evitar ataques como CSRF, XSS, etc.
     - Forzar uso de HTTPS.

**El codigo para crear un Meddleware es:**  
```bash
 php artisan make:middleware checkValueInHeder
```
 ## Ejemplo de middleware 
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role = null)
    {
        $user = $request->user();

        // Si no hay usuario autenticado
        if (! $user) {
            return redirect()->route('login');
        }

        // Si el usuario no tiene el rol necesario
        if ($role && ! $user->hasRole($role)) {
            // Puedes devolver 403 o redireccionar
            abort(403, 'No tienes permiso para acceder a este recurso.');
        }

        // Continuar con la petición
        return $next($request);
    }
}
```
y para agregarlo en el endpoint, se le agrega -> middleware("nombre o alias del middleware"::class): 
```php
Route::apiResource("/product", ProductController::class)->middleware([LogRequests::class]);
```
# EJECUTAR COLAS 
```
php artisan queue:work
```

# Crear un nuevo comando 
```
php artisan make:command <nombre de  mi comando>
```

# Mostrar todos los comandos  
```
php artisan list 
```
