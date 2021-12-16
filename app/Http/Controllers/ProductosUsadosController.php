<?php

namespace App\Http\Controllers;

use App\Productos;
use App\ProductMov;
use App\ProductosAlmacen;
use App\ProductosUsados;
use App\UnidadMedida;
use App\Ingresos;
use App\User;
use App\IngresosDetalle;
use Illuminate\Http\Request;
use DB;
use Auth;

class ProductosUsadosController extends Controller
{
   
    public function index(Request $request)
    {

        if($request->inicio){
            $f1 = $request->inicio;
            $f2 = $request->fin;


            if($request->producto == 0){


                $productos = DB::table('productos_usados as a')
                ->select('a.id','a.producto','a.estatus','a.eliminado_por','a.fecha',DB::raw('SUM(a.cantidad) as cant,SUM(a.precio*a.cantidad) as preciototal'),'a.created_at','a.usuario','u.nombre as nompro','u.categoria','u.medida','a.almacen','us.name as user')
                ->join('productos as u','u.id','a.producto')
                ->join('users as us','us.id','a.usuario')
                ->whereBetween('a.fecha', [$f1, $f2])
                ->groupBy('a.producto')
                ->where('a.almacen', '=', $request->almacen)
                ->get(); 

                $soli = ProductosUsados::whereBetween('fecha', [$f1, $f2])
                ->where('almacen', '=', $request->almacen)
                ->select(DB::raw('COUNT(*) as item, SUM(cantidad) as cant,SUM(precio*cantidad) as preciototal'))
                ->first();

                if ($soli->item == 0) {
                $soli->cant = 0;
                }

                $alma = $request->almacen;

                $producto_sel = 'Todos';



            } else {

                $productos = DB::table('productos_usados as a')
                ->select('a.id','a.producto','a.estatus','a.eliminado_por','a.fecha',DB::raw('SUM(a.cantidad) as cant,SUM(a.precio*a.cantidad) as preciototal'),'a.created_at','a.usuario','u.nombre as nompro','u.categoria','u.medida','a.almacen','us.name as user')
                ->join('productos as u','u.id','a.producto')
                ->join('users as us','us.id','a.usuario')
                ->whereBetween('a.fecha', [$f1, $f2])
                ->where('a.almacen', '=', $request->almacen)
                ->where('a.producto', '=', $request->producto)
                ->groupBy('a.producto')
                ->get(); 

                $soli = ProductosUsados::whereBetween('fecha', [$f1, $f2])
                ->where('almacen', '=', $request->almacen)
                ->where('producto', '=', $request->producto)
                ->groupBy('producto')
                ->select(DB::raw('COUNT(*) as item, SUM(cantidad) as cant,SUM(precio*cantidad) as preciototal'))
                ->first();

                if ($soli->item == 0) {
                $soli->cant = 0;
                }

                $alma = $request->almacen;

                $productosg_s = DB::table('productos as a')
                ->select('a.id','a.nombre','a.cantidad','a.precio','a.estatus')
                ->where('a.id','=',$request->producto)
                ->first(); 
    
    
                $producto_sel = $productosg_s->nombre;
    

            }

         

        



    } else {

        $f1 = date('Y-m-d');
        $f2 = date('Y-m-d');

        $productos = DB::table('productos_usados as a')
        ->select('a.id','a.producto','a.eliminado_por','a.estatus','a.fecha',DB::raw('SUM(a.cantidad) as cant,SUM(a.precio*a.cantidad) as preciototal'),'a.created_at','a.usuario','u.nombre as nompro','u.categoria','u.medida','a.almacen','us.name as user')
        ->join('productos as u','u.id','a.producto')
        ->join('users as us','us.id','a.usuario')
        ->whereBetween('a.fecha', [$f1, $f2])
        ->groupBy('a.producto')
        // ->where('a.almacen', '=', $request->almacen)
        ->get(); 

        $soli = ProductosUsados::whereBetween('fecha', [$f1, $f2])
        // ->where('almacen', '=', $request->almacen)
        ->select(DB::raw('COUNT(*) as item, SUM(cantidad) as cant,SUM(precio*cantidad) as preciototal'))
        ->first();

        if ($soli->item == 0) {
        $soli->cant = 0;
        }

        $alma = $request->almacen;

        $producto_sel = 'Todos';


      
    



    }

    $productosg = DB::table('productos as a')
    ->select('a.id','a.nombre','a.cantidad','a.precio','a.estatus')
    ->join('productos_usados as u','u.producto','a.id')
    ->where('a.estatus','=',1)
    ->orderBy('nombre','ASC')
    ->groupBy('a.id')
    ->get(); 

   // dd($productosg);

        
        return view('productosu.index', compact('productos','f1', 'f2','soli','alma','productosg','producto_sel'));
        
    }

    public function productos_usados_report($producto, $f1, $f2, $almacen){

        $productos = DB::table('productos_usados as a')
        ->select('a.id','a.producto','a.estatus','a.eliminado_por','a.fecha','a.cantidad','a.precio','a.created_at','a.usuario','u.nombre as nompro','u.categoria','u.medida','a.almacen','us.name as user')
        ->join('productos as u','u.id','a.producto')
        ->join('users as us','us.id','a.usuario')
        ->whereBetween('a.fecha', [$f1, $f2])
        ->where('a.almacen', '=', $almacen)
        ->where('a.producto', '=', $producto)
        ->get(); 

        $productosi = DB::table('productos_usados as a')
        ->select('a.id','a.producto','a.estatus','a.eliminado_por','a.fecha',DB::raw('SUM(a.cantidad) as cant,SUM(a.precio*a.cantidad) as preciototal'),'a.created_at','a.usuario','u.nombre as nompro','u.categoria','u.medida','a.almacen','us.name as user')
        ->join('productos as u','u.id','a.producto')
        ->join('users as us','us.id','a.usuario')
        ->whereBetween('a.fecha', [$f1, $f2])
        ->where('a.almacen', '=', $almacen)
        ->where('a.producto', '=', $producto)
        ->first(); 


        $view = \View::make('productosu.recibo', compact('productos','productosi'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
     
    
        return $pdf->stream('productos-usados-recibo'.'.pdf');  

        dd($productos);

    }

    public function index1(Request $request)
    {

        if($request->session()->get('sedeName') == 'CANTO REY'){
            $almacen = 7;
            } elseif($request->session()->get('sedeName') == 'VIDA FELIZ'){
            $almacen = 8;
            } else {
            $almacen = 9;
            }

   

        if($request->inicio){
            $f1 = $request->inicio;
            $f2 = $request->fin;

        $productos = DB::table('productos_usados as a')
        ->select('a.id','a.producto','a.eliminado_por','a.estatus','a.fecha','a.precio','a.cantidad','a.created_at','a.usuario','u.nombre as nompro','u.categoria','u.medida','a.almacen','us.name as user')
        ->join('productos as u','u.id','a.producto')
        ->join('users as us','us.id','a.usuario')
        ->whereBetween('a.fecha', [$f1, $f2])
        ->where('a.almacen','=',$almacen)
        ->get(); 

        $soli = ProductosUsados::whereBetween('fecha',  [$f1, $f2])
        ->where('almacen','=',$almacen)
        ->select(DB::raw('COUNT(*) as item, SUM(cantidad) as cant,SUM(precio*cantidad) as preciototal'))
        ->first();

        if ($soli->item == 0) {
        $soli->cant = 0;
        }



    } else {

        $f1 = date('Y-m-d');
        $f2 = date('Y-m-d');

        $productos = DB::table('productos_usados as a')
        ->select('a.id','a.producto','a.eliminado_por','a.estatus','a.fecha','a.precio','a.cantidad','a.created_at','a.usuario','u.nombre as nompro','u.categoria','u.medida','a.almacen','us.name as user')
        ->join('productos as u','u.id','a.producto')
        ->join('users as us','us.id','a.usuario')
        ->whereBetween('a.fecha', [$f1, $f2])
        ->where('a.almacen','=',$almacen)
        ->get(); 

        $soli = ProductosUsados::whereBetween('fecha',  [$f1, $f2])
        ->where('almacen','=',$almacen)
        ->select(DB::raw('COUNT(*) as item, SUM(cantidad) as cant,SUM(precio*cantidad) as preciototal'))
        ->first();

        if ($soli->item == 0) {
        $soli->cant = 0;
        }


    }

    $productos = DB::table('productos as a')
    ->select('a.id','a.nombre','a.cantidad','a.precio','a.estatus')
    ->join('productos_usados as u','u.producto','a.id')
    ->where('a.estatus','=',1)
    ->get(); 

    dd($productos);




        return view('productosu.index1', compact('productos','f1', 'f2','soli','productos'));
        //
    }

    public function ingproductos(Request $request)
    {

      

        if($request->inicio){
            $f1 = $request->inicio;
            $f2 = $request->fin;

        $ingresos = DB::table('ingresos_detalle as a')
        ->select('a.id','a.producto','a.ingreso','a.vence','a.estatus','a.usuario_elimina','a.cantidad','i.created_at','i.usuario','a.precio','i.factura','i.fecha','i.observacion','u.name as usuario','p.nombre as producto')
        ->join('ingresos as i','i.id','a.ingreso')
        ->join('productos as p','p.id','a.producto')
        ->join('users as u','u.id','i.usuario')
        ->whereBetween('i.created_at', [$f1, $f2])
        ->get();


    } else {
        $ingresos = DB::table('ingresos_detalle as a')
        ->select('a.id','a.producto','a.ingreso','a.vence','a.estatus','a.usuario_elimina','a.cantidad','i.created_at','i.usuario','a.precio','i.factura','i.fecha','i.observacion','u.name as usuario','p.nombre as producto')
        ->join('ingresos as i','i.id','a.ingreso')
        ->join('productos as p','p.id','a.producto')
        ->join('users as u','u.id','i.usuario')
        ->where('i.created_at','=',date('Y-m-d'))
        ->get();


        $f1 = date('Y-m-d');
        $f2 = date('Y-m-d');


    }

        

        return view('productos.ingresos', compact('ingresos','f1','f2'));
    } 

    public function create(Request $request)
    {

        if($request->session()->get('sedeName') == 'CANTO REY'){
            $almacen = 7;
            } elseif($request->session()->get('sedeName') == 'VIDA FELIZ'){
            $almacen = 8;
            } else {
            $almacen = 9;
            }

            $productos = DB::table('productos_almacen as a')
            ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.categoria','u.medida','a.almacen')
            ->join('productos as u','u.id','a.producto')
            ->where('a.almacen','=',$almacen)
            ->where('a.cantidad','>','0')
            ->orderBy('nompro','ASC')
            ->get(); 
        
        
        return view('productosu.create', compact('productos'));

        //
    }

    
    public function creater()
    {

       

        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',2)
        ->where('a.cantidad','>','0')
        ->orderBy('nompro','ASC')
        ->get(); 
       
        return view('productosu.creater', compact('productos'));

        
    }

    public function createl()
    {

       

        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',11)
        ->where('a.cantidad','>','0')
        ->orderBy('nompro','ASC')
        ->get(); 

       
        return view('productosu.createl', compact('productos'));

        
    }

    public function createo()
    {

        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',3)
        ->where('a.cantidad','>','0')
        ->orderBy('nompro','ASC')
        ->get(); 

        return view('productosu.createo', compact('productos'));

        
    }

    public function createra()
    {

        
        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',4)
        ->where('a.cantidad','>',0)
        ->orderBy('nompro','ASC')
        ->get(); 

        return view('productosu.createra', compact('productos'));

        
    }

    public function ingcreate()
    {

        $productos = ProductosAlmacen::where('estatus','=',1)->orderBy('nombre','ASC')->get();


        return view('productos.ingproducto',compact('productos'));

        //
    }

    

    public function central()
    {


        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',1)
        ->where('a.cantidad','>',0)
        ->get(); 


        return view('productos.central',compact('productos'));

        //
    }

    public function recepcion()
    {


        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',2)
        ->get(); 


        return view('productos.recepcion',compact('productos'));

        //
    }

    public function obstetra()
    {


        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',3)
        ->get(); 


        return view('productos.obstetra',compact('productos'));

        //
    }

    public function rayos()
    {


        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',4)
        ->get(); 


        return view('productos.rayos',compact('productos'));

        //
    }

    public function almacen(Request $request)
    {


        if($request->session()->get('sedeName') == 'CANTO REY'){
            $almacen = 7;
            } elseif($request->session()->get('sedeName') == 'VIDA FELIZ'){
            $almacen = 8;
            } else {
            $almacen = 9;
            }


        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',$almacen)
        ->get(); 


        return view('productos.almacen',compact('productos'));

        //
    }

    public function getProducto($p)
    {
        return Productos::findOrFail($p);
    
    }

    public function store(Request $request)
    {


        if($request->session()->get('sedeName') == 'CANTO REY'){
            $almacen = 7;
            } elseif($request->session()->get('sedeName') == 'VIDA FELIZ'){
            $almacen = 8;
            } else {
            $almacen = 9;
            }



        if (isset($request->id_laboratorio)) {
            foreach ($request->id_laboratorio['laboratorios'] as $key => $laboratorio) {
              if (!is_null($laboratorio['laboratorio'])) {

                //dd($request->fecha_vence['laboratorios'][$key]['vence']);
                $lab = new ProductosUsados();
                $lab->producto =  $laboratorio['laboratorio'];
                $lab->cantidad =  $request->monto_abol['laboratorios'][$key]['abono'];
                $lab->almacen =  $almacen;
                $lab->usuario =  Auth::user()->id;
                $lab->save();

               
                $product = ProductosAlmacen::where('producto','=',$laboratorio['laboratorio'])->where('almacen','=',$almacen)->first();
                $productos = ProductosAlmacen::where('producto','=',$laboratorio['laboratorio'])->where('almacen','=',$almacen)->first();
                $productos->cantidad =$product->cantidad - $request->monto_abol['laboratorios'][$key]['abono'];
                $res = $productos->update();
    
              } 
            }
          }

          return redirect()->action('ProductosUsadosController@index1');

    }

    public function storer(Request $request)
    {



        if (isset($request->id_laboratorio)) {
            foreach ($request->id_laboratorio['laboratorios'] as $key => $laboratorio) {
              if (!is_null($laboratorio['laboratorio'])) {

                //dd($request->fecha_vence['laboratorios'][$key]['vence']);
                $lab = new ProductosUsados();
                $lab->producto =  $laboratorio['laboratorio'];
                $lab->cantidad =  $request->monto_abol['laboratorios'][$key]['abono'];
                $lab->almacen =  2;
                $lab->usuario =  Auth::user()->id;
                $lab->save();

               
                $product = ProductosAlmacen::where('producto','=',$laboratorio['laboratorio'])->where('almacen','=','2')->first();
                $productos = ProductosAlmacen::where('producto','=',$laboratorio['laboratorio'])->where('almacen','=','2')->first();
                $productos->cantidad =$product->cantidad - $request->monto_abol['laboratorios'][$key]['abono'];
                $res = $productos->update();
    
              } 
            }
          }

          return redirect()->action('ProductosUsadosController@index');

    }

    public function storel(Request $request)
    {


        if (isset($request->id_laboratorio)) {
            foreach ($request->id_laboratorio['laboratorios'] as $key => $laboratorio) {
              if (!is_null($laboratorio['laboratorio'])) {

                //dd($request->fecha_vence['laboratorios'][$key]['vence']);
                $lab = new ProductosUsados();
                $lab->producto =  $laboratorio['laboratorio'];
                $lab->cantidad =  $request->monto_abol['laboratorios'][$key]['abono'];
                $lab->almacen =  11;
                $lab->usuario =  Auth::user()->id;
                $lab->save();

               
                $product = ProductosAlmacen::where('producto','=',$laboratorio['laboratorio'])->where('almacen','=','11')->first();
                $productos = ProductosAlmacen::where('producto','=',$laboratorio['laboratorio'])->where('almacen','=','11')->first();
                $productos->cantidad =$product->cantidad - $request->monto_abol['laboratorios'][$key]['abono'];
                $res = $productos->update();
    
              } 
            }
          }

          return redirect()->action('ProductosUsadosController@index');

    }

    public function storeo(Request $request)
    {



        if (isset($request->id_laboratorio)) {
            foreach ($request->id_laboratorio['laboratorios'] as $key => $laboratorio) {
              if (!is_null($laboratorio['laboratorio'])) {
                //dd($request->fecha_vence['laboratorios'][$key]['vence']);
                $lab = new ProductosUsados();
                $lab->producto =  $laboratorio['laboratorio'];
                $lab->cantidad =  $request->monto_abol['laboratorios'][$key]['abono'];
                $lab->almacen =  3;
                $lab->usuario =  Auth::user()->id;
                $lab->save();

               
                $product = ProductosAlmacen::where('producto','=',$laboratorio['laboratorio'])->where('almacen','=','3')->first();
                $productos = ProductosAlmacen::where('producto','=',$laboratorio['laboratorio'])->where('almacen','=','3')->first();
                $productos->cantidad =$product->cantidad - $request->monto_abol['laboratorios'][$key]['abono'];
                $res = $productos->update();
    
              } 
            }
          }

          return redirect()->action('ProductosUsadosController@index');

    }

    public function storera(Request $request)
    {



        if (isset($request->id_laboratorio)) {
            foreach ($request->id_laboratorio['laboratorios'] as $key => $laboratorio) {
              if (!is_null($laboratorio['laboratorio'])) {
                //dd($request->fecha_vence['laboratorios'][$key]['vence']);
                $lab = new ProductosUsados();
                $lab->producto =  $laboratorio['laboratorio'];
                $lab->cantidad =  $request->monto_abol['laboratorios'][$key]['abono'];
                $lab->almacen =  4;
                $lab->usuario =  Auth::user()->id;
                $lab->save();

               
                $product = ProductosAlmacen::where('producto','=',$laboratorio['laboratorio'])->where('almacen','=','4')->first();
                $productos = ProductosAlmacen::where('producto','=',$laboratorio['laboratorio'])->where('almacen','=','4')->first();
                $productos->cantidad =$product->cantidad - $request->monto_abol['laboratorios'][$key]['abono'];
                $res = $productos->update();
    
              } 
            }
          }

          return redirect()->action('ProductosUsadosController@index');

    }

    
     

    
    
    public function edit($id)
    {
        $productos = Productos::find($id);
        $unidades = UnidadMedida::all();

        return view('productos.edit', compact('productos','unidades')); //
    }

    public function editingreso($id)
    {
        //$productos = Productos::find($id);
        //$unidades = UnidadMedida::all();

        $ingreso = DB::table('ingresos_detalle as a')
        ->select('a.id','a.producto','a.ingreso','a.vence','a.cantidad','i.created_at','i.usuario','a.precio','i.factura','i.fecha','i.observacion','u.name as usuario','p.nombre as producto')
        ->join('ingresos as i','i.id','a.ingreso')
        ->join('productos as p','p.id','a.producto')
        ->join('users as u','u.id','i.usuario')
        ->where('a.id','=',$id)
        ->first();
      // dd($ingreso);

        return view('productos.edit_ingreso', compact('ingreso')); //
    }

    public function updateingreso(Request $request){

        $ingresosd = IngresosDetalle::find($request->id);
        $ingresosd->cantidad =$request->cantidad;
        $ingresosd->precio =$request->precio;
        $ingresosd->vence =$request->vence;
        $res = $ingresosd->update();

        $product = ProductosAlmacen::where('id','=',$request->ingreso)->first();

        $productosalmacen = ProductosAlmacen::find($request->ingreso);
        $productosalmacen->cantidad =$request->cantidad;
        $productosalmacen->precio =$request->precio;
        $productosalmacen->vence =$request->vence;
        $res = $productosalmacen->update();

        return back();

        //ProductosAlmacen

        //dd($request->all());

    }

    public function ver($id)
    {

        $ingreso = Ingresos::where('id','=',$id)->first();

        $detalle = DB::table('ingresos_detalle as a')
        ->select('a.id','a.ingreso','a.producto','a.vence','u.nombre as nompro','u.categoria','u.medida','a.cantidad','a.precio')
        ->join('productos as u','u.id','a.producto')
        ->get(); 

        
        return view('productos.detalle_ingresos', compact('ingreso','detalle'));
    }

    public function reversar($id)
    {



                $productosu = ProductosUsados::where('id','=',$id)->first();
                $productos = ProductosAlmacen::where('producto','=',$productosu->producto)->where('almacen','=',$productosu->almacen)->first();

                $user = User::where('id','=',Auth::user()->id)->first();

                $ingresosd = ProductosUsados::where('id','=',$id)->first();
                $ingresosd->estatus =0;
                $ingresosd->eliminado_por = $user->name;
                $res = $ingresosd->update();

                $pa = ProductosAlmacen::where('producto','=',$productosu->producto)->where('almacen','=',$productosu->almacen)->first();
                $pa->cantidad =$productos->cantidad + $productosu->cantidad;
                $res = $pa->update();

                return back();
            }

            public function reversar1($id)
            {
        
        
    
                        $productosu = ProductosUsados::where('id','=',$id)->first();
                        $productos = ProductosAlmacen::where('ingreso','=',$id)->first();
        
                        $productosa = ProductosAlmacen::where('ingreso','=',$id)->first();
                        $res = $productosa->delete();
        
                        $ingresosd = IngresosDetalle::where('id','=',$id)->first();
                        $ingresosd->estatus =0;
                        $ingresosd->usuario_elimina = $user->name;
                        $res = $ingresosd->update();
        
                        $f1 = date('Y-m-d');
                        $f2 = date('Y-m-d');
        
                        return back();
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

        
        $productos = Productos::find($request->id);
        $productos->nombre =$request->nombre;
        $productos->medida =$request->medida;
        $productos->categoria =$request->categoria;
        $res = $productos->update();

    
      return redirect()->action('ProductosController@index');

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

        $productos = Productos::find($id);
      $productos->estatus =0;
     
      $res = $productos->update();

        return redirect()->action('ProductosController@index');

        //
    }
}
