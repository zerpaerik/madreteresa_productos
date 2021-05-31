<?php

namespace App\Http\Controllers;

use App\Roles;
use App\User;
use App\Laboratorio;
use Illuminate\Http\Request;

class LaboratorioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $laboratorio = Laboratorio::where('estatus','=',1)->get();
        return view('laboratorio.index', compact('laboratorio'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('laboratorio.create');

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

   
        $lab = new Laboratorio();
        $lab->nombre =$request->nombre;
        $lab->direccion =$request->direccion;
        $lab->referencia =$request->referencia;
        $lab->save();

        return redirect()->action('LaboratorioController@index', ["created" => true, "lab" => Laboratorio::all()]);
    
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
        $lab = Laboratorio::find($id);
        return view('laboratorio.edit', compact('lab')); //
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

      $centros = Laboratorio::find($request->id);
      $centros->nombre =$request->nombre;
      $centros->direccion =$request->direccion;
      $centros->referencia =$request->referencia;
      $res = $centros->update();
      return redirect()->action('LaboratorioController@index');

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

        $personal = Laboratorio::find($id);
        $personal->estatus = 0;
        $personal->save();

        return redirect()->action('LaboratorioController@index');

        //
    }
}
