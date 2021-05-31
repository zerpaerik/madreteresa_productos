<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cajas extends Model
{

    protected $table="cajas";

    protected $fillable = [
        'usuario_init', 'usuario_fin', 'monto_init', 'monto_fin', 'fecha_init','fecha_fin','estatus'
    ];
    //
}
