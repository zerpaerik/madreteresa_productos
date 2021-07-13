<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoProductos extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table="movimiento_productos";

    protected $fillable = [
        'id_producto_almacen','cantidad','accion','usuario'
    ];

    
    //
}