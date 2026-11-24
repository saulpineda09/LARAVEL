# 🚀 Laravel — Guía rápida de comandos
 
Referencia corta de los comandos que más se usan en Laravel, con ejemplos listos para copiar.
 
> **Laravel** es un framework de PHP que te da herramientas, estructura y seguridad para crear aplicaciones web más rápido que escribiendo todo desde cero.
 
## 📑 Contenido
 
- [Instalación](#-instalación)
- [Ejecutar el proyecto](#-ejecutar-el-proyecto)
- [Migraciones](#-migraciones)
- [Seeders y Factories](#-seeders-y-factories)
- [Modelos, Controladores y Requests](#-modelos-controladores-y-requests)
- [Resources](#-resources)
- [Middleware](#-middleware)
- [Colas y comandos propios](#-colas-y-comandos-propios)
---
 
## 📦 Instalación
 
Requisitos: **PHP** y **Composer**.
 
```bash
# Instalar el instalador de Laravel (una sola vez)
composer global require laravel/installer
 
# Crear un proyecto
laravel new mi-proyecto
```
 
---
 
## ▶️ Ejecutar el proyecto
 
```bash
cd mi-proyecto
php artisan serve                      # http://127.0.0.1:8000
php -S localhost:8080 -t public        # alternativa con el servidor de PHP
```
 
Antes de correrlo con **XAMPP**:
 
1. Enciende Apache y MySQL.
2. Revisa el archivo `.env` y configura la base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307          # usa el puerto de tu MySQL
DB_DATABASE=mi_bd
DB_USERNAME=root
DB_PASSWORD=
```
3. Crea la base de datos en phpMyAdmin con el **mismo nombre** que pusiste en `DB_DATABASE`.
---
 
## 🗄️ Migraciones
 
Las migraciones **versionan tu base de datos**: crean y modifican tablas con código en lugar de SQL manual. Laravel guarda en la tabla `migrations` cuáles ya se ejecutaron.
 
```bash
php artisan make:migration create_products_table   # crear migración
php artisan migrate                                 # ejecutar pendientes
php artisan migrate:rollback                        # deshacer el último lote
php artisan migrate:fresh --seed                    # borrar todo, recrear y sembrar
```
 
**Ejemplo:** definir columnas en el método `up()`.
 
```php
public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->decimal('price', 8, 2);
        $table->timestamps();
    });
}
```
 
**Llave foránea (foreign key):**
 
```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->foreignId('category_id')->constrained()->cascadeOnDelete();
    $table->timestamps();
});
```
 
---
 
## 🌱 Seeders y Factories
 
Los **seeders** llenan la BD con datos iniciales o de prueba. Los **factories** generan datos falsos.
 
```bash
php artisan make:seeder ProductSeeder
php artisan make:factory ProductFactory
php artisan db:seed                          # ejecutar todos los seeders
php artisan db:seed --class=ProductSeeder    # ejecutar solo uno
```
 
**Ejemplo:**
 
```php
// database/seeders/ProductSeeder.php
public function run(): void
{
    Product::factory()->count(10)->create();
}
```
 
---
 
## 🧱 Modelos, Controladores y Requests
 
```bash
php artisan make:model Product                 # solo el modelo
php artisan make:model Product -mfsc           # + migración, factory, seeder y controller
php artisan make:controller ProductController --api
php artisan make:request StoreProductRequest   # validaciones
```
 
**Ejemplo de Request** con reglas de validación:
 
```php
public function rules(): array
{
    return [
        'name'  => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
    ];
}
```
 
---
 
## 🎁 Resources
 
Dan formato a las respuestas JSON de tu API.
 
```bash
php artisan make:resource ProductResource                 # un registro
php artisan make:resource ProductCollection --collection  # una lista
```
 
```php
// app/Http/Resources/ProductResource.php
public function toArray(Request $request): array
{
    return [
        'id'    => $this->id,
        'name'  => $this->name,
        'price' => $this->price,
    ];
}
```
 
---
 
## 🛡️ Middleware
 
Es un **filtro** que se ejecuta antes o después de llegar al controlador. Se usa para autenticación, roles, logs, headers o forzar HTTPS.
 
```bash
php artisan make:middleware CheckRole
```
 
```php
public function handle(Request $request, Closure $next, ?string $role = null)
{
    $user = $request->user();
 
    if (! $user) {
        return redirect()->route('login');
    }
 
    if ($role && ! $user->hasRole($role)) {
        abort(403, 'No tienes permiso para acceder a este recurso.');
    }
 
    return $next($request);
}
```
 
**Usarlo en una ruta:**
 
```php
use App\Http\Middleware\CheckRole;
 
Route::apiResource('products', ProductController::class)
    ->middleware(CheckRole::class . ':admin');
```
 
> En Laravel 11+ puedes registrar un alias en `bootstrap/app.php` y usarlo como `->middleware('role:admin')`.
 
---
 
## ⚙️ Colas y comandos propios
 
```bash
php artisan queue:work                 # procesar trabajos en cola
php artisan make:command MiComando     # crear un comando propio
php artisan list                       # ver todos los comandos de Artisan
```
 
---
 
💡 **Tip:** agrega `--help` a cualquier comando para ver sus opciones. Ejemplo: `php artisan make:model --help`
```
