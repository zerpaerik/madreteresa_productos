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
use PDF;

class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function consolidado(Request $request)
    {

        if($request->inicio && $request->fin){


        $solicitudes = DB::table('solicitudes as a')
        ->select('a.id','a.huesped','a.cliente','a.habitacion','a.es_pagado','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombres as nompac','b.apellidos as apepac','an.nombre as laboratorio')
        ->join('pacientes as b','b.id','a.huesped')
        ->join('analisis as an','an.id','a.habitacion')
        ->whereBetween('a.created_at', [$request->inicio, $request->fin])
        ->where('a.estatus', '=', 1)
        ->where('a.es_pagado', '=', 0)
        ->get(); 
        $f1 = $request->inicio;
        $f2 = $request->fin;
    } else {
        $solicitudes = DB::table('solicitudes as a')
        ->select('a.id','a.huesped','a.cliente','a.habitacion','a.es_pagado','a.hora','a.precio','a.created_at','a.estatus','a.estado','a.observacion','b.nombres as nompac','b.apellidos as apepac','an.nombre as laboratorio')
        ->join('pacientes as b','b.id','a.huesped')
        ->join('analisis as an','an.id','a.habitacion')
        ->where('a.estatus', '=', 1)
        ->where('a.es_pagado', '=', 0)
        ->where('a.created_at', '=', date('Y-m-d'))
        ->get(); 

        $f1 =date('Y-m-d');
        $f2 = date('Y-m-d');

    }
        

        return view('reportes.consolidado', compact('solicitudes','f1','f2'));
        //
    }

    public function detallado(Request $request)
    {

        
        $f1 =date('Y-m-d');
        $f2 = date('Y-m-d');


        

        return view('reportes.detallado', compact('f1','f2'));

    }


    public function general(Request $request)
    {

        
        $f1 =date('Y-m-d');
        $f2 = date('Y-m-d');


    

        return view('reportes.general', compact('f1','f2'));

    }

    public function home()
    {

        
        $f1 =date('Y-m-d');
        $f2 = date('Y-m-d');

        $ingresos = Creditos::where('origen', 'INGRESO')
        ->whereBetween('created_at', [$request->inicio,$request->fin])
        ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
        ->first();


        

        return view('home', compact('f1','f2','ingresos'));

    }

    public function reportc(Request $request){

        $f1 = $request->inicio;
        $f2 = $request->fin;

        $ingresos = Creditos::where('origen', 'INGRESO')
        ->where('created_at','=', $request->inicio)
        ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
        ->first();

        if ($ingresos->cantidad == 0) {
        $ingresos->monto = 0;
        }

        $otros = Creditos::where('origen', 'OTROS INGRESOS')
        ->where('created_at','=', $request->inicio)
        ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
        ->first();

        if ($otros->cantidad == 0) {
        $otros->monto = 0;
        }

        $pedido = Creditos::where('origen', 'PEDIDO')
        ->where('created_at','=', $request->inicio)
        ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
        ->first();

        if ($pedido->cantidad == 0) {
        $pedido->monto = 0;
        }

        $totalIngresos = $ingresos->monto + $otros->monto + $pedido->monto;

        $egresos = Debitos::where('created_at','=', $request->inicio)
        ->select(DB::raw('origen, descripcion, monto,nombre'))
        ->get();


        $efectivo = Creditos::where('tipopago', 'EF')
        ->where('created_at','=', $request->inicio)
                ->select(DB::raw('SUM(monto) as monto'))
                ->first();
        if (is_null($efectivo->monto)) {
        $efectivo->monto = 0;
        }

        $tarjeta = Creditos::where('tipopago', 'TJ')
        ->where('created_at','=', $request->inicio)
                ->select(DB::raw('SUM(monto) as monto'))
                ->first();

        if (is_null($tarjeta->monto)) {
        $tarjeta->monto = 0;
        }

        $totalEgresos = 0;

        foreach ($egresos as $egreso) {
            $totalEgresos += $egreso->monto;
        }



        



         $view = \View::make('reportes.viewc', compact('f1','f2','ingresos','otros','totalIngresos','egresos','efectivo','tarjeta','totalEgresos','pedido'));

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
     
       
        return $pdf->stream('report-consolidado'.'.pdf');

       
        //return $pdf->stream('movimientos'.'.pdf');

    }

    public function reportd(Request $request){

        
        $f1= $request->inicio;
        $f2= $request->fin;



        $ingresos = DB::table('creditos as a')
        ->select('a.id','a.origen','a.descripcion','a.monto','a.nombre','a.tipopago','a.created_at','a.usuario','b.name as usuario')
        ->join('users as b','b.id','a.usuario' )
        ->whereBetween('a.created_at', [$request->inicio,$request->fin])
        ->get(); 

        $totalingreso = Creditos::whereBetween('created_at', [$request->inicio,$request->fin])
         ->select(DB::raw('SUM(monto) as monto'))
         ->first();

        if (is_null($totalingreso->monto)) {
            $totalingreso->monto = 0;
        }

        $egresos = DB::table('debitos as a')
        ->select('a.id','a.origen','a.descripcion','a.monto','a.tipopago','a.created_at','a.usuario','b.name as usuario')
        ->join('users as b','b.id','a.usuario' )
        ->whereBetween('a.created_at', [$request->inicio,$request->fin])
        ->get(); 

        $totalegreso = Debitos::whereBetween('created_at', [$request->inicio,$request->fin])
         ->select(DB::raw('SUM(monto) as monto'))
         ->first();
         
        if (is_null($totalingreso->monto)) {
            $totalingreso->monto = 0;
        }


    




         $view = \View::make('reportes.viewd', compact('f1','f2','ingresos','totalingreso','egresos','totalegreso'));

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
     
       
        return $pdf->stream('report-detallado'.'.pdf');





    }

    public function reportg(Request $request){

        $f1 = $request->inicio;
        $f2 = $request->fin;




          $ingresos = DB::table('creditos as a')
                ->select('a.id','a.created_at',DB::raw('SUM(monto) as monto'),DB::raw('SUM(efectivo) as efectivo'),DB::raw('SUM(tarjeta) as tarjeta'))
                ->whereBetween('a.created_at', [$f1,$f2])
                ->groupBy('a.created_at')
                ->get();  




        $total= Creditos::whereBetween('created_at', [$f1,$f2])
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();
         $egresos=Debitos::whereBetween('created_at', [$f1,$f2])
                                    ->select(DB::raw('SUM(monto) as egreso'),'created_at')
                                    ->groupBy('created_at')
                                    ->get();
                       
                                    
        $debitos=Debitos::whereBetween('created_at', [$f1,$f2])
                                    ->select(DB::raw('SUM(monto) as monto'))
                                    ->first();

         $saldo= $total->monto - $debitos->monto;

       


         $view = \View::make('reportes.viewg', compact('f1','f2','ingresos','total','egresos','debitos','saldo'));

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
     
       
        return $pdf->stream('report-general'.'.pdf');

       
        //return $pdf->stream('movimientos'.'.pdf');

    }

   

   
}

