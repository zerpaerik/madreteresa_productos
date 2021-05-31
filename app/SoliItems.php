<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoliItems extends Model
{

    protected $table="solicitudes_items";


    protected $fillable = [
        'descripcion', 'monto', 'solicitud'
    ];
    //
}
