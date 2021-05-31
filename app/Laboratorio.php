<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{

    protected $table="laboratorio";

    protected $fillable = [
        'nombre', 'direccion', 'referencia','estatus'
    ];
    //
}
