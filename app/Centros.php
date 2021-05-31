<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Centros extends Model
{

    protected $table="centros";

    protected $fillable = [
        'nombre', 'direccion', 'referencia', 'usuario','estatus'
    ];
    //
}
