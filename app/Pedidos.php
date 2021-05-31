<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table="pedidos";

    protected $fillable = [
        'solicitud','descripcion','monto','estatus','usuario','tipopago','producto'
    ];

    
    //
}
