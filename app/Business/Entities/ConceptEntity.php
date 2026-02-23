<?php 
//esta clase es para crear una entidad de concepto, que es la que se va a utilizar 
//para crear una venta, esta clase tiene los mismos atributos que la tabla de conceptos, 
//pero tambien tiene un atributo total que se calcula a partir de la cantidad y el precio
namespace App\Business\Entities;
 
 class ConceptEntity{
    public int $quantity; 
    public float $price;
    public int $product_id; 
    public float $total; 

    public function __construct(int $quantity, float $price, int $product_id)
    {
        $this->quantity = $quantity;
        $this->price = $price;
        $this->product_id = $product_id;
        $this->total = $this->calculateTotal(); 
    }

    public function calculateTotal(){
        return $this->total = $this->quantity * $this->price; 
    }

}