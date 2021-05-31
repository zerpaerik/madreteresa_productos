<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductosUsados extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table="productos_usados";

    protected $fillable = [
        'producto','cantidad','usuario','almacen','usuario','fecha','estatus','eliminado_por'
    ];

    
    //
}
