<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creditos extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table="creditos";

    protected $fillable = [
        'origen','descripcion','tipopago','usuario', 'solicitud','monto','nombre','efectivo','tarjeta','fecha'
    ];

    
    //
}
