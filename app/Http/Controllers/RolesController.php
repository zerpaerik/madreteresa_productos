<?php

namespace App\Http\Controllers;

use App\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $roles = Roles::all();
        return view('roles.index', compact('roles'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('roles.create');

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

       // dd($request->all());

        $rol = new Roles();
        $rol->nombre =$request->nombre;
        $rol->descripcion =$request->descripcion;
        $rol->save();

        return redirect()->action('RolesController@index', ["created" => true, "rol" => Roles::all()]);

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
        $rol = Roles::find($id);
        return view('roles.edit', compact('rol')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Roles $roles)
    {

      $p = Roles::find($request->id);
      $p->nombre = $request->nombre;
      $p->descripcion = $request->descripcion;
      $res = $p->update();
      return redirect()->action('RolesController@index');

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

        $rol = Roles::find($id);
        $rol->delete();

        return redirect()->action('RolesController@index');

        //
    }
}
