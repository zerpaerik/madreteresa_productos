<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analisis extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table="analisis";

    protected $fillable = [
        'nombre','descripcion','precio','material', 'tiempo','usuario','foto','cliente','ult_ingreso','pedido','costo','porcentaje'
    ];

    
    //
}
