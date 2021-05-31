<?php

namespace App\Http\Controllers;
use App\Equipos;
use App\Analisis;
use App\Clientes;
use App\Creditos;
use App\Tiempo;
use App\Material;
use App\Siniestros;
use App\User;
use Auth;
use Illuminate\Http\Request;
use DB;

class IngresosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->inicio){

        $ingresos = DB::table('creditos as a')
        ->select('a.id','a.origen','a.descripcion','a.monto','a.nombre','a.usuario','a.cliente','a.created_at','b.name')
        ->join('users as b','b.id','a.usuario')
        ->where('a.origen', '=', 'OTROS INGRESOS')
        ->where('a.created_at','=',$request->inicio)
        ->get(); 
        $f1 = $request->inicio;


        
        $ing = Creditos::where('created_at', '=',$request->inicio)
        ->where('origen', '=', 'OTROS INGRESOS')
        ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
        ->first();

        if ($ing->cantidad == 0) {
        $ing->monto = 0;
        }
        } else {
            $ingresos = DB::table('creditos as a')
            ->select('a.id','a.origen','a.descripcion','a.nombre','a.monto','a.usuario','a.cliente','a.created_at','b.name')
            ->join('users as b','b.id','a.usuario')
            ->where('a.origen', '=', 'OTROS INGRESOS')
            ->where('a.created_at', date('Y-m-d'))
            ->get(); 

            $f1 =date('Y-m-d');

            
        $ing = Creditos::where('created_at', '=',$f1)
        ->where('origen', '=', 'OTROS INGRESOS')
        ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
        ->first();

        if ($ing->cantidad == 0) {
        $ing->monto = 0;
        }
            
        }

        return view('ingresos.index', compact('ingresos','f1','ing'));
        //
    }

    public function solicitudes(){
     
        $solicitudes = DB::table('solicitudes as a')
        ->select('a.id','a.huesped','a.cliente','a.habitacion','a.es_pagado','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombre as nompac','b.responsable as apepac','an.nombre as hab')
        ->join('clientes as b','b.id','a.huesped')
        ->join('analisis as an','an.id','a.habitacion')
        ->where('a.estatus', '=', 1)
        ->get();
 
     return view('ingresos.solicitudes', compact('solicitudes'));
   }

   public function otros(){
     
    $solicitudes = DB::table('solicitudes as a')
    ->select('a.id','a.huesped','a.cliente','a.habitacion','a.es_pagado','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombre as nompac','b.responsable as apepac','an.nombre as hab')
    ->join('clientes as b','b.id','a.huesped')
    ->join('analisis as an','an.id','a.habitacion')
    ->where('a.estatus', '=', 1)
    ->get();

 return view('ingresos.otros', compact('solicitudes'));
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ingresos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $ingresos = new Creditos();
        if($request->causa == 2){
            $ingresos->descripcion ='SINIESTRO:'.' '.$request->descripcion;
        } else {
            $ingresos->descripcion =$request->descripcion;
        }
        $ingresos->origen ='OTROS INGRESOS';
        $ingresos->fecha =date('Y-m-d H:i:s');
        $ingresos->nombre =$request->nombre;
        $ingresos->tipopago =$request->tipopago;
        if($request->tipopago == 'TJ'){
            $ingresos->tarjeta =$request->monto + $request->monto * 0.1;
            $ingresos->monto =$request->monto + $request->monto * 0.1;
            } else {
            $ingresos->monto =$request->monto;
            $ingresos->efectivo =$request->monto;
            }
        $ingresos->usuario =Auth::user()->id;
        $ingresos->save();


        if($request->solicitud != null){

            $sini = new Siniestros();
            $sini->observacion =$request->descripcion;
            $sini->solicitud =$request->solicitud;
            $sini->precio =$ingresos->monto;
            $sini->tipopago =$request->tipopago;
            $sini->usuario =Auth::user()->id;
            $sini->save();

        }


        return redirect()->action('IngresosController@index', ["created" => true, "ingresos" => Creditos::all()]);

    }

    public function ver($id)
    {
	  
        $req = DB::table('requerimientos as a')
        ->select('a.id','a.asunto','a.prioridad','a.categoria','a.descripcion','a.estatus','a.estado','a.empresa','b.nombre as empresa')
        ->join('clientes as b','b.id','a.empresa')
        ->where('a.estatus', '=', 1)
        ->where('a.id', '=', $id)
        ->first(); 

        //$equipos = ActivosRequerimientos::

        $equipos = DB::table('activos_requerimientos as a')
        ->select('a.id','a.activo','a.ticket','b.nombre','b.modelo','b.serial')
        ->join('equipos as b','b.id','a.activo')
        ->where('ticket','=',$id)
        ->get();


	  
      return view('requerimientos.ver', compact('req','equipos'));
    }	
    
    
    public function ticket($id)
    {


       
        $ingreso = Creditos::where('id', $id)
         ->select('*')
         ->first();

        $view = \View::make('ingresos.ticket',compact('ingreso'));

        $customPaper = array(0,0,500.00,200.00);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper($customPaper, 'landscape');
     
       
        return $pdf->stream('ticket-ingreso'.'.pdf');
       
    }	 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Analisis  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $ingresos = Creditos::where('id','=',$id)->first();

        return view('ingresos.edit', compact('ingresos')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Creditos  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

      $p = Creditos::find($request->id);
      $p->descripcion =$request->descripcion;
      $p->tipopago =$request->tipopago;
      if($request->tipopago == 'TJ'){
        $p->tarjeta =$request->monto + $request->monto * 0.1;
        $p->monto =$request->monto + $request->monto * 0.1;
        } else {
        $p->monto =$request->monto;
        $p->efectivo =$request->monto;
        }
      $res = $p->update();
      return redirect()->action('IngresosController@index');

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Creditos  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $ingresos = Creditos::where('id','=',$id);
        $ingresos->delete();

        return redirect()->action('IngresosController@index');

        //
    }
}

