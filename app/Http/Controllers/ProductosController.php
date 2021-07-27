<?php

namespace App\Http\Controllers;

use App\Productos;
use App\ProductMov;
use App\ProductosAlmacen;
use App\ProductosUsados;
use App\UnidadMedida;
use App\Ingresos;
use App\User;
use App\Req;
use App\Requerimientos;
use App\MovimientoProductos;
use App\IngresosDetalle;
use Illuminate\Http\Request;
use DB;
use Auth;

class ProductosController extends Controller
{
   
    public function index()
    {

        $productos = Productos::where('estatus','=',1)->get();
        return view('productos.index', compact('productos'));
        //
    }

    public function ingproductos(Request $request)
    {

      

        if($request->inicio){
            $f1 = $request->inicio;
            $f2 = $request->fin;

        $ingresos = DB::table('ingresos_detalle as a')
        ->select('a.id','a.producto','a.ingreso','a.vence','a.estatus','a.usuario_elimina','a.cantidad','i.created_at','i.usuario','a.precio','i.factura','i.fecha','i.observacion','u.name as usuario','p.nombre as producto', 'p.medida')
        ->join('ingresos as i','i.id','a.ingreso')
        ->join('productos as p','p.id','a.producto')
        ->join('users as u','u.id','i.usuario')
        ->whereBetween('i.created_at', [$f1, $f2])
        ->get();


    } else {
        $ingresos = DB::table('ingresos_detalle as a')
        ->select('a.id','a.producto','a.ingreso','a.vence','a.estatus','a.usuario_elimina','a.cantidad','i.created_at','i.usuario','a.precio','i.factura','i.fecha','i.observacion','u.name as usuario','p.nombre as producto','p.medida')
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $unidades = UnidadMedida::all();
        return view('productos.create', compact('unidades'));

        //
    }

    public function ingcreate()
    {

        $productos = Productos::where('estatus','=',1)->orderBy('nombre','ASC')->get();


        return view('productos.ingproducto',compact('productos'));

        //
    }

    

    public function central()
    {


        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.categoria','u.medida','u.minimo','u.minimol','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',1)
        ->where('a.cantidad','>',0)
        ->get(); 

        $total = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.minimol','u.nombre as nompro','u.categoria','u.medida','a.almacen',DB::raw('SUM(a.cantidad*a.precio) as preciototal'))
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',1)
        ->where('a.cantidad','>',0)
        ->first(); 


        return view('productos.central',compact('productos','total'));

        //
    }

    public function laboratorio()
    {


        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.categoria','u.minimol','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',11)
        ->get(); 

        $total = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.minimol','u.nombre as nompro','u.categoria','u.medida','a.almacen',DB::raw('SUM(a.cantidad*a.precio) as preciototal'))
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',11)
        ->first(); 


        return view('productos.laboratorio',compact('productos','total'));

        //
    }

    public function recepcion()
    {

        


        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.minimol','u.nombre as nompro','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',2)
        ->get(); 

        $total = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.minimol','u.nombre as nompro','u.categoria','u.medida','a.almacen',DB::raw('SUM(a.cantidad*a.precio) as preciototal'))
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',2)
        ->first(); 


        return view('productos.recepcion',compact('productos','total'));

        //
    }

    public function obstetra()
    {


        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.minimol','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',3)
        ->get(); 
        $total = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.minimol','u.nombre as nompro','u.categoria','u.medida','a.almacen',DB::raw('SUM(a.cantidad*a.precio) as preciototal'))
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',3)
        ->first(); 


        return view('productos.obstetra',compact('productos','total'));

        //
    }

    public function rayos()
    {


        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.minimol','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',4)
        ->get(); 

        $total = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.minimol','u.nombre as nompro','u.categoria','u.medida','a.almacen',DB::raw('SUM(a.cantidad*a.precio) as preciototal'))
        ->join('productos as u','u.id','a.producto')
        ->where('a.almacen','=',4)
        ->first(); 


        return view('productos.rayos',compact('productos','total'));

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
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.categoria','u.minimol','u.medida','a.almacen')
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

    

        public function getProductosAlmacen(Request $request,$p)
        {

            if($request->session()->get('sedeName') == 'CANTO REY'){
                $almacen = 7;
                } elseif($request->session()->get('sedeName') == 'VIDA FELIZ'){
                $almacen = 8;
                } else {
                $almacen = 9;
                }
    
    
            
            return ProductosAlmacen::where('producto','=',$p)->where('almacen','=',$almacen)->first();
        
        }


    public function getProductosAlmacenr($p)
    {


        
        return ProductosAlmacen::where('producto','=',$p)->where('almacen','=','2')->first();
    
    }

    public function getProductosAlmacenl($p)
    {


        
        return ProductosAlmacen::where('producto','=',$p)->where('almacen','=','11')->first();
    
    }

    public function getProductosAlmaceno($p)
    {
        return ProductosAlmacen::where('producto','=',$p)->where('almacen','=','3')->first();
    
    }

    public function getProductosAlmacenra($p)
    {
        return ProductosAlmacen::where('producto','=',$p)->where('almacen','=','4')->first();
    
    }

    public function storeing(Request $request)
    {


                $ingreso = new Ingresos();
                $ingreso->factura = $request->factura;
                $ingreso->fecha = $request->fecha;
                $ingreso->observacion = $request->observacion;
                $ingreso->usuario = Auth::user()->id;
                $ingreso->save();

        if (isset($request->id_laboratorio)) {
            foreach ($request->id_laboratorio['laboratorios'] as $key => $laboratorio) {
              if (!is_null($laboratorio['laboratorio'])) {

                //dd($request->fecha_vence['laboratorios'][$key]['vence']);
                $lab = new IngresosDetalle();
                $lab->producto =  $laboratorio['laboratorio'];
                $lab->cantidad =  $request->monto_abol['laboratorios'][$key]['abono'];
                $lab->precio =  $request->precio_abol['laboratorios'][$key]['precio'];
                $lab->vence =  $request->fecha_vence['laboratorios'][$key]['vence'];
                $lab->ingreso = $ingreso->id;
                $lab->save();

                if($request->fecha_vence['laboratorios'][$key]['vence'] != null){

                $pal = ProductosAlmacen::where('producto','=',$laboratorio['laboratorio'])->where('vence','=',$request->fecha_vence['laboratorios'][$key]['vence'])->where('almacen','=',1)->first();
                 
                //dd($pal);
                if($pal == null){


                $pa = new ProductosAlmacen();
                $pa->producto =  $laboratorio['laboratorio'];
                $pa->cantidad =  $request->monto_abol['laboratorios'][$key]['abono'];
                $pa->precio =  $request->precio_abol['laboratorios'][$key]['precio'] / $request->monto_abol['laboratorios'][$key]['abono'];
                $pa->vence =  $request->fecha_vence['laboratorios'][$key]['vence'];
                $pa->ingreso = $lab->id;
                $pa->usuario = Auth::user()->id;
                $pa->almacen = 1;
                $pa->save();

                
                $mp = new MovimientoProductos();
                $mp->id_producto_almacen = $pa->id;
                $mp->cantidad = $request->monto_abol['laboratorios'][$key]['abono'];
                $mp->usuario = Auth::user()->id;
                $mp->accion = 'INGRESO A ALMACEN CENTRAL';
                $mp->save();

                } else {

                $pa = ProductosAlmacen::where('producto','=',$laboratorio['laboratorio'])->where('almacen','=',1)->first();
                $pa->cantidad =$pal->cantidad + $request->monto_abol['laboratorios'][$key]['abono'];
               // $pa->precio =  $request->precio_abol['laboratorios'][$key]['precio'] / $request->monto_abol['laboratorios'][$key]['abono'];
                //$pa->vence =  $request->fecha_vence['laboratorios'][$key]['vence'];
                $res = $pa->update();

                $mp = new MovimientoProductos();
                $mp->id_producto_almacen = $pa->id;
                $mp->cantidad = $request->monto_abol['laboratorios'][$key]['abono'];
                $mp->usuario = Auth::user()->id;
                $mp->accion = 'INGRESO A ALMACEN CENTRAL';
                $mp->save();
                    
                }

            } else {

                $pal = ProductosAlmacen::where('producto','=',$laboratorio['laboratorio'])->where('almacen','=',1)->first();

                if($pal == null){


                    $pa = new ProductosAlmacen();
                    $pa->producto =  $laboratorio['laboratorio'];
                    $pa->cantidad =  $request->monto_abol['laboratorios'][$key]['abono'];
                    $pa->precio =  $request->precio_abol['laboratorios'][$key]['precio'] / $request->monto_abol['laboratorios'][$key]['abono'];
                    $pa->vence =  $request->fecha_vence['laboratorios'][$key]['vence'];
                    $pa->ingreso = $lab->id;
                    $pa->usuario = Auth::user()->id;
                    $pa->almacen = 1;
                    $pa->save();

                    $mp = new MovimientoProductos();
                    $mp->id_producto_almacen = $pa->id;
                    $mp->cantidad = $request->monto_abol['laboratorios'][$key]['abono'];
                    $mp->usuario = Auth::user()->id;
                    $mp->accion = 'INGRESO A ALMACEN CENTRAL';
                    $mp->save();
    
                    } else {
    
                    $pa = ProductosAlmacen::where('producto','=',$laboratorio['laboratorio'])->where('almacen','=',1)->first();
                    $pa->cantidad =$pal->cantidad + $request->monto_abol['laboratorios'][$key]['abono'];
                   // $pa->precio =  $request->precio_abol['laboratorios'][$key]['precio'] / $request->monto_abol['laboratorios'][$key]['abono'];
                    //$pa->vence =  $request->fecha_vence['laboratorios'][$key]['vence'];
                    $res = $pa->update();

                    $mp = new MovimientoProductos();
                    $mp->id_producto_almacen = $pa->id;
                    $mp->cantidad = $request->monto_abol['laboratorios'][$key]['abono'];
                    $mp->usuario = Auth::user()->id;
                    $mp->accion = 'INGRESO A ALMACEN CENTRAL';
                    $mp->save();
                        
                    }


            }
               /* $product = Productos::where('id','=',$laboratorio['laboratorio'])->first();
                $productos = Productos::find($laboratorio['laboratorio']);
                $productos->cantidad =$product->cantidad + $request->monto_abol['laboratorios'][$key]['abono'];
                $res = $productos->update();*/
    
              } 
            }
          }

       
    
          return redirect()->action('ProductosController@ingproductos');

    }

     

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validator = \Validator::make($request->all(), [
            'nombre' => 'required|unique:productos'
                
              ]);
              if($validator->fails()) {
                $request->session()->flash('error', 'Ya existe un producto registrado con este Código.');
               // Toastr::error('Error Registrando.', 'Paciente- DNI YA REGISTRADO!', ['progressBar' => true]);
                return redirect()->action('ProductosController@create', ['errors' => $validator->errors()]);
              } else {


        $productos = new Productos();
        $productos->nombre =$request->nombre;
        $productos->medida =$request->medida;
        $productos->minimo =$request->minimo;
        $productos->minimol =$request->minimol;
        $productos->categoria =$request->categoria;
        $productos->usuario =Auth::user()->id;
        $productos->save();

   
    

        return redirect()->action('ProductosController@index', ["created" => true, "productos" => Productos::all()]);
    }

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


        $ingresosd = IngresosDetalle::find($request->ingreso);
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

        return redirect()->action('ProductosController@ingproductos');

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

    public function descargar($id)
    {

        
        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.minimol','u.nombre as nompro','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->where('a.id','=',$id)
        ->first(); 


        return view('productos.descargar', compact('productos'));
    }

    public function editc($id)
    {

        
        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.minimol','u.nombre as nompro','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->where('a.id','=',$id)
        ->first(); 



        return view('productos.editc', compact('productos'));
    }

    public function requerimiento($id)
    {

        
        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.minimol','u.nombre as nompro','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->where('a.id','=',$id)
        ->first(); 


        return view('productos.requerimiento', compact('productos'));
    }

    public function historial($id)
    {

        
        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.minimol','u.nombre as nompro','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->where('a.id','=',$id)
        ->first(); 

        $historial = DB::table('movimiento_productos as a')
        ->select('a.id','a.id_producto_almacen','a.cantidad','a.accion','a.usuario','us.name','a.created_at','u.almacen')
        ->join('productos_almacen as u','u.id','a.id_producto_almacen')
        ->join('users as us','us.id','a.usuario')
        ->where('a.id_producto_almacen','=',$id)
        ->where('u.almacen','=',$productos->almacen)
        ->get(); 


        return view('productos.movimientos', compact('productos','historial'));
    }

    public function descargarPost(Request $request)
    {


                $pr = ProductosAlmacen::where('id','=',$request->id)->first();


                $ingresosd = ProductosAlmacen::where('id','=',$request->id)->first();
                $ingresosd->cantidad = $pr->cantidad - $request->cant;
                $res = $ingresosd->update();

                
            $mp = new MovimientoProductos();
            $mp->id_producto_almacen = $ingresosd->id;
            $mp->cantidad = $request->cant;
            $mp->usuario = Auth::user()->id;
            $mp->accion = 'DESCARGA DE ALMACEN';
            $mp->save();

                


                $lab = new ProductosUsados();
                $lab->producto =  $pr->producto;
                $lab->cantidad =  $request->cant;
                $lab->fecha =  $request->fecha;
                $lab->precio =  $pr->precio;
                $lab->almacen =  $request->almacen;
                $lab->usuario =  Auth::user()->id;
                $lab->save();


            

                return back();
            }

            public function editcP(Request $request)
    {



                $ingresosd = ProductosAlmacen::where('id','=',$request->id)->first();
                $ingresosd->cantidad = $request->cantidad;
                $ingresosd->precio = $request->precio;
                $res = $ingresosd->update();

                $mp = new MovimientoProductos();
                $mp->id_producto_almacen = $ingresosd->id;
                $mp->cantidad = $request->cantidad;
                $mp->usuario = Auth::user()->id;
                $mp->accion = 'EDICIÓN DE CANTIDAD/PRECIO';
                $mp->save();


              

            

                return back();
            }

            public function reqPost(Request $request)
            {

                $almacen = ProductosAlmacen::where('id','=',$request->id)->first();

    
                $req1 = new Req();
                $req1->save();

                $req = new Requerimientos();
                $req->producto =  $almacen->producto;
                $req->cantidad_solicita =  $request->cantidad;
                $req->almacen_solicita =  $request->almacen;
                $req->usuario =  Auth::user()->id;
                $req->req =  $req1->id;
                $req->sede =  $request->session()->get('sede');
                $req->save();
        
        
        
        
                
                
                return back();
        
            }

    public function reversar($id)
    {


                $user = User::where('id','=',Auth::user()->id)->first();

                $ingreso = IngresosDetalle::where('id','=',$id)->first();
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
        $productos->minimo =$request->minimo;
        $productos->minimol =$request->minimol;
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
