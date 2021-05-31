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
use App\SoliItems;
use App\Analisis;
use App\Productos;
use App\User;
use Auth;
use Illuminate\Http\Request;
use DB;

class CheckinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->inicio){


        $solicitudes = DB::table('solicitudes as a')
        ->select('a.id','a.huesped','a.habitacion','a.es_pagado','a.observacion','a.tiempo','a.inicio','a.fin','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombre as nompac','b.responsable as apepac','an.nombre as laboratorio','cr.tipopago')
        ->join('clientes as b','b.id','a.huesped')
        ->join('analisis as an','an.id','a.habitacion')
        ->join('creditos as cr','cr.solicitud','a.id')
        ->where('a.created_at', '=',$request->inicio )
        ->orderBy('a.id', 'desc')
        ->groupBy('cr.solicitud')
        ->get(); 


        $soli = Solicitudes::where('created_at', '=',$request->inicio)
        ->select(DB::raw('COUNT(*) as cantidad, SUM(precio) as monto'))
        ->first();

        if ($soli->cantidad == 0) {
        $soli->monto = 0;
        }

        $f1 = $request->inicio;
    } else {
        $solicitudes = DB::table('solicitudes as a')
        ->select('a.id','a.huesped','a.habitacion','a.es_pagado','a.tiempo', 'a.observacion','a.inicio','a.fin','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombre as nompac','b.responsable as apepac','an.nombre as laboratorio','cr.tipopago')
        ->join('clientes as b','b.id','a.huesped')
        ->join('analisis as an','an.id','a.habitacion')
        ->join('creditos as cr','cr.solicitud','a.id')
        ->join('solicitudes_items as s','a.id','s.solicitud')
        ->where('a.created_at', '=', date('Y-m-d'))
        ->orderBy('a.id', 'desc')
        ->groupBy('cr.solicitud')
        ->get(); 


        $soli = Solicitudes::where('created_at', '=',date('Y-m-d'))
        ->select(DB::raw('COUNT(*) as cantidad, SUM(precio) as monto'))
        ->first();

        if ($soli->cantidad == 0) {
        $soli->monto = 0;
        }

        $f1 =date('Y-m-d');

    }
        

        return view('checkin.index', compact('solicitudes','f1','soli'));
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
        $paciente = Clientes::where('identificacion','=',$request->pac)->first();
        $res = 'SI';
        } else {
        $paciente = Clientes::where('identificacion','=','LABORATORIO')->first();
        $res = 'NO';
        }

        $productos = Productos::where('estatus','=',1)->get();


        $analisis = Analisis::where('estatus','=',1)->where('disponible','=',0)->get();
        //$paciente = Pacientes::where('dni','=',$request->pac)->first();
        //print($paciente);
        return view('checkin.create', compact('analisis','paciente','res','productos'));

    }


    public function crearhome($id, Request $request)
    {
        //$request->pac = 232;
        if(!is_null($request->pac)){
        $paciente = Clientes::where('identificacion','=',$request->pac)->first();
        $res = 'SI';
        } else {
        $paciente = Clientes::where('identificacion','=','LABORATORIO')->first();
        $res = 'NO';
        }

        $id = $id;

        $productos = Productos::where('estatus','=',1)->get();


        $analisis = Analisis::where('id','=',$id)->first();
        //$paciente = Pacientes::where('dni','=',$request->pac)->first();
        //print($paciente);
        return view('checkin.crearhome', compact('analisis','paciente','res','id','productos'));

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


         $hours = $request->tiempo;
         $fecha= date('Y-m-d H:i:s', (strtotime ("+$hours Hours")));




        $ana =Analisis::where('id','=',$request->habitacion)->first();
        $cli =Clientes::where('id','=',$request->paciente)->first();

        $disp = Analisis::find($request->habitacion);
        $disp->disponible =1;
        $disp->cliente =$cli->nombre.' '.$cli->responsable;
        $disp->ult_ingreso =date('Y-m-d h:m');
        $res = $disp->update();

        $solicitud = new Solicitudes();
        $solicitud->huesped =$request->paciente;
        $solicitud->hora =date('Y-m-d H:i:s');
        $solicitud->observacion =$request->observacion;
        $solicitud->tiempo =$request->tiempo;
        $solicitud->inicio =date('Y-m-d H:i:s');;
        $solicitud->fin =date('Y-m-d H:i:s', (strtotime ("+$request->tiempo Hours")));
        $solicitud->cliente =Auth::user()->empresa;
        $solicitud->usuario =Auth::user()->id;
        $solicitud->habitacion =$request->habitacion;
        if($request->tipopago == 'TJ'){
            $solicitud->precio =$request->precio + $request->precio * 0.1.''.'.00';
            } else {
            $solicitud->precio =$request->precio;
            }
        $solicitud->save();

        $solitem = new SoliItems();
        $solitem->descripcion =$ana->nombre;
        $solitem->monto =$solicitud->precio;
        $solitem->solicitud =$solicitud->id;
        $solitem->save();

        $creditos = new Creditos();
        $creditos->solicitud =$solicitud->id;
        $creditos->origen ='INGRESO';
        $creditos->descripcion ='INGRESO POR'.' '.$ana->nombre;
        $creditos->fecha =date('Y-m-d H:i:s');
        $creditos->nombre =$cli->nombre.' '.$cli->responsable;
        $creditos->usuario =Auth::user()->id;
        $creditos->monto =$solicitud->precio;
        $creditos->tipopago =$request->tipopago; 
        if($request->tipopago == 'TJ'){
            $creditos->tarjeta =$solicitud->precio;
            } else {
            $creditos->efectivo =$solicitud->precio;
            }
        $creditos->save();


        
        if (!is_null($request->id_servicio['servicios'][0]['servicio'])) {
            foreach ($request->id_servicio['servicios'] as $key => $servicio) {
              if (!is_null($servicio['servicio'])) {
                $productos = Productos::where('id','=',$servicio['servicio'])->first();
                $soli = Solicitudes::where('id','=',$solicitud->id)->first();

                $creditoso = new Creditos();
                $creditoso->solicitud =$solicitud->id;
                $creditoso->fecha =date('Y-m-d H:i:s');
                $creditoso->origen ='OTROS INGRESOS';
                $creditoso->nombre =$cli->nombre.' '.$cli->responsable;
                $creditoso->descripcion =$productos->nombre;
                $creditoso->usuario =Auth::user()->id;
                if($request->tipopago == 'TJ'){
                    $creditoso->monto = (float)$request->monto_s['servicios'][$key]['monto'] + (float)$request->monto_s['servicios'][$key]['monto'] * 0.1;
                    $creditoso->tarjeta = (float)$request->monto_s['servicios'][$key]['monto'] + (float)$request->monto_s['servicios'][$key]['monto'] * 0.1;
                } else {
                    $creditoso->monto =$request->monto_s['servicios'][$key]['monto'];
                    $creditoso->efectivo =$request->monto_s['servicios'][$key]['monto'];
                    }
                $creditoso->tipopago =$request->tipopago;
                $creditoso->save();

                $solitem = new SoliItems();
                $solitem->descripcion =$productos->nombre;
                $solitem->monto =$creditoso->monto;
                $solitem->solicitud =$solicitud->id;
                $solitem->save();

               $solicitud = Solicitudes::find($solicitud->id);
               $solicitud->observacion =$soli->observacion.' + '.$productos->nombre;
               $solicitud->precio =$soli->precio + $creditoso->monto;
               $res = $solicitud->update();

               $productccc = Productos::where('id','=',$servicio['servicio'])->first();

               $productosd = Productos::find($servicio['servicio']);
               $productosd->cantidad =$productccc->cantidad - 1;
               $res = $productosd->update();
      
              } else {
      
              }
            }
          }



          return redirect()->action('CheckinController@index')
          ->with('success','Registrado Exitosamente!');
    }

    public function ver($id)
    {
	  
        $solicitudes = DB::table('solicitudes as a')
        ->select('a.id','a.huesped','a.cliente','a.habitacion','a.es_pagado','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombre as nompac','b.responsable as apepac','an.nombre as laboratorio')
        ->join('clientes as b','b.id','a.huesped')
        ->join('analisis as an','an.id','a.habitacion')
        ->where('a.id', '=', $id)
        ->first(); 


     
      return view('checkin.ver', compact('solicitudes'));
    }	


    public function edit($id)
    {
	  
        $solicitudes = DB::table('solicitudes as a')
        ->select('a.id','a.huesped','a.cliente','a.habitacion','a.es_pagado','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombre as nompac','b.responsable as apepac','b.identificacion','an.nombre as laboratorio','cr.tipopago')
        ->join('clientes as b','b.id','a.huesped')
        ->join('analisis as an','an.id','a.habitacion')
        ->join('creditos as cr','cr.solicitud','a.id')
        ->where('a.id', '=', $id)
        ->first(); 

        $analisis = Analisis::where('estatus','=',1)->where('disponible','=',0)->get();

      return view('checkin.edit', compact('solicitudes','analisis'));
    }	


    public function recargar($id)
    {
	  
        $solicitudes = DB::table('solicitudes as a')
        ->select('a.id','a.huesped','a.cliente','a.habitacion','a.es_pagado','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombre as nompac','b.responsable as apepac','b.identificacion','an.nombre as laboratorio','cr.tipopago')
        ->join('clientes as b','b.id','a.huesped')
        ->join('analisis as an','an.id','a.habitacion')
        ->join('creditos as cr','cr.solicitud','a.id')
        ->where('a.id', '=', $id)
        ->first(); 

        $analisis = Analisis::where('id','=',$solicitudes->habitacion)->first();

        $cliente = Clientes::where('id','=',$solicitudes->huesped)->first();


      return view('checkin.recargar', compact('solicitudes','analisis','cliente'));
    }	

    public function update(Request $request)
    {


        $ana =Analisis::where('id','=',$request->habitacion)->first();
        $cli =Clientes::where('id','=',$request->paciente)->first();

        $disp = Analisis::find($request->habitacion);
        $disp->disponible =1;
        $res = $disp->update();

        $solicitud = Solicitudes::find($request->id);
        $solicitud->habitacion =$request->habitacion;
        if($request->tipopago == 'TJ'){
            $solicitud->precio =$ana->precio + $ana->precio * 0.1;
            } else {
            $solicitud->precio =$ana->precio;
            }
        $res = $solicitud->update();


        $solitem = SoliItems::where('solicitud','=',$request->id)->first();
        $solitem->descripcion =$ana->nombre;
        $solitem->monto =$solicitud->precio;
        $res = $solitem->update();

        $creditos = Creditos::where('solicitud','=',$request->id)->first();
        $creditos->descripcion ='INGRESO POR'.' '.$ana->nombre;
        $creditos->monto =$solicitud->precio;
        $creditos->fecha =date('Y-m-d H:i:s');
        $creditos->tipopago =$request->tipopago;
        if($request->tipopago == 'TJ'){
            $creditos->tarjeta =$solicitud->precio;
            } else {
            $creditos->efectivo =$solicitud->precio;
            }
        $res = $creditos->update();

      
        return redirect()->action('CheckinController@index')
        ->with('success','Modificado Exitosamente!');
        //
    }

    public function recarga(Request $request)
    {




        $soli = DB::table('solicitudes as a')
        ->select('a.id','a.huesped','a.cliente','a.tiempo','a.inicio','a.fin','a.habitacion','a.es_pagado','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombre as nompac','b.responsable as apepac','an.nombre as laboratorio','b.email','b.telefono','b.identificacion','cr.tipopago')
        ->join('clientes as b','b.id','a.huesped')
        ->join('analisis as an','an.id','a.habitacion')
        ->join('creditos as cr','cr.solicitud','a.id')
        ->where('a.id', '=',$request->id)
        ->first(); 

        

       
        $solicitud = Solicitudes::find($request->id);
        $solicitud->tiempo =$soli->tiempo + $request->horas;
        $solicitud->fin =date('Y-m-d H:i:s', (strtotime ("+$solicitud->tiempo Hours")));;
        if($soli->tipopago == 'TJ'){
            $solicitud->precio =$soli->precio + $request->precio * 0.1.''.'.00';
            } else {
            $solicitud->precio =$soli->precio + $request->precio;
            }
        $res = $solicitud->update();


        $solitem = SoliItems::where('solicitud','=',$request->id)->first();
        $solitem->monto =$solicitud->precio;
        $res = $solitem->update();

        $creditos = Creditos::where('solicitud','=',$request->id)->first();
        $creditos->monto =$solicitud->precio;
        $res = $creditos->update();

      
        return redirect()->action('CheckinController@index')
        ->with('success','Recargado Exitosamente!');
        //
    }
    
    
    
    
    public function ticket($id)
    {


        $checkin = DB::table('solicitudes as a')
        ->select('a.id','a.huesped','a.cliente','a.habitacion','a.es_pagado','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombre as nompac','b.responsable as apepac','an.nombre as laboratorio','b.email','b.telefono','b.identificacion','cr.tipopago')
        ->join('clientes as b','b.id','a.huesped')
        ->join('analisis as an','an.id','a.habitacion')
        ->join('creditos as cr','cr.solicitud','a.id')
        ->where('a.id', '=', $id)
        ->first(); 


        $items = DB::table('solicitudes_items as a')
        ->select('a.id','a.descripcion','a.monto','a.solicitud')
        ->where('a.solicitud', '=', $id)
        ->get(); 

        $total = SoliItems::where('solicitud', $id)
         ->select(DB::raw('SUM(monto) as monto'))
         ->first();

        $view = \View::make('checkin.ticket',compact('items','total','checkin'));

        $customPaper = array(0,0,500.00,200.00);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper($customPaper, 'landscape');
     
       
        return $pdf->stream('ticket-checkin'.'.pdf');
       
    }	  



    public function delete($id)
    {

        $soli = Solicitudes::where('id','=',$id)->first();

        $disp = Analisis::where('id','=',$soli->habitacion)->first();
        $disp->disponible =0;
        $disp->pedido =null;
        $disp->cliente ='';
        $disp->ult_ingreso ='';
        $res = $disp->update();

        $solicitudes = Solicitudes::where('id','=',$id)->first();
        $solicitudes->delete();


        $items = SoliItems::where('solicitud','=',$id)->first();
        $items->delete();

        $creditos = Creditos::where('solicitud','=',$id)->first();
        $creditos->delete();


        return redirect()->action('CheckinController@index')
        ->with('success','Eliminada Exitosamente!');

        //
    }


   

}

