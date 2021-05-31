<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipos extends Model
{

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'descripcion', 'marca','modelo', 'serial', 'estatus', 'empresa', 'usuario', 'foto', 'estado', 'precio'
    ];
    //
}
