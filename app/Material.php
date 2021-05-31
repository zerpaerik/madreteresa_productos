<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $table="material";

    protected $fillable = [
        'nombre','usuario','estatus'
    ];

    
    //
}
