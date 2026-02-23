<?php 
namespace App\Business\Services;

use App\Business\Entities\ConceptEntity;
use App\Business\Entities\SaleEntity;
use App\Http\Requests\SaleRequest;
use App\Models\concept;
use App\Models\Product;
use App\Models\sale;

class CreateSaleService{

    public function create(SaleRequest $request){
        //primero creamos el concepto y luego la venta 
//creamos el concepto con los datos que nos llegan del request y luego creamos la venta con el total que nos da el concepto
        $conceptEntity = []; 
//este foreach es para recorrer el array de conceptos que nos llega del request y crear un nuevo conceptoEntity por cada uno de ellos, ademas de obtener el precio del producto para calcular el total de cada concepto
        foreach($request->concepts as $concepts){
            $conceptEntity[]= new ConceptEntity($concepts["quantity"], Product::find($concepts["product_id"])->price, 
            $concepts["product_id"]); 
        }
        $saleEntity = new SaleEntity(null, $request->email, $request->sale_date, $conceptEntity); 

        //aqui se guarda en el modelo sale la informacion de la venta apartir de la entindad saleEntity y luego se 
        //gurda en la bd
        $sale = sale::create([
            'email' => $saleEntity->email,
            'sale_date' => $saleEntity->sale_date,
            'total' => $saleEntity->total
        ]);
        $sale->save(); 

        //este ciclo es para guardar cada concepto en la bd y relacionarlo con la venta que acabamos de crear 
        foreach($conceptEntity as $conceptEntity){
            $concept = concept::create([
                'quantity' => $conceptEntity->quantity,
                'price' => $conceptEntity->price,
                'product_id' => $conceptEntity->product_id,
                'sale_id' => $sale->id
            ]);
            $concept->save(); 
        }
        $saleEntity->id = $sale->id;
        return $saleEntity;
    }
}