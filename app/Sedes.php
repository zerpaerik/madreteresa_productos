<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sedes extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table="sedes";

    protected $fillable = [
        'nombre','direccion',
    ];

    
    //
}