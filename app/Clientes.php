<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{

    protected $fillable = [
        'nombre', 'identificacion', 'direccion', 'responsable', 'telefono', 'email','tipoid'
    ];
    //
}
