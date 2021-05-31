<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table="productos";

    protected $fillable = [
        'nombre','descripcion','medida','precio','usuario','cantidad','estatus','foto','minimo','minimol','categoria'
    ];

    
    //
}
