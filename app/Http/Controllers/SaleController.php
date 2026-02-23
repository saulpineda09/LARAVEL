<?php

namespace App\Http\Controllers;

use App\Business\Entities\ConceptEntity;
use App\Business\Entities\SaleEntity;
use App\Business\Services\CreateSaleService;
use App\Http\Requests\SaleRequest;
use App\Models\concept;
use App\Models\Product;
use App\Models\sale;
use Symfony\Component\HttpFoundation\Response;

class SaleController extends Controller
{

    private $createSaleService;
    public function __construct(CreateSaleService $createSaleService)
    {
        $this->createSaleService = $createSaleService;
    }


    public function get(){
        //retorna un json con los atributos de la venta, osea la clase sale
        //por eso no retorna los conceptos, porque el modelo de la venta no tiene la relacion con los conceptos 
        return response()->json(sale::all(), Response::HTTP_OK); 
    }

    public function create(SaleRequest $request){

    try{
        $saleEntity = $this->createSaleService->create($request);
        return response()->json($saleEntity, Response::HTTP_CREATED); 
     }catch(\Exception $e){
        return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR); 
     }
       
 }
}
