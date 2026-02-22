<?php

namespace App\Http\Controllers;

use App\Business\Entities\ConceptEntity;
use App\Business\Entities\SaleEntity;
use App\Http\Requests\SaleRequest;
use App\Models\Product;
use App\Models\sale;
use Symfony\Component\HttpFoundation\Response;

class SaleController extends Controller
{
    public function get(){
        return response()->json(sale::all(), Response::HTTP_OK); 
    }

    public function create(SaleRequest $request){
        $conceptEntity = []; 

        foreach($request->concepts as $concepts){
            $conceptEntity[]= new ConceptEntity($concepts["quantity"], Product::find($concepts["product_id"])->price, 
            $concepts["product_id"]); 
        }
        $saleEntity = new SaleEntity(null, $request->email, $request->sale_date, $conceptEntity); 

        return response()->json(null, Response::HTTP_CREATED); 
    }
}
