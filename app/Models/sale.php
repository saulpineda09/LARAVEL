<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sale extends Model
{
    protected $table = 'sale'; 
    use SoftDeletes;

    //fillable sirve para asignar masivamente 
    protected $fillable = ['email', 'sale_date', 'total', 'user_id']; //el formato esperado para el dia es: (año-mes-dia) YYYY-MM-DD

    protected $hidden=['deleted_at', 'created_at', 'updated_at'];

    //
    public function concepts(){
        //se utiliza hasMany porque una venta puede tener muchos conceptos
        return $this->hasMany(concept::class);
    }
}
