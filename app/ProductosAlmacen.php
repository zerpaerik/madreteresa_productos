<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductosAlmacen extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table="productos_almacen";

    protected $fillable = [
        'producto','cantidad','precio','ingreso','almacen','usuario','vence'
    ];

    
    //
}