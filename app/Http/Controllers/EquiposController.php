<?php

namespace App\Http\Controllers;
use App\Equipos;
use App\Clientes;
use App\User;
use Auth;
use Illuminate\Http\Request;
use DB;

class EquiposController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $equipos = DB::table('equipos as a')
        ->select('a.id','a.nombre','a.modelo','a.serial','a.estado','b.nombre as empresa')
        ->join('clientes as b','b.id','a.empresa')
        ->where('a.empresa', '=', Auth::user()->empresa)
        ->where('a.estatus', '=', 1)
        ->get(); 

        return view('equipos.index', compact('equipos'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('equipos.create');

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


        $equipos = new Equipos();
        $equipos->nombre =$request->nombre;
        $equipos->descripcion =$request->descripcion;
        $equipos->marca =$request->marca;
        $equipos->serial =$request->serial;
        $equipos->modelo =$request->modelo;
        $equipos->precio =$request->precio;
        $equipos->estado =$request->estado;
        $equipos->empresa = Auth::user()->empresa;
        $fotoequipo = $request->file('foto');
       //obtenemos el nombre del archivo
        $fotoe = $fotoequipo->getClientOriginalName();
        $equipos->foto =$fotoe;
        $equipos->estatus =1;
        $equipos->usuario =Auth::user()->id;
       //indicamos que queremos guardar un nuevo archivo en el disco local
       \Storage::disk('local')->put($fotoe,  \File::get($fotoequipo));
        $equipos->save();

        return redirect()->action('EquiposController@index', ["created" => true, "equipos" => Equipos::all()]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Clientes  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function show(Clientes $Clientes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Clientes  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $equipo = Equipos::find($id);
        return view('equipos.edit', compact('equipo')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Clientes  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clientes $Clientes)
    {

      $p = Equipos::find($request->id);
      $p->nombre =$request->nombre;
      $p->descripcion =$request->descripcion;
      $p->marca =$request->marca;
      $p->serial =$request->serial;
      $p->modelo =$request->modelo;
      $p->precio =$request->precio;
      $p->estado =$request->estado;
      $p->estatus =1;
      $p->usuario =Auth::user()->id;
      $p->empresa = Auth::user()->empresa;
      $res = $p->update();
      return redirect()->action('EquiposController@index');

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Clientes  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $equipos = Equipos::find($id);
        $equipos->estatus = 0;
        $equipos->save();

        return redirect()->action('EquiposController@index');

        //
    }
}

