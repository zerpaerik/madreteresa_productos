<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresosDetalle extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table="ingresos_detalle";

    protected $fillable = [
        'ingreso','producto','cantidad','precio','estatus','vence','usuario_elimina'
    ];

    
    //
}