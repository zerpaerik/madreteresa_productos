<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debitos extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table="debitos";

    protected $fillable = [
        'descripcion','tipopago','usuario','monto','solicitud','origen','nombre','fecha'
    ];

    
    //
}
