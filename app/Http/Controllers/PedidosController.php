<?php

namespace App\Http\Controllers;
use App\Equipos;
use App\Requerimientos;
use App\ActivosRequerimientos;
use App\Clientes;
use App\Creditos;
use App\Debitos;
use App\Pedidos;
use App\Pacientes;
use App\Solicitudes;
use App\Analisis;
use App\User;
use App\Productos;
use Auth;
use Illuminate\Http\Request;
use DB;

class PedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        if($request->inicio && !is_null($request->habitacion)){



        $pedidos = DB::table('pedidos as a')
        ->select('a.id','a.solicitud','a.descripcion','a.tipopago','a.monto','a.created_at','a.estatus','b.huesped','b.habitacion','an.nombre as habita','h.nombre as nompac','h.responsable as apepac')
        ->join('solicitudes as b','b.id','a.solicitud')
        ->join('analisis as an','an.id','b.habitacion')
        ->join('clientes as h','h.id','b.huesped')
        ->where('a.created_at','=',$request->inicio)
        ->where('a.solicitud','=',$request->habitacion)
        ->get(); 

        
        $soli = Pedidos::where('created_at', '=',$request->inicio)
        ->where('solicitud', '=',$request->habitacion)
        ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
        ->first();

        if ($soli->cantidad == 0) {
        $soli->monto = 0;
        }
        $f1 = $request->inicio;
    } else if ($request->inicio && is_null($request->habitacion)){



        
        $pedidos = DB::table('pedidos as a')
        ->select('a.id','a.solicitud','a.descripcion','a.tipopago','a.monto','a.created_at','a.estatus','b.huesped','b.habitacion','an.nombre as habita','h.nombre as nompac','h.responsable as apepac')
        ->join('solicitudes as b','b.id','a.solicitud')
        ->join('analisis as an','an.id','b.habitacion')
        ->join('clientes as h','h.id','b.huesped')
        ->where('a.created_at','=',$request->inicio)
        ->get(); 

        
        $soli = Pedidos::where('created_at', '=',$request->inicio)
        ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
        ->first();

        if ($soli->cantidad == 0) {
        $soli->monto = 0;
        }
        $f1 = $request->inicio;

    }else {
        $pedidos = DB::table('pedidos as a')
        ->select('a.id','a.solicitud','a.descripcion','a.tipopago','a.created_at','a.monto','a.estatus','b.huesped','b.habitacion','an.nombre as habita','h.nombre as nompac','h.responsable as apepac')
        ->join('solicitudes as b','b.id','a.solicitud')
        ->join('analisis as an','an.id','b.habitacion')
        ->join('clientes as h','h.id','b.huesped')
        ->where('a.created_at', '=', date('Y-m-d'))
        ->get(); 

        $f1 =date('Y-m-d');

          
        $soli = Pedidos::where('created_at', '=',$f1)
        ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
        ->first();

        if ($soli->cantidad == 0) {
        $soli->monto = 0;
        }

    }

    $habs = DB::table('pedidos as a')
    ->select('a.id','a.solicitud','a.descripcion','a.monto','a.created_at','a.estatus','b.huesped','b.habitacion','an.nombre as habita','h.nombre as nompac','h.responsable as apepac')
    ->join('solicitudes as b','b.id','a.solicitud')
    ->join('analisis as an','an.id','b.habitacion')
    ->join('clientes as h','h.id','b.huesped')
    ->groupBy('b.id')
    ->get(); 
        

        return view('pedidos.index', compact('pedidos','f1','soli','habs'));
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
        $solicitudes = DB::table('solicitudes as a')
        ->select('a.id','a.huesped','a.cliente','a.habitacion','a.es_pagado','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombre as nompac','b.responsable as apepac','an.nombre as hab')
        ->join('clientes as b','b.id','a.huesped')
        ->join('analisis as an','an.id','a.habitacion')
        ->where('a.estatus', '=', 1)
        ->get();

        $productos = Productos::where('estatus','=',1)->get();

        //$paciente = Pacientes::where('dni','=',$request->pac)->first();
        //print($paciente);
        return view('pedidos.create', compact('solicitudes','productos'));

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
    

    public function store(Request $request)
    {


        $solicitud =Solicitudes::where('id','=',$request->solicitud)->first();

        if (isset($request->id_servicio)) {
             foreach ($request->id_servicio['servicios'] as $key => $servicio) {
               if (!is_null($servicio['servicio'])) {

                $productos = Productos::where('id','=',$servicio['servicio'])->first();
                $pedidos = new Pedidos();
                $pedidos->solicitud =$request->solicitud;
                $pedidos->producto =$servicio['servicio'];
                $pedidos->monto =$request->monto_s['servicios'][$key]['monto'];
                $pedidos->descripcion =$productos->nombre;
                $pedidos->usuario =Auth::user()->id;
                $pedidos->save();

                $productccc = Productos::where('id','=',$servicio['servicio'])->first();

                $productos = Productos::find($servicio['servicio']);
                $productos->cantidad =$productccc->cantidad - 1;
                $res = $productos->update();
       
               } else {
       
               }
             }
           }

       
        

        $hab = Analisis::where('id','=',$solicitud->habitacion)->first();
        $hab->pedido =1;
        $res = $hab->update();


        return redirect()->action('PedidosController@index')
        ->with('success','Registrado Exitosamente!');


    }

    public function pago(Request $request)
    {

        $pedidos = DB::table('pedidos as a')
        ->select('a.id','a.solicitud','a.descripcion','a.created_at','a.monto','a.estatus','b.huesped','b.habitacion','an.nombre as habita','h.nombre as nompac','h.responsable as apepac')
        ->join('solicitudes as b','b.id','a.solicitud')
        ->join('analisis as an','an.id','b.habitacion')
        ->join('clientes as h','h.id','b.huesped')
        ->where('a.solicitud', '=',$request->solicitud)
        ->first(); 

        $cli =Clientes::where('id','=',$pedidos->huesped)->first();

        $colection = json_decode($request->pedido);

        //dd($request->tipopago);

        if(!is_null($colection)){
            foreach ($colection as $key => $value) {

            $ped =Pedidos::where('id','=',$value->id)->first();

                $disp = Analisis::where('id','=',$pedidos->habitacion)->first();
                $disp->disponible =0;
                $disp->pedido =null;
                $disp->cliente ='';
                $disp->ult_ingreso ='';
                $res = $disp->update();

            $creditoso = new Creditos();
            $creditoso->solicitud =$request->solicitud;
            $creditoso->fecha =date('Y-m-d H:i:s');
            $creditoso->origen ='PEDIDO';
            $creditoso->nombre =$cli->nombre.' '.$cli->responsable;
            $creditoso->descripcion ='PEDIDO POR'.' '.$disp->nombre.' :'.$ped->descripcion;
            $creditoso->usuario =Auth::user()->id;
            $creditoso->tipopago =$request->tipopago;
            if($request->tipopago == 'TJ'){
            $creditoso->monto =$ped->monto + $ped->monto * 0.1;
            $creditoso->tarjeta =$ped->monto + $ped->monto * 0.1;
            } else {
            $creditoso->monto =$ped->monto;
            $creditoso->efectivo =$ped->monto;
            }
            $creditoso->save();

            if($request->tipopago == 'TJ'){

                $peds = Pedidos::where('id','=',$value->id)->first();
                $peds->estatus =1;
                $peds->monto =$peds->monto + $peds->monto * 0.1;
                $peds->tipopago ='TJ';
                $res = $peds->update();
            } else {
                $peds = Pedidos::where('id','=',$value->id)->first();
                $peds->estatus =1;
                $peds->tipopago ='EF';
                $res = $peds->update();                }
                
            }
           }

       
                
                $chk = Solicitudes::where('id','=',$request->solicitud)->first();
                $chk->estatus =2;
                $res = $chk->update();


                return redirect()->action('HomeController@index')
                ->with('success','Pagado Exitosamente!');

        

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
    
    

    public function pagar($id)
    {



     

        $pedidos = DB::table('pedidos as a')
        ->select('a.id','a.solicitud','a.descripcion','a.monto','a.created_at','a.estatus','b.huesped','b.habitacion','an.nombre as habita','h.nombre as nompac','h.responsable as apepac')
        ->join('solicitudes as b','b.id','a.solicitud')
        ->join('analisis as an','an.id','b.habitacion')
        ->join('clientes as h','h.id','b.huesped')
        ->where('a.solicitud','=',$id)
        ->get(); 

        
        $soli = Pedidos::where('solicitud', '=',$id)
        ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
        ->first();

        if ($soli->cantidad == 0) {
        $soli->monto = 0;
        }  

        $sol = $id;


     
      return view('pedidos.pagar', compact('pedidos','soli','sol'));
        
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
        $pedido = Equipos::find($id);

        $pedidos = DB::table('pedidos as a')
        ->select('a.id','a.solicitud','a.descripcion','a.monto','a.created_at','a.estatus','b.huesped','b.habitacion','an.nombre as habita','h.nombre as nompac','h.responsable as apepac')
        ->join('solicitudes as b','b.id','a.solicitud')
        ->join('analisis as an','an.id','b.habitacion')
        ->join('clientes as h','h.id','b.huesped')
        ->where('a.solicitud','=',$id)
        ->first(); 

        $productos = Productos::where('estatus','=',1)->get();
        $hab = Analisis::where('id','=',$pedidos->habitacion)->first();



        return view('pedidos.edit', compact('pedido','producto','hab')); //
    }

    public function ticket($id)
    {
        $pedido = Equipos::find($id);

        $pedidos = DB::table('pedidos as a')
        ->select('a.id','a.solicitud','a.descripcion','a.monto','a.created_at','a.estatus','b.huesped','b.habitacion','an.nombre as habita','h.nombre as nompac','h.responsable as apepac')
        ->join('solicitudes as b','b.id','a.solicitud')
        ->join('analisis as an','an.id','b.habitacion')
        ->join('clientes as h','h.id','b.huesped')
        ->where('a.solicitud','=',$id)
        ->get(); 



                                    $ped = DB::table('pedidos as a')
                                    ->select('a.id','a.solicitud','a.descripcion','a.monto','a.created_at','a.estatus','b.huesped','b.habitacion','an.nombre as habita','h.nombre as nompac','h.responsable as apepac')
                                    ->join('solicitudes as b','b.id','a.solicitud')
                                    ->join('analisis as an','an.id','b.habitacion')
                                    ->join('clientes as h','h.id','b.huesped')
                                    ->where('a.solicitud','=',$id)
                                    ->first(); 

        $productos = Productos::where('estatus','=',1)->get();
        $cli = Clientes::where('id','=',$ped->huesped)->first();



        $view = \View::make('pedidos.ticket', compact('pedidos','ped','cli'));
        $customPaper = array(0,0,500.00,190.00);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper($customPaper, 'landscape');
     
       
        return $pdf->stream('ticket-pedido'.'.pdf');    }

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

