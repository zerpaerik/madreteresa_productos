<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productosl extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table="productosl";

    protected $fillable = [
        'nombre','descripcion','categoria','usuario','cantidad','estatus'
    ];

    
    //
}
