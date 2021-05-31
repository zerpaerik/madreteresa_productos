<?php

namespace App\Http\Controllers;

use App\Productos;
use App\Productosl;
use App\ProductMov;
use App\ProductosMovl;
use Illuminate\Http\Request;
use DB;
use Auth;

class ProductoslController extends Controller
{
   
    public function index()
    {

        $productos = Productosl::where('estatus','=',1)->get();
        return view('productosl.index', compact('productos'));
        //
    }

    public function ingproductosl(Request $request)
    {

        if($request->inicio && $request->fin){

            $f1=$request->inicio;
            $f2=$request->fin;

        $ingresos = DB::table('productosl_mov as a')
        ->select('a.id','a.producto','a.cantidad','a.factura','a.fecha','a.tipo','a.created_at','a.usuario','b.nombre as product','u.name')
        ->join('productosl as b','b.id','a.producto')
        ->join('users as u','u.id','a.usuario')
        ->where('a.tipo','=',1)
        ->whereBetween('a.created_at', [$request->inicio, $request->fin])
        ->get(); 
    } else {
        $ingresos = DB::table('productosl_mov as a')
        ->select('a.id','a.producto','a.cantidad','a.factura','a.fecha','a.tipo','a.created_at','a.usuario','b.nombre as product','u.name')
        ->join('productosl as b','b.id','a.producto')
        ->join('users as u','u.id','a.usuario')
        ->where('a.created_at', '=',date('Y-m-d'))
        ->where('a.tipo','=',1)
        ->get(); 

        $f1=date('Y-m-d');
        $f2=date('Y-m-d');

    }


        return view('productosl.ingresos', compact('ingresos','f1','f2'));
    } 

    public function salida(Request $request)
    {


        if($request->inicio && $request->fin){

            $f1=$request->inicio;
            $f2=$request->fin;



        $ingresos = DB::table('productosl_mov as a')
        ->select('a.id','a.producto','a.cantidad','a.factura','a.observacion','a.fecha','a.tipo','a.created_at','a.usuario','b.nombre as product','u.name')
        ->join('productosl as b','b.id','a.producto')
        ->join('users as u','u.id','a.usuario')
        ->whereBetween('a.created_at', [$request->inicio, $request->fin])
        ->where('a.tipo','=',2)
        ->get(); 

    } else {
        $ingresos = DB::table('productosl_mov as a')
        ->select('a.id','a.producto','a.cantidad','a.factura','a.observacion','a.fecha','a.tipo','a.created_at','a.usuario','b.nombre as product','u.name')
        ->join('productosl as b','b.id','a.producto')
        ->join('users as u','u.id','a.usuario')
        ->where('a.created_at', '=',date('Y-m-d'))
        ->where('a.tipo','=',2)
        ->get(); 

        
        $f1=date('Y-m-d');
        $f2=date('Y-m-d');

    }


        return view('productosl.salidas', compact('ingresos','f1','f2'));
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('productosl.create');

        //
    }

    public function ingcreatel()
    {

        $productos = Productosl::where('estatus','=',1)->get();


        return view('productosl.ingproducto',compact('productos'));

        
    }

    
    public function salidacreate()
    {

        $productos = Productosl::where('estatus','=',1)->get();


        return view('productosl.salida',compact('productos'));

        
    }

   

    public function storeing(Request $request)
    {

        if (isset($request->id_laboratorio)) {
            foreach ($request->id_laboratorio['laboratorios'] as $key => $laboratorio) {
              if (!is_null($laboratorio['laboratorio'])) {
      
                $lab = new ProductosMovl();
                $lab->producto =  $laboratorio['laboratorio'];
                $lab->cantidad =  $request->monto_abol['laboratorios'][$key]['abono'];
                $lab->factura = $request->factura;
                $lab->fecha = $request->fecha;
                $lab->tipo = 1;
                $lab->observacion = $request->observacion;
                $lab->usuario = Auth::user()->id;
                $lab->save();

                $product = Productosl::where('id','=',$laboratorio['laboratorio'])->first();



                $productos = Productosl::find($laboratorio['laboratorio']);
                $productos->cantidad =$product->cantidad + $request->monto_abol['laboratorios'][$key]['abono'];
                $res = $productos->update();
    
              } 
            }
          }

       
    
          return redirect()->action('ProductoslController@ingproductosl');

    }

    public function storesal(Request $request)
    {

        if (isset($request->id_laboratorio)) {
            foreach ($request->id_laboratorio['laboratorios'] as $key => $laboratorio) {
              if (!is_null($laboratorio['laboratorio'])) {
      
                $lab = new ProductosMovl();
                $lab->producto =  $laboratorio['laboratorio'];
                $lab->cantidad =  $request->monto_abol['laboratorios'][$key]['abono'];
                $lab->tipo = 2;
                $lab->observacion = $request->observacion;
                $lab->usuario = Auth::user()->id;
                $lab->save();

                $product = Productosl::where('id','=',$laboratorio['laboratorio'])->first();



                $productos = Productosl::find($laboratorio['laboratorio']);
                $productos->cantidad =$product->cantidad - $request->monto_abol['laboratorios'][$key]['abono'];
                $res = $productos->update();
    
              } 
            }
          }

       
    
          return redirect()->action('ProductoslController@salida');

    }

     

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        

        $productos = new Productosl();
        $productos->nombre =$request->nombre;
        $productos->descripcion =$request->descripcion;
        $productos->categoria =$request->categoria;
        $productos->cantidad =$request->cantidad;
        $productos->usuario =Auth::user()->id;
        $productos->save();
   

        return redirect()->action('ProductoslController@index', ["created" => true, "productos" => Productos::all()]);


    }

    
    public function edit($id)
    {
        $productos = Productosl::find($id);
        return view('productosl.edit', compact('productos')); //
    }

    public function reversaring($id)
    {


                $ingreso = ProductosMovl::where('id','=',$id)->first();
                $productos = Productosl::where('id','=',$ingreso->producto)->first();

                $productos = Productosl::find($ingreso->producto);
                $productos->cantidad =$productos->cantidad - $ingreso->cantidad;
                $res = $productos->update();

                $inde = ProductosMovl::find($id);
                $res = $inde->delete();

        return redirect()->action('ProductoslController@ingproductosl');
    }

    public function reversarsal($id)
    {


                $ingreso = ProductosMovl::where('id','=',$id)->first();
                $productos = Productosl::where('id','=',$ingreso->producto)->first();

                $productos = Productosl::find($ingreso->producto);
                $productos->cantidad =$productos->cantidad + $ingreso->cantidad;
                $res = $productos->update();

                $inde = ProductosMovl::find($id);
                $res = $inde->delete();

        return redirect()->action('ProductoslController@salida');
    }

    public function consulta(Request $request){

        
       
        $productos = Productos::where('estatus','=',1)->get();


         $view = \View::make('productos.consulta',compact('productos'));

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
     
       
        return $pdf->stream('report-productos'.'.pdf');

       
        //return $pdf->stream('movimientos'.'.pdf');

    }

    
    public function update(Request $request)
    {

        
        $productos = Productosl::find($request->id);
        $productos->nombre =$request->nombre;
        $productos->descripcion =$request->descripcion;
        $productos->categoria =$request->categoria;
        $res = $productos->update();

    
      return redirect()->action('ProductoslController@index');

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

        $productos = Productosl::find($id);
      $productos->estatus =0;
     
      $res = $productos->update();

        return redirect()->action('ProductoslController@index');

        //
    }
}
