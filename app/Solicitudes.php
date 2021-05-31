<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitudes extends Model
{

    protected $table="solicitudes";


    protected $fillable = [
        'huesped', 'cliente', 'habitacion', 'precio', 'observacion', 'usuario','tiempo', 'estatus', 'estado','hora','es_pagado','fecha_pago'
    ];
    //
}
