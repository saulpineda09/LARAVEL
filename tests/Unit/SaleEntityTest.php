<?php

use App\Business\Entities\SaleEntity;
use App\Business\Entities\ConceptEntity;
use App\Models\sale;

test('Creacion de SaleEntity Correctamente', function () {
    $concept1 = new ConceptEntity(quantity: 2, price: 10.5, product_id: 1); 
    $concept2 = new ConceptEntity(quantity: 1, price: 20, product_id: 2);
    $saleEntity = new SaleEntity(id: 1, email: 'test@example.com', sale_date: '2023-01-01 12:00:00', concepts: [$concept1, $concept2]); 

    expect($saleEntity->id)->toBe(1)
        ->and($saleEntity->email)->toBe('test@example.com')
        ->and($saleEntity->sale_date)->toBe('2023-01-01 12:00:00')
        ->and($saleEntity->concepts)->toBeArray()
        ->and($saleEntity->concepts)->toHaveCount(2);
        ;
});

test('Verificar el total de la venta', function(){
    $concept1 = new ConceptEntity(quantity: 3, price: 20, product_id: 1); 
    $concept2 = new ConceptEntity(quantity: 2, price: 15, product_id: 2); 

    $saleEntity = new SaleEntity(id: 1, email: 'test@example.com', sale_date: '2023-01-01 12:00:00', concepts: [$concept1, $concept2]); 
    expect($saleEntity->total)->toBe(90);

});

test('Comprobar SaleEntity sin conceptos con total en $0', function(){
    $saleEntity = new SaleEntity(id: 1, email: 'test@example.com', sale_date: '2023-01-01 12:00:00', concepts: []); 

    expect($saleEntity->total)->toBe(0);
});