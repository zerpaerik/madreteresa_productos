<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table="unidades";

    protected $fillable = [
        'nombre'
    ];

    
    //
}