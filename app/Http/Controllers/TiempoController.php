<?php

namespace App\Http\Controllers;

use App\Tiempo;
use Illuminate\Http\Request;
use Auth;


class TiempoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tiempo = Tiempo::where('estatus','=',1)->get();
        return view('tiempo.index', compact('tiempo'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('tiempo.create');

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

        $tiempo = new Tiempo();
        $tiempo->nombre =$request->nombre;
        $tiempo->usuario =Auth::user()->id;
        $tiempo->save();

        return redirect()->action('TiempoController@index', ["created" => true, "tiempo" => Tiempo::all()]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tiempo  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function show(Tiempo $tiempo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tiempo  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tiempo = Tiempo::find($id);
        return view('tiempo.edit', compact('tiempo')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tiempo  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

      $p = Tiempo::find($request->id);
      $p->nombre =$request->nombre;
      $res = $p->update();
      return redirect()->action('TiempoController@index');

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tiempo  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request,$id)
    {

        $p = Tiempo::find($request->id);
      $p->estatus =0;
      $res = $p->update();

        return redirect()->action('TiempoController@index');

        //
    }
}
