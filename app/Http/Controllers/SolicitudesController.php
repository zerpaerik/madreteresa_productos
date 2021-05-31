<?php

namespace App\Http\Controllers;
use App\Equipos;
use App\Requerimientos;
use App\ActivosRequerimientos;
use App\Clientes;
use App\Creditos;
use App\Debitos;
use App\Pacientes;
use App\Solicitudes;
use App\Analisis;
use App\User;
use Auth;
use Illuminate\Http\Request;
use DB;

class SolicitudesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->inicio && $request->fin){


        $solicitudes = DB::table('solicitudes as a')
        ->select('a.id','a.paciente','a.cliente','a.analisis','a.es_pagado','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombres as nompac','b.apellidos as apepac','an.nombre as laboratorio')
        ->join('pacientes as b','b.id','a.paciente')
        ->join('analisis as an','an.id','a.analisis')
        ->where('a.cliente', '=', Auth::user()->empresa)
        ->whereBetween('a.created_at', [$request->inicio, $request->fin])
        ->where('a.estatus', '=', 1)
        ->get(); 
        $f1 = $request->inicio;
        $f2 = $request->fin;
    } else {
        $solicitudes = DB::table('solicitudes as a')
        ->select('a.id','a.paciente','a.cliente','a.analisis','a.es_pagado','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombres as nompac','b.apellidos as apepac','an.nombre as laboratorio')
        ->join('pacientes as b','b.id','a.paciente')
        ->join('analisis as an','an.id','a.analisis')
        ->where('a.cliente', '=', Auth::user()->empresa)
        ->where('a.estatus', '=', 1)
        ->where('a.created_at', '=', date('Y-m-d'))
        ->get(); 

        $f1 =date('Y-m-d');
        $f2 = date('Y-m-d');

    }
        

        return view('solicitudes.index', compact('solicitudes','f1','f2'));
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index1(Request $request)
    {


        if($request->inicio && $request->cliente){

        $solicitudes = DB::table('solicitudes as a')
        ->select('a.id','a.paciente','a.cliente','a.analisis','a.hora','a.es_pagado','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombres as nompac','b.apellidos as apepac','an.nombre as laboratorio', 'c.nombre as nomcli')
        ->join('pacientes as b','b.id','a.paciente')
        ->join('analisis as an','an.id','a.analisis')
        ->join('clientes as c','c.id','a.cliente')
        ->where('a.cliente', '=', $request->cliente)
        ->whereBetween('a.created_at', [$request->inicio, $request->fin])
        ->where('a.estatus', '=', 1)
        ->get(); 
        $f1 = $request->inicio;
        $f2 = $request->fin;
        $cli= $request->cliente;
        } elseif(is_null($request->inicio) && $request->cliente){
            $solicitudes = DB::table('solicitudes as a')
            ->select('a.id','a.paciente','a.cliente','a.analisis','a.es_pagado','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombres as nompac','b.apellidos as apepac','an.nombre as laboratorio', 'c.nombre as nomcli')
            ->join('pacientes as b','b.id','a.paciente')
            ->join('analisis as an','an.id','a.analisis')
            ->join('clientes as c','c.id','a.cliente')
            ->where('a.cliente', '=', $request->cliente)
            ->where('a.estatus', '=', 1)
            ->get(); 

            $f1 = date('Y-m-d');
            $f2 = date('Y-m-d');
            $cli= $request->cliente;


        } elseif($request->inicio && is_null($request->cliente)){
            $solicitudes = DB::table('solicitudes as a')
        ->select('a.id','a.paciente','a.cliente','a.analisis','a.es_pagado','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombres as nompac','b.apellidos as apepac','an.nombre as laboratorio', 'c.nombre as nomcli')
        ->join('pacientes as b','b.id','a.paciente')
        ->join('analisis as an','an.id','a.analisis')
        ->join('clientes as c','c.id','a.cliente')
        ->whereBetween('a.created_at', [$request->inicio, $request->fin])
        ->where('a.estatus', '=', 1)
        ->get(); 

        $f1 = $request->inicio;
        $f2 = $request->fin;
        $cli= "";

            
        }else {
            $solicitudes = DB::table('solicitudes as a')
        ->select('a.id','a.paciente','a.cliente','a.analisis','a.es_pagado','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombres as nompac','b.apellidos as apepac','an.nombre as laboratorio', 'c.nombre as nomcli')
        ->join('pacientes as b','b.id','a.paciente')
        ->join('analisis as an','an.id','a.analisis')
        ->join('clientes as c','c.id','a.cliente')
        //->where('a.cliente', '=', Auth::user()->empresa)
        ->where('a.created_at', '=', date('Y-m-d'))
        ->get(); 

        $f1 = date('Y-m-d');
        $f2 = date('Y-m-d');
        $cli= "";

        

        }


        $clientes = DB::table('clientes as a')
        ->select('a.id','a.nombre')
        ->join('solicitudes as b','b.cliente','a.id')
        ->distinct('a.id')
        ->get(); 


        return view('solicitudes.index1', compact('solicitudes','clientes','f1','f2','cli'));
        //
    }

    public function pagadas(Request $request)
    {

        if($request->inicio && $request->fin){


        $solicitudes = DB::table('solicitudes as a')
        ->select('a.id','a.paciente','a.cliente','a.analisis','a.es_pagado','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombres as nompac','b.apellidos as apepac','an.nombre as laboratorio')
        ->join('pacientes as b','b.id','a.paciente')
        ->join('analisis as an','an.id','a.analisis')
        ->where('a.cliente', '=', Auth::user()->empresa)
        ->whereBetween('a.created_at', [$request->inicio, $request->fin])
        ->where('a.estatus', '=', 1)
        ->where('a.es_pagado', '=', 1)
        ->get(); 
        $f1 = $request->inicio;
        $f2 = $request->fin;
    } else {
        $solicitudes = DB::table('solicitudes as a')
        ->select('a.id','a.paciente','a.cliente','a.analisis','a.es_pagado','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombres as nompac','b.apellidos as apepac','an.nombre as laboratorio')
        ->join('pacientes as b','b.id','a.paciente')
        ->join('analisis as an','an.id','a.analisis')
        ->where('a.cliente', '=', Auth::user()->empresa)
        ->where('a.estatus', '=', 1)
        ->where('a.es_pagado', '=', 1)
        ->where('a.created_at', '=', date('Y-m-d'))
        ->get(); 

        $f1 =date('Y-m-d');
        $f2 = date('Y-m-d');

    }
        

        return view('solicitudes.pagadas', compact('solicitudes','f1','f2'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //$request->pac = 232;
        if(!is_null($request->pac)){
        $paciente = Pacientes::where('dni','=',$request->pac)->where('empresa','=',Auth::user()->empresa)->first();
        $res = 'SI';
        } else {
        $paciente = Pacientes::where('dni','=','LABORATORIO')->first();
        $res = 'NO';
        }

        $analisis = Analisis::where('estatus','=',1)->get();
        //$paciente = Pacientes::where('dni','=',$request->pac)->first();
        //print($paciente);
        return view('solicitudes.create', compact('analisis','paciente','res'));

    }

    public function datapac($id){

       

        $pacientes = DB::table('pacientes as a')
       ->select('a.id','a.dni','a.nombres','a.apellidos','a.direccion','a.telefono','a.fechanac')
       ->where('a.dni','=',$id)
       ->first();

       dd($pacientes);

          // $edad = Carbon::parse($pacientes->fechanac)->age;

       //return $pacientes;

           return view('solicitudes.pacientes',compact('pacientes'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if(!is_null($request->analisis)){
        foreach ($request->analisis as $key => $value) {
        $ana = Analisis::where('id','=',$value)->first();
        $solicitud = new Solicitudes();
        $solicitud->paciente =$request->paciente;
        $solicitud->observacion =$request->observacion;
        $solicitud->hora =$request->hora;
        $solicitud->cliente =Auth::user()->empresa;
        $solicitud->usuario =Auth::user()->id;
        $solicitud->analisis =$value;
        $solicitud->precio =$ana->precio;
        $solicitud->save();

      /*  $creditos = new Creditos();
        $creditos->solicitud =$solicitud->id;
        $creditos->origen ='SOLICITUD';
        $creditos->descripcion ='REGISTRO DE SOLICITUD';
        $creditos->cliente =Auth::user()->empresa;
        $creditos->usuario =Auth::user()->id;
        $creditos->monto =$ana->precio;
        $creditos->save();*/
        }
       }
        

        return redirect()->action('SolicitudesController@index', ["created" => true, "solicitud" => Solicitudes::all()]);

    }

    public function ver($id)
    {
	  
        $solicitudes = DB::table('solicitudes as a')
        ->select('a.id','a.paciente','a.cliente','a.analisis','a.es_pagado','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombres as nompac','b.apellidos as apepac','an.nombre as laboratorio')
        ->join('pacientes as b','b.id','a.paciente')
        ->join('analisis as an','an.id','a.analisis')
        ->where('a.id', '=', $id)
        ->first(); 


     


	  
      return view('solicitudes.ver', compact('solicitudes'));
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

    public function pagar($id)
    {

        $p = Solicitudes::where('id','=',$id)->first();
        $p->es_pagado =1;
        $p->fecha_pago =date('Y-m-d');
        $res = $p->update();

        $creditos = new Creditos();
        $creditos->solicitud =$p->id;
        $creditos->origen ='PAGO DE LABORATORIO';
        $creditos->descripcion ='PAGO DE LABORATORIO';
        $creditos->cliente =$p->cliente;
        $creditos->usuario =Auth::user()->id;
        $creditos->monto =$p->precio;
        $creditos->save();

        $debitos = new Debitos();
        $debitos->solicitud =$p->id;
        $debitos->descripcion ='PAGO DE LABORATORIO';
        $debitos->cliente =Auth::user()->empresa;
        $debitos->usuario =Auth::user()->id;
        $debitos->monto =$p->precio;
        $debitos->save();

      
      return back();

        //
    }

    public function reversar($id)
    {

        $p = Solicitudes::where('id','=',$id)->first();
        $p->es_pagado =0;
        $p->fecha_pago =NULL;
        $res = $p->update();

        $cr = Creditos::where('solicitud','=',$id)->first();
        $cr->delete();

        $de = Debitos::where('solicitud','=',$id)->first();
        $de->delete();

      return back();

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

