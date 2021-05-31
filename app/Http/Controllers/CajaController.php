<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Debitos;
use App\Creditos;
use App\Cajas;
use Auth;
use PDF;



class CajaController extends Controller
{
    public function index(Request $request)
    {

       if(! is_null($request->fecha)) {

    $f1 = $request->fecha;
    $f2 = $request->fecha2;  

     // $caja = DB::table('cajas')->select('*')->where('sede','=',$request->session()->get('sede'))->whereBetween('fecha', [date('Y-m-d', strtotime($f1)), date('Y-m-d', strtotime($f2))])->get();


      $caja = DB::table('cajas as  a')
        ->select('a.id','a.monto_init','a.monto_fin','a.estatus','a.fecha_init','a.fecha_fin','a.usuario_init','a.usuario_fin','b.name','a.created_at')
        ->join('users as b','b.id','a.usuario_init')
        ->whereBetween('a.created_at', [date('Y-m-d', strtotime($f1)), date('Y-m-d', strtotime($f2))])
        ->get();

        $aten = Creditos::whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($f1)), date('Y-m-d 23:59:59', strtotime($f2))])
                       ->select(DB::raw('SUM(monto) as monto'))
                       ->first();
      

        $mensaje;                      

        if (count($caja) == 0) {
            $mensaje = 'Dia';
        }

        if(count($caja) >= 1)
        {
            $mensaje = 'Noche';
        }  



} else {



        $caja = DB::table('cajas as  a')
        ->select('a.id','a.monto_init','a.monto_fin','a.estatus','a.fecha_init','a.fecha_fin','a.usuario_init','a.usuario_fin','b.name','a.created_at')
        ->join('users as b','b.id','a.usuario_init')
        ->where('a.created_at','=',date('Y-m-d'))
        ->get();


	  
                       
                    
        $cajaa = DB::table('cajas')
                       ->select('*')->get()->last();


        if($cajaa != null){
            
        $aten = Creditos::where('fecha','>',$cajaa->created_at)
        ->select(DB::raw('SUM(monto) as monto'))
        ->first();

        $deb = Debitos::where('fecha','>',$cajaa->created_at)
        ->select(DB::raw('SUM(monto) as monto'))
        ->first();

        $total = $aten->monto - $deb->monto;


        } else {

        $aten = Creditos::select(DB::raw('SUM(monto) as monto'))
        ->first();

        $deb = Debitos::select(DB::raw('SUM(monto) as monto'))
        ->first();

        $total = $aten->monto - $deb->monto;

            
        }
      

		$mensaje;	



          $f1 = date('Y-m-d');
         $f2 = date('Y-m-d'); 
    	
    	
    	if (count($caja) == 0) {
    		$mensaje = 'Dia';
    	}

    	if(count($caja) >= 1)
    	{
    		$mensaje = 'Noche';
    	}

        }
		              $hoy =date('Y-m-d H:i:s');


	    return view('caja.index',[
	    	'total' => $total,
	    	'mensaje' => $mensaje,
	    	'caja' => $caja,
	    	'fecha' => date('Y-m-d'),
            'fecha1' => $f1,
            'fecha2' => $f2,
            'hoy' => $hoy
	    ]);    	
    }

    public function ticket(Request $request,$id){

        $cajas = DB::table('cajas')
        ->select('*')->get()->last();

        //1ER TURNO 08:00 - 19:59
        //2do TURNO 20:00 - 07-59
        $caja=Cajas::where('id','=',$id)->first();


        $turno1start = date('Y-m-d 08:00:00');
        $turno1end = date('Y-m-d 19:59:00');

        $turno2start = date('Y-m-d 20:00:00');
        $turno2end = date('Y-m-d 07:59:00');



            $ingresos = Creditos::where('origen', 'INGRESO')
            ->whereRaw("fecha > ? AND fecha <= ?", 
              array($caja->fecha_init, $caja->fecha_fin))
            ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
            ->first();

    
            if ($ingresos->cantidad == 0) {
            $ingresos->monto = 0;
            }
    
            $otros = Creditos::where('origen', 'OTROS INGRESOS')
            ->whereRaw("fecha > ? AND fecha <= ?", 
              array($caja->fecha_init, $caja->fecha_fin))
            ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
            ->first();
    
            if ($otros->cantidad == 0) {
            $otros->monto = 0;
            }
    
            $pedido = Creditos::where('origen', 'PEDIDO')
            ->whereRaw("fecha > ? AND fecha <= ?", 
            array($caja->fecha_init, $caja->fecha_fin))
            ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
            ->first();
    
            if ($pedido->cantidad == 0) {
            $pedido->monto = 0;
            }
    
            $totalIngresos = $ingresos->monto + $otros->monto + $pedido->monto;
    
            $egresos = Debitos::whereRaw("fecha > ? AND fecha <= ?", 
            array($caja->fecha_init, $caja->fecha_fin))
            ->select(DB::raw('origen, descripcion, monto,nombre'))
            ->get();
    
    
            $efectivo = Creditos::where('tipopago', 'EF')
            ->whereRaw("fecha > ? AND fecha <= ?", 
            array($caja->fecha_init, $caja->fecha_fin))
            ->select(DB::raw('SUM(monto) as monto'))
            ->first();

            if (is_null($efectivo->monto)) {
            $efectivo->monto = 0;
            }
    
            $tarjeta = Creditos::where('tipopago', 'TJ')
            ->whereRaw("fecha > ? AND fecha <= ?", 
              array($caja->fecha_init, $caja->fecha_fin))
                    ->select(DB::raw('SUM(monto) as monto'))
                    ->first();
    
            if (is_null($tarjeta->monto)) {
            $tarjeta->monto = 0;
            }
    
            $totalEgresos = 0;
    
            foreach ($egresos as $egreso) {
                $totalEgresos += $egreso->monto;
            }
    
       




        $view = \View::make('caja.ticket', compact('ingresos','otros','totalIngresos','egresos','efectivo','tarjeta','totalEgresos','pedido','caja'));

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
     
       
        return $pdf->stream('report-cierre'.'.pdf');
    }




        public function create(Request $request)

    {
        $caja = DB::table('cajas')
        ->select('*')
        //->where('fecha','=',date('Y-m-d'))
        ->get();

       // dd($request->total);


        
      /*  if (count($caja) == 0) {
            Cajas::create([
                'dia' => 0,
                'noche' => 0,
                'fecha' =>date('Y-m-d'),
                'init_prox' =>date('Y-m-d H:i:s'),
                'balance' => $request->total,
                'usuario' => Auth::user()->id
            ]);
        }else {

            $cajaa = DB::table('cajas')
           ->select('*')->get()->last();

           $creditos = Creditos::where('fecha','>',$cajaa->created_at)
           ->select(DB::raw('SUM(monto) as monto'))
           ->first();


           $cajaa = DB::table('cajas')
           ->select('*')->get()->last();
 
             Cajas::create([
                'dia' => 0,
                'noche' => 0,
                'fecha' => date('Y-m-d'),
                'init_prox' =>date('Y-m-d H:i:s'),
                'balance' => $request->total,
                'usuario' => Auth::user()->id
            ]);
        }*/

    

        $cajas = new Cajas();
        $cajas->monto_init ='0';
        $cajas->fecha_init =date('Y-m-d H:i:s');
        $cajas->usuario_init =Auth::user()->id;
        $cajas->save();


        return redirect()->action('CajaController@index')
        ->with('success','Turno Abierto Exitosamente!');
    }

    public function cerrar($id){

        $caja =Cajas::where('id','=',$id)->first();


        $aten = Creditos::where('fecha','>',$caja->fecha_init)
        ->select(DB::raw('SUM(monto) as monto'))
        ->first();

        $deb = Debitos::where('fecha','>',$caja->fecha_init)
        ->select(DB::raw('SUM(monto) as monto'))
        ->first();

        $total = $aten->monto - $deb->monto;

        $c = Cajas::find($id);
        $c->monto_fin =$total;
        $c->fecha_fin =date('Y-m-d H:i:s');
        $c->usuario_fin =Auth::user()->id;
        $c->estatus =2;
        $res = $c->update();
    
    
        return redirect()->action('CajaController@index')
        ->with('success','Turno Cerrado Exitosamente!');    
        
      }


      public function saldo(Request $request,$id){

        $caja =Cajas::where('id','=',$id)->first();

        
        $ingresos = Creditos::where('origen', 'INGRESO')
        ->whereRaw("fecha", 
          array($caja->fecha_init))
        ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
        ->first();


        if ($ingresos->cantidad == 0) {
        $ingresos->monto = 0;
        }

        $otros = Creditos::where('origen', 'OTROS INGRESOS')
        ->whereRaw("fecha", 
          array($caja->fecha_init))
        ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
        ->first();

        if ($otros->cantidad == 0) {
        $otros->monto = 0;
        }

        $pedido = Creditos::where('origen', 'PEDIDO')
        ->whereRaw("fecha", 
          array($caja->fecha_init))
        ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
        ->first();

        if ($pedido->cantidad == 0) {
        $pedido->monto = 0;
        }

        $totalIngresos = $ingresos->monto + $otros->monto + $pedido->monto;

        $egresos = Debitos::whereRaw("fecha", 
        array($caja->fecha_init))
        ->select(DB::raw('origen, descripcion, monto,nombre'))
        ->get();


        $efectivo = Creditos::where('tipopago', 'EF')
        ->whereRaw("fecha", 
        array($caja->fecha_init))
        ->select(DB::raw('SUM(monto) as monto'))
        ->first();

        if (is_null($efectivo->monto)) {
        $efectivo->monto = 0;
        }

        $tarjeta = Creditos::where('tipopago', 'TJ')
        ->whereRaw("fecha", 
        array($caja->fecha_init))
                ->select(DB::raw('SUM(monto) as monto'))
                ->first();

        if (is_null($tarjeta->monto)) {
        $tarjeta->monto = 0;
        }

        $totalEgresos = 0;

        foreach ($egresos as $egreso) {
            $totalEgresos += $egreso->monto;
        }

   

      
    

      return view('caja.saldo', compact('ingresos','otros','totalIngresos','egresos','efectivo','tarjeta','totalEgresos','pedido'));

    }

  

    public function delete($id){

    $caja = Cajas::find($id);
    $caja->delete();


    return redirect()->action('CajaController@index')
    ->with('success','Turno Reversado Exitosamente!');    
    
  }

   
    
}
