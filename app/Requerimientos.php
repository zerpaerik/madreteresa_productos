<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requerimientos extends Model
{

    protected $fillable = [
        'producto', 'almacen_solicita','sede','cantidad_solicita', 'cantidad_despachada', 'estatus', 'usuario', 'usuario_reversa','usuario_elimina'
    ];
    //
}
