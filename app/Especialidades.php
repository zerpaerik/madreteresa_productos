<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialidades extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table="especialidades";

    protected $fillable = [
        'nombre'
    ];

    
    //
}