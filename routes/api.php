<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QueriesController;
use App\Http\Controllers\SaleController;
use App\Http\Middleware\checkValueInHeder;
use App\Http\Middleware\LogRequests;
use App\Http\Middleware\UpperCaseName;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;  

use function Pest\Laravel\get;

Route::get("/test", function(){
    return "el backend funciona correctamente"; 
});

//el alias y los meddleware se checan en la carpteta app/Middleware y en bootstrap/cache/app 
Route::get("/backend", [BackendController::class, "getAll"])
->middleware("checkValue: 4545, pato"); //endpoint para obtener todos los registros 


//endpoint para obtener uno solo o por id 
Route::get("/backend/{id}", [BackendController::class, "get"]); //podemos pasar el id pero se lo indicamos en el controlador
//con el signo ? decimos que el parametro es opcional 

Route::post("/backend", [BackendController::class, "create"]); //endpoint de post para crear uno nuevo 
Route::put("/backend/{id}", [BackendController::class, "update"]); //endpoint put para editar(es necesario pasar el id)
Route::delete("/backend/{id}", [BackendController::class, "delete"]); //endpoint put eliminar 

Route::get("/query",[QueriesController::class, "get"]); //obtiene los valores que pediremos en la clase QueriesController 
Route::get("/query/{id}",[QueriesController::class, "getById"]); //obtiene los valores por id 


Route::get("/query/method/names",[QueriesController::class, "getNames"]); //endpoint que busca por name

Route::get("/query/method/search/{name}/{price}",[QueriesController::class, "searchNames"]); //buscar por nombre y precio
Route::get("/query/method/searchString/{value}",[QueriesController::class, "searchString"]); //endpoint que busca por valor 

Route::post("/query/method/advancedSearch",[QueriesController::class, "advancedSearch"]); //busqueda avanzada 
Route::get("/query/method/join",[QueriesController::class, "join"]);
Route::get("/query/method/groupby",[QueriesController::class, "groupBy"]);


//EndPoint que va tener todos los metodos http
//apiResource ya tiene todos los metodos pero debemos cumplir con la documentacion exacta
//metodos para get => index
//post => create
//put =>
Route::apiResource("/product", ProductController::class);
//->middleware(["jwt.auth",LogRequests::class]);// comentamos por un momento el middleware para probar los tests  

//podemos poner varios middleware en un endpoint  
//el middleware solo va funcionar para este metodo pero ahora necesitamos estar logeados para acceder a los productos 


//rutas para el registro y el login de usuarios
Route::post('/register', [AuthController::class, 'register']); 
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware("jwt.auth")->group(function(){
    Route::get('who', [AuthController::class, 'who']); 
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']); 
}); 

Route::get("/info/message", [InfoController::class, "message"]); //endpoint para probar el servicio de saludo
Route::get("/info/tax/{id}", [InfoController::class, "iva"]); 
Route::get("/info/encrypt/{data}", [InfoController::class, "encrypt"]); 
Route::get("/info/decrypt/{data}", [InfoController::class, "decrypt"]);
Route::get("/info/encryptEmail/{id}", [InfoController::class, "encryptEmail"]); 
Route::get("/info/singleton", [InfoController::class, "singleton"]);
Route::get("/info/encryptEmail2/{id}", [InfoController::class, "encryptEmail2"]);
 
Route::get("/api", [ApiController::class, "get"]); 

Route::get("/sale", [SaleController::class, "get"]);
Route::post("/sale", [SaleController::class, "create"]);
