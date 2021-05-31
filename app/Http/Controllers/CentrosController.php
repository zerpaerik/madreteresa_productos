<?php

namespace App\Http\Controllers;

use App\Roles;
use App\User;
use App\Centros;
use Illuminate\Http\Request;

class CentrosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $centros = Centros::where('estatus','=',1)->get();
        return view('centros.index', compact('centros'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('centros.create');

        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

   
        $centros = new Centros();
        $centros->nombre =$request->nombre;
        $centros->direccion =$request->direccion;
        $centros->referencia =$request->referencia;
        $centros->save();

        return redirect()->action('CentrosController@index', ["created" => true, "centros" => Centros::all()]);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function show(Roles $roles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $centros = Centros::find($id);
        return view('centros.edit', compact('centros')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $personal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $personal)
    {

      $centros = Centros::find($request->id);
      $centros->nombre =$request->nombre;
      $centros->direccion =$request->direccion;
      $centros->referencia =$request->referencia;
      $res = $centros->update();
      return redirect()->action('CentrosController@index');

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $personal = Centros::find($id);
        $personal->estatus = 0;
        $personal->save();

        return redirect()->action('CentrosController@index');

        //
    }
}
