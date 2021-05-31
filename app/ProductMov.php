<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductMov extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table="product_mov";

    protected $fillable = [
        'producto','cantidad','factura','observacion','usuario','fecha'
    ];

    
    //
}
