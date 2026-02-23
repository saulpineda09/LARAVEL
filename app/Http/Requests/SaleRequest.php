<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends apiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sale_date' => 'required|date', //el formato eperado es: YYYY-MM-DD (año-mes-dia)
            'email'=> 'required|email', 
            'concepts' => 'required|array|min:1',
            'concepts.*quantity'=> 'required|numeric|min:1',
            //los asteriscos se utilizan para validar cada elemento del arreglo, 
            //en este caso cada concepto, y luego se especifica el campo que se quiere validar,
            //en este caso quantity y product_id
            'concepts.*.product_id'=>'required|exists:product,id',
            
        ];
    }

    public function messages(){
        return [
            'sale_date.required' => 'La fecha de la venta es requerida',
            'sale_date.date' => 'La fecha de la venta debe ser una fecha válida',
            'email.required' => 'El correo electrónico es requerido',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida',
            'concepts.required' => 'Los conceptos son requeridos',
            'concepts.array' => 'Los conceptos deben ser un arreglo',
            'concepts.min' => 'Debe haber al menos un concepto',
            'concepts.*.quantity.required' => 'La cantidad es requerida para cada concepto',
            'concepts.*.quantity.numeric' => 'La cantidad debe ser un número',
            'concepts.*.quantity.min' => 'La cantidad debe ser al menos 1',
            'concepts.*.product_id.required' => 'El ID del producto es requerido para cada concepto',
            'concepts.*.product_id.exists' => 'El ID del producto debe existir en la tabla de productos',
            
        ];
    }
}
