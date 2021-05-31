<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siniestros extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table="siniestros";

    protected $fillable = [
        'solicitud','observacion','precio','tipopago','usuario'
    ];

    
    //
}
