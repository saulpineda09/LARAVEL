<?php

use App\Http\Requests\SaleRequest;
use App\Models\Product;
use App\Business\Services\CreateSaleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;

uses(RefreshDatabase::class);
//esto sirve para limpiar la bd despues de cada test, despues de cada test se ejcuta el metodo refresDatabase
beforeEach(function (){ //en cada test guarda una instancia de servicio 
    $this->service = new CreateSaleService();
});

//en este test se crea la venta y se comprueba que se ha guardado correctamente en la bd
test('Creacion de una venta correctamente', function () {
  $product1 = Product::factory()->create(['price'=>10]); //crea productos 
  $product2 = Product::factory()->create(['price'=>20]);

  $request = new SaleRequest([
    'email' => 'test@example.com', 
    'sale_date' => '2023-01-01 12:00:00',
    'concepts' => [ //una venta tiene varios conceptos, los conceptos son la cantidad de productos que se venden
        ['quantity' => 2, 'product_id' => $product1->id], // 2 * 10 = 20 
        ['quantity' => 1, 'product_id' => $product2->id] // 1 * 20 = 20
    ]
  ]);

   $saleEntity = $this->service->create($request); //ejecuta el servicio para crear la venta

   //el metodo assertDatabaseHas es para comprobar que la bd tiene un registro con los datos que le pasamos
   //en ese caso se comprueban los datos pasados a la tabla sale 
   $this->assertDatabaseHas('sale', [
    'id' => $saleEntity->id,
    'email' => 'test@example.com',
    'sale_date' => '2023-01-01 12:00:00',
    'total' => 40
   ]);

   //sale tiene un campo que se llama concept que es una relacion con la tabla concept
   //por lo tanto se comprueba que la tabla concept tiene los datos que le pasamos
     $this->assertDatabaseHas('concept', [
    'sale_id' => $saleEntity->id,
    'product_id' => $product1->id,
    'quantity' => 2,
    'price' => 10
   ]);

   //se comprueba el segundo concepto de la venta
    $this->assertDatabaseHas('concept', [
    'sale_id' => $saleEntity->id,
    'product_id' => $product2->id,
    'quantity' => 1,
    'price' => 20
   ]);
});

test('Fallo de validacion del request', function (){
    $data = [
        'email'=> '', 
        'sale_date' => '', 
        'concepts' => []
    ];
    //validator es para validar los datos que le pasamos al request, en ese caso 
    //le pasamos datos vacios para que falle la validacion y podamos comprobar que el request esta funcionando
    $validator = Validator::make($data, (new SaleRequest())->rules());
    expect($validator->fails())->toBeTrue();
});
