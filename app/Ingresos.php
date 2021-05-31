<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingresos extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table="ingresos";

    protected $fillable = [
        'factura','fecha','observacion','usuario','estatus'
    ];

    
    //
}
