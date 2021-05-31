<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductosMovl extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table="productosl_mov";

    protected $fillable = [
        'producto','cantidad','factura','observacion','usuario','tipo','fecha'
    ];

    
    //
}