<?php
namespace App\Business\Entities\ConceptEntity;

use App\Business\Entities\ConceptEntity;

test('Creacion Correcta', function () {
    //crear una instancia de ConceptEntity con valores de prueba
    $conceptEntity = new ConceptEntity(quantity: 2, price: 10.5, product_id: 1);

    //verificar que los atributos se asignaron correctamente y que el total se calculo correctamente
    expect($conceptEntity->quantity)->toBe(2)
    ->and($conceptEntity->price)->toBe(10.5)
    ->and($conceptEntity->product_id)->toBe(1)
    ->and($conceptEntity->total)->toBe(21.0);
});

//test para verificar que el total se calcula correctamente
test('Calcular total', function(){
    $conceptEntity = new ConceptEntity(quantity: 3, price: 15, product_id: 1);
    expect($conceptEntity->total)->toBe(45.0);
});


