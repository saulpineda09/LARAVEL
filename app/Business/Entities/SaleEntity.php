<?php 
//esta clase es para crear una entidad de venta que es la que se va a utilizar 
//para crear una venta, esta clase tiene los mismos atributos que la tabla de ventas
namespace App\Business\Entities;

class SaleEntity{
    public ?int $id; //el signo ? es para indicar que el id puede ser nulo, ya que cuando creamos una venta no tenemos el id, pero cuando obtenemos una venta si lo tenemos
    public string $email; 
    public string $sale_date; 
    public int $total; 
    public $concepts; 

    public function __construct(?int $id, string $email, string $sale_date, array $concepts){
        $this->id = $id; 
        $this->email = $email; 
        $this->sale_date = $sale_date; 
        $this->concepts = $concepts;
        $this->total = $this->calculateTotal(); 
    }
    public function calculateTotal(){
        $total = 0; 
        foreach($this->concepts as $concepts){
            $total += $concepts->total;
        }
        return $total; 
    }
}