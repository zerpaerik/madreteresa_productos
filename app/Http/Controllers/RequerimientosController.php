<?php

namespace App\Http\Controllers;
use App\Equipos;
use App\Requerimientos;
use App\Req;
use App\ProductosAlmacen;
use App\MovimientoProductos;
use App\Clientes;
use App\Productos;
use App\User;
use Auth;
use Illuminate\Http\Request;
use DB;

class RequerimientosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        
        if($request->inicio){
            $f1 = $request->inicio;
            $f2 = $request->fin;

        $requerimientos = DB::table('requerimientos as a')
        ->select('a.id','a.producto','a.created_at','a.almacen_solicita','a.sede','a.cantidad_solicita','a.estatus','b.name as user','p.nombre as nompro','p.medida as medida')
        ->join('users as b','b.id','a.usuario')
        ->join('productos as p','p.id','a.producto')
        ->where('a.sede', '=', $request->session()->get('sede'))
        ->where('a.almacen_solicita', '=', $request->solicita)
        ->whereBetween('a.created_at', [$f1, $f2])
        ->get(); 

        $alma = $request->solicita;

    } else {
        $f1 = date('Y-m-d');
        $f2 = date('Y-m-d');

        $requerimientos = DB::table('requerimientos as a')
        ->select('a.id','a.producto','a.created_at','a.almacen_solicita','a.sede','a.cantidad_solicita','a.estatus','b.name as user','p.nombre as nompro','p.medida as medida')
        ->join('users as b','b.id','a.usuario')
        ->join('productos as p','p.id','a.producto')
        ->where('a.sede', '=', $request->session()->get('sede'))
        ->whereBetween('a.created_at', [$f1, $f2])
        ->get(); 

        $alma = 2;


    }

        return view('requerimientos.index', compact('requerimientos','f1','f2','alma'));
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index1(Request $request)
    {

        if($request->inicio){
            $f1 = $request->inicio;
            $f2 = $request->fin;

        $requerimientos = DB::table('requerimientos as a')
        ->select('a.id','a.producto','a.almacen_solicita','a.sede','a.created_at','a.cantidad_solicita','a.estatus','b.name as user','p.nombre as nompro','p.medida as medida')
        ->join('users as b','b.id','a.usuario')
        ->join('productos as p','p.id','a.producto')
        ->whereBetween('a.created_at', [$f1, $f2])
        ->where('a.almacen_solicita', '=', $request->solicita)
        ->where('a.estatus', '=', 1)
        ->get(); 

        $alma = $request->solicita;



    } else {
        $f1 = date('Y-m-d');
        $f2 = date('Y-m-d');

        $requerimientos = DB::table('requerimientos as a')
        ->select('a.id','a.producto','a.almacen_solicita','a.sede','a.created_at','a.cantidad_solicita','a.estatus','b.name as user','p.nombre as nompro','p.medida as medida')
        ->join('users as b','b.id','a.usuario')
        ->join('productos as p','p.id','a.producto')
        ->where('a.estatus', '=', 1)
        ->whereBetween('a.created_at', [$f1, $f2])
        ->get(); 

        $alma =2;


      
    }

        return view('requerimientos.index1', compact('requerimientos','f1','f2','alma'));
        //
    }

    public function index2(Request $request)
    {


        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->orderBy('nompro','ASC')
        ->groupBy('a.producto')
        ->where('a.almacen','=',1)
        ->get();  

        if ($request->inicio && is_null($request->producto)) {
            $f1 = $request->inicio;
            $f2 = $request->fin;

            $alma = $request->solicita;


            if ($request->solicita == '99') {
                $requerimientos = DB::table('requerimientos as a')
            ->select('a.id', 'a.producto', 'a.req', 'a.almacen_solicita', 'a.sede', 'a.created_at', 'a.cantidad_despachada', 'a.cantidad_solicita', 'a.estatus', 'b.name as user', 'p.nombre as nompro', 'p.medida as medida','pa.precio')
            ->join('users as b', 'b.id', 'a.usuario')
            ->join('productos as p', 'p.id', 'a.producto')
            ->join('productos_almacen as pa', 'pa.producto', 'a.producto')
            ->whereBetween('a.created_at', [$f1, $f2])
            ->where('a.estatus', '=', 2)
            ->groupBy('a.id')
            ->get();


            } else {

                $requerimientos = DB::table('requerimientos as a')
            ->select('a.id', 'a.producto', 'a.req', 'a.almacen_solicita', 'a.sede', 'a.created_at', 'a.cantidad_despachada', 'a.cantidad_solicita', 'a.estatus', 'b.name as user', 'p.nombre as nompro', 'p.medida as medida','pa.precio')
            ->join('users as b', 'b.id', 'a.usuario')
            ->join('productos as p', 'p.id', 'a.producto')
            ->join('productos_almacen as pa', 'pa.producto', 'a.producto')
            ->whereBetween('a.created_at', [$f1, $f2])
            ->where('a.almacen_solicita', '=', $request->solicita)
            ->where('a.estatus', '=', 2)
            ->groupBy('a.id')
            ->get();



            }
        
            if ($request->solicita == '99') {

              

                $soli = DB::table('requerimientos as a')
                ->select('a.id', 'a.producto', 'a.req', 'a.almacen_solicita', 'a.sede', 'a.created_at', 'a.cantidad_despachada', 'a.cantidad_solicita', 'a.estatus', 'b.name as user', 'p.nombre as nompro', 'p.medida as medida','pa.precio as precio','pa.id',DB::raw('COUNT(*) as item, SUM(cantidad_despachada) as cant, SUM(a.cantidad_despachada*pa.precio) as preciototal'))
                ->join('users as b', 'b.id', 'a.usuario')
                ->join('productos as p', 'p.id', 'a.producto')
                ->join('productos_almacen as pa', 'pa.producto', 'a.producto')
                ->whereBetween('a.created_at', [$f1, $f2])
                ->where('a.estatus', '=', 2)
                ->groupBy('pa.id')
                ->first();


                } else {
                

                    $soli = DB::table('requerimientos as a')
                    ->select('a.id', 'a.producto', 'a.req', 'a.almacen_solicita', 'a.sede', 'a.created_at', 'a.cantidad_despachada', 'a.cantidad_solicita', 'a.estatus', 'b.name as user', 'p.nombre as nompro', 'p.medida as medida','pa.precio as precio','pa.id',DB::raw('COUNT(*) as item, SUM(cantidad_despachada) as cant, SUM(a.cantidad_despachada*pa.precio) as preciototal'))
                    ->join('users as b', 'b.id', 'a.usuario')
                    ->join('productos as p', 'p.id', 'a.producto')
                    ->join('productos_almacen as pa', 'pa.producto', 'a.producto')
                    ->where('a.almacen_solicita', '=', $request->solicita)
                    ->whereBetween('a.created_at', [$f1, $f2])
                    ->where('a.estatus', '=', 2)
                    ->groupBy('pa.id')
                    ->first();




                }

        if ($soli->item == 0) {
        $soli->cant = 0;
        }

       


        $prod= 0;



    
       } else if($request->inicio && !is_null($request->producto)) {

                $f1 = $request->inicio;
                $f2 = $request->fin;

                if ($request->solicita == '99') {
                    $requerimientos = DB::table('requerimientos as a')
                    ->select('a.id', 'a.producto', 'a.req', 'a.almacen_solicita', 'a.sede', 'a.created_at', 'a.cantidad_despachada', 'a.cantidad_solicita', 'a.estatus', 'b.name as user', 'p.nombre as nompro', 'p.medida as medida','pa.precio')
                    ->join('users as b', 'b.id', 'a.usuario')
                    ->join('productos as p', 'p.id', 'a.producto')
                    ->join('productos_almacen as pa', 'pa.producto', 'a.producto')
                    ->whereBetween('a.created_at', [$f1, $f2])
                    ->where('a.producto', '=', $request->producto)
                    ->where('a.estatus', '=', 2)
                    ->groupBy('a.id')
                    ->get();



                  /*  $soli = Requerimientos::whereBetween('created_at', [$f1, $f2])
                ->where('estatus', '=', 2)
                ->where('producto', '=', $request->producto)
                ->select(DB::raw('COUNT(*) as item, SUM(cantidad_despachada) as cant'))
                ->first();*/


                $soli = DB::table('requerimientos as a')
                ->select('a.id', 'a.producto', 'a.req', 'a.almacen_solicita', 'a.sede', 'a.created_at', 'a.cantidad_despachada', 'a.cantidad_solicita', 'a.estatus', 'b.name as user', 'p.nombre as nompro', 'p.medida as medida','pa.precio as precio','pa.id',DB::raw('COUNT(*) as item, SUM(cantidad_despachada) as cant, SUM(a.cantidad_despachada*pa.precio) as preciototal'))
                ->join('users as b', 'b.id', 'a.usuario')
                ->join('productos as p', 'p.id', 'a.producto')
                ->join('productos_almacen as pa', 'pa.producto', 'a.producto')
                ->where('a.producto', '=', $request->producto)
                ->whereBetween('a.created_at', [$f1, $f2])
                ->where('a.estatus', '=', 2)
                ->groupBy('pa.id')
                ->first();

                $alma = 2;

    






                } else {
                    $requerimientos = DB::table('requerimientos as a')
                    ->select('a.id', 'a.producto', 'a.req', 'a.almacen_solicita', 'a.sede', 'a.created_at', 'a.cantidad_despachada', 'a.cantidad_solicita', 'a.estatus', 'b.name as user', 'p.nombre as nompro', 'p.medida as medida','pa.precio')
                    ->join('users as b', 'b.id', 'a.usuario')
                    ->join('productos as p', 'p.id', 'a.producto')
                    ->join('productos_almacen as pa', 'pa.producto', 'a.producto')
                    ->whereBetween('a.created_at', [$f1, $f2])
                    ->where('a.almacen_solicita', '=', $request->solicita)
                    ->where('a.producto', '=', $request->producto)
                    ->where('a.estatus', '=', 2)
                    ->groupBy('a.id')
                    ->get();



                  

                    $alma = $request->solicita;

            
                            /*    $soli = Requerimientos::whereBetween('created_at', [$f1, $f2])
                            ->where('almacen_solicita', '=', $request->solicita)
                            ->where('estatus', '=', 2)
                            ->where('producto', '=', $request->producto)
                            ->select(DB::raw('COUNT(*) as item, SUM(cantidad_despachada) as cant'))
                            ->first();*/

                            $soli = DB::table('requerimientos as a')
                            ->select('a.id', 'a.producto', 'a.req', 'a.almacen_solicita', 'a.sede', 'a.created_at', 'a.cantidad_despachada', 'a.cantidad_solicita', 'a.estatus', 'b.name as user', 'p.nombre as nompro', 'p.medida as medida','pa.precio as precio','pa.id',DB::raw('COUNT(*) as item, SUM(cantidad_despachada) as cant, SUM(a.cantidad_despachada*pa.precio) as preciototal'))
                            ->join('users as b', 'b.id', 'a.usuario')
                            ->join('productos as p', 'p.id', 'a.producto')
                            ->join('productos_almacen as pa', 'pa.producto', 'a.producto')
                            ->where('a.almacen_solicita', '=', $request->solicita)
                            ->where('a.producto', '=', $request->producto)
                            ->whereBetween('a.created_at', [$f1, $f2])
                            ->where('a.estatus', '=', 2)
                            ->groupBy('pa.id')
                            ->first();

                }

        $prod = ProductosAlmacen::where('producto','=',$request->producto )
        ->where('almacen','=',$request->solicita)
        //->where('estatus', '=', 2)
        //->where('producto', '=', $request->producto)
        ->select('precio')
        ->first();


        if ($soli->item == 0) {
        $soli->cant = 0;
        }

      } else {
        $f1 = date('Y-m-d');
        $f2 = date('Y-m-d');

        $alma = 2;



        

        $requerimientos = DB::table('requerimientos as a')
        ->select('a.id','a.producto','a.req','a.almacen_solicita','a.sede','a.created_at','a.cantidad_despachada','a.cantidad_solicita','a.estatus','b.name as user','p.nombre as nompro','p.medida as medida','pa.precio')
        ->join('users as b','b.id','a.usuario')
        ->join('productos as p','p.id','a.producto')
        ->join('productos_almacen as pa', 'pa.producto', 'a.producto')
        ->where('a.estatus', '=', 2)
        ->whereBetween('a.created_at', [$f1, $f2])
        ->groupBy('a.id')
        ->get(); 



        //dd($requerimientos);


      /*  $soli = Requerimientos::whereBetween('created_at',  [$f1, $f2])
        ->where('estatus', '=', 2)
        ->select(DB::raw('COUNT(*) as item, SUM(cantidad_despachada) as cant'))
        ->first();*/

        $soli = DB::table('requerimientos as a')
        ->select('a.id', 'a.producto', 'a.req', 'a.almacen_solicita', 'a.sede', 'a.created_at', 'a.cantidad_despachada', 'a.cantidad_solicita', 'a.estatus', 'b.name as user', 'p.nombre as nompro', 'p.medida as medida','pa.precio as precio','pa.id',DB::raw('COUNT(*) as item, SUM(cantidad_despachada) as cant, SUM(a.cantidad_despachada*pa.precio) as preciototal'))
        ->join('users as b', 'b.id', 'a.usuario')
        ->join('productos as p', 'p.id', 'a.producto')
        ->join('productos_almacen as pa', 'pa.producto', 'a.producto')
        ->whereBetween('a.created_at', [$f1, $f2])
        ->where('a.estatus', '=', 2)
        ->groupBy('pa.id')
        ->first();


         $prod = 0;


      


        if ($soli == null) {
        $soli->cant = 0;
        }

      
    }

        return view('requerimientos.index2', compact('requerimientos','f1','f2','productos','soli','prod','alma'));
        
    }

    public function enviados(Request $request)
    {

        if($request->inicio){
            $f1 = $request->inicio;
            $f2 = $request->fin;

        $requerimientos = DB::table('requerimientos as a')
        ->select('a.id','a.producto','a.almacen_solicita','a.sede','a.created_at','a.cantidad_despachada','a.cantidad_solicita','a.estatus','b.name as user','p.nombre as nompro','p.medida as medida')
        ->join('users as b','b.id','a.usuario')
        ->join('productos as p','p.id','a.producto')
        ->where('a.sede', '=', $request->session()->get('sede'))
        ->whereBetween('a.created_at', [$f1, $f2])
        //->where('a.estatus', '=', 2)
        ->get(); 


    } else {
        $f1 = date('Y-m-d');
        $f2 = date('Y-m-d');

        $requerimientos = DB::table('requerimientos as a')
        ->select('a.id','a.producto','a.almacen_solicita','a.sede','a.created_at','a.cantidad_despachada','a.cantidad_solicita','a.estatus','b.name as user','p.nombre as nompro','p.medida as medida')
        ->join('users as b','b.id','a.usuario')
        ->join('productos as p','p.id','a.producto')
        ->where('a.sede', '=', $request->session()->get('sede'))
        //->where('a.estatus', '=', 2)
        ->whereBetween('a.created_at', [$f1, $f2])
        ->get(); 

      
    }

        return view('requerimientos.enviados', compact('requerimientos','f1','f2'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->orderBy('nompro','ASC')
        ->groupBy('a.producto')
        ->where('a.almacen','=',1)
        ->get();         
        
        return view('requerimientos.create', compact('productos'));

        //
    }

    public function create1()
    {
        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->orderBy('nompro','ASC')
        ->groupBy('a.producto')
        ->where('a.almacen','=',1)
        ->where('a.cantidad','>',0)
        ->get();         
        
        return view('requerimientos.create1', compact('productos'));

        //
    }

    public function createa($id)
    {
        $productos = DB::table('productos_almacen as a')
        ->select('a.id','a.producto','a.cantidad','a.precio','a.vence','u.nombre as nompro','u.categoria','u.medida','a.almacen')
        ->join('productos as u','u.id','a.producto')
        ->orderBy('nompro','ASC')
        ->groupBy('a.producto')
        ->where('a.almacen','=',1)
        ->where('a.cantidad','>',0)
        ->get();         
        
        return view('requerimientos.createa', compact('productos','id'));

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


        if($request->id_laboratorio['laboratorios'][0]['laboratorio'] == null) {
            $request->session()->flash('error', 'Debe seleccionar al menos un producto para registrar el requerimiento.');
           // Toastr::error('Error Registrando.', 'Paciente- DNI YA REGISTRADO!', ['progressBar' => true]);
            return redirect()->action('RequerimientosController@create');
          } else {
              $req1 = new Req();
              $req1->save();


              if (isset($request->id_laboratorio)) {
                  foreach ($request->id_laboratorio['laboratorios'] as $key => $laboratorio) {
                      if (!is_null($laboratorio['laboratorio'])) {
                          $req = new Requerimientos();
                          $req->producto =  $laboratorio['laboratorio'];
                          $req->cantidad_solicita =  $request->monto_abol['laboratorios'][$key]['abono'];
                          $req->almacen_solicita =  $request->solicita;
                          $req->usuario =  Auth::user()->id;
                          $req->req =  $req1->id;
                          $req->sede =  $request->session()->get('sede');
                          $req->save();
                      }
                  }
              }

              return redirect()->action('RequerimientosController@index', ["created" => true, "req" => Requerimientos::all()]);

          }


        
        


    }

    public function store1(Request $request)
    {


        if($request->id_laboratorio['laboratorios'][0]['laboratorio'] == null) {
            $request->session()->flash('error', 'Debe seleccionar al menos un producto para registrar el requerimiento.');
           // Toastr::error('Error Registrando.', 'Paciente- DNI YA REGISTRADO!', ['progressBar' => true]);
            return redirect()->action('RequerimientosController@create');
          } else{
        $req1 = new Req();
        $req1->save();


        if (isset($request->id_laboratorio)) {
            foreach ($request->id_laboratorio['laboratorios'] as $key => $laboratorio) {
              if (!is_null($laboratorio['laboratorio'])) {



                if($request->session()->get('sedeName') == 'CANTO REY'){
                $almacen = 7;
                } elseif($request->session()->get('sedeName') == 'VIDA FELIZ'){
                $almacen = 8;
                } else {
                $almacen = 9;
                }

      
                $req = new Requerimientos();
                $req->producto =  $laboratorio['laboratorio'];
                $req->cantidad_solicita =  $request->monto_abol['laboratorios'][$key]['abono'];
                $req->almacen_solicita =  $almacen;
                $req->usuario =  Auth::user()->id;
                $req->req =  $req1->id;
                $req->sede =  $request->session()->get('sede');
                $req->save();

              } 
            }
          }

          return redirect()->action('RequerimientosController@enviados', ["created" => true, "req" => Requerimientos::all()]);


          }


        
        


    }

    public function storea(Request $request)
    {

        $req1 = new Req();
        $req1->save();



        if (isset($request->id_laboratorio)) {
            foreach ($request->id_laboratorio['laboratorios'] as $key => $laboratorio) {
              if (!is_null($laboratorio['laboratorio'])) {



                /*if($request->session()->get('sedeName') == 'CANTO REY'){
                $almacen = 7;
                } elseif($request->session()->get('sedeName') == 'VIDA FELIZ'){
                $almacen = 8;
                } else {
                $almacen = 9;
                }*/

      
                $req = new Requerimientos();
                $req->producto =  $laboratorio['laboratorio'];
                $req->cantidad_solicita =  $request->monto_abol['laboratorios'][$key]['abono'];
                $req->almacen_solicita =  $request->almacen;
                $req->usuario =  Auth::user()->id;
                $req->req =  $req1->id;
                $req->sede =  $request->session()->get('sede');
                $req->save();

              } 
            }
          }


        
        
        return redirect()->action('RequerimientosController@enviados', ["created" => true, "req" => Requerimientos::all()]);

    }

    public function ver($id)
    {
	  
        $req = DB::table('requerimientos as a')
        ->select('a.id','a.asunto','a.prioridad','a.categoria','a.descripcion','a.estatus','a.estado','a.empresa','b.nombre as empresa')
        ->join('clientes as b','b.id','a.empresa')
        ->where('a.empresa', '=', Auth::user()->empresa)
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Clientes  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        


        $req = Requerimientos::where('id','=',$request->id)->first();

        if($req->almacen_solicita == 2){
            $es_alm= 'RECEPCIÓN';

        } elseif($req->almacen_solicita == 3){
            $es_alm= 'OBSTETRA';

        } elseif($req->almacen_solicita == 4){
            $es_alm= 'RAYOSX';

        } elseif($req->almacen_solicita == 7){
            $es_alm= 'LABORATORIO';

        } elseif($req->almacen_solicita == 8){
            $es_alm= 'CANTO REY';

        } elseif($req->almacen_solicita == 9){
            $es_alm= 'VIDA FELIZ';
        } else {
            $es_alm= 'ZARATE';


        }


        $producto = ProductosAlmacen::where('producto','=',$req->producto)->where('almacen','=',1)->first();


        $producto_cantidad = ProductosAlmacen::where('producto','=',$req->producto)
        ->where('almacen','=',1)
        ->select(DB::raw('SUM(cantidad) as cantidad'))
        ->first();


        $pal = ProductosAlmacen::where('producto','=',$req->producto)->where('almacen','=',$req->almacen_solicita)->first();

     if($request->cantidad > $req->cantidad_solicita){
        return redirect()->action('RequerimientosController@index1')
        ->with('error','La cantidad despachada no puede ser mayor que la solicitada');

    } else if($request->cantidad > $producto_cantidad->cantidad) {
        return redirect()->action('RequerimientosController@index1')
        ->with('error','La cantidad solicitada excede el stock en almacen, debe hacer la solicitud por una cantidad menor'.' STOCK:'.''.$producto_cantidad->cantidad);

     } else {

            if($pal == null){


            $pa = new ProductosAlmacen();
            $pa->producto =  $req->producto;
            $pa->cantidad =  $request->cantidad;
            $pa->precio =  $producto->precio;
            $pa->vence =  $producto->vence;
           // $pa->ingreso = $lab->id;
            $pa->usuario = Auth::user()->id;
            $pa->almacen = $req->almacen_solicita;
            $pa->save();

            //MOVIMIENTO SALIDA
            $mp = new MovimientoProductos();
            $mp->id_producto_almacen = $producto->id;
            $mp->cantidad = $request->cantidad;
            $mp->usuario = Auth::user()->id;
            $mp->accion = 'DESPACHO  DE REQUERIMIENTO A '.'-'.$es_alm;
            $mp->save();

            //MOVIMIENTO ENTRADA

            $mp = new MovimientoProductos();
            $mp->id_producto_almacen = $pa->id;
            $mp->cantidad = $request->cantidad;
            $mp->usuario = Auth::user()->id;
            $mp->accion = 'ENTRADA DE PRODUCTO DESDE ALM CENTRAL';
            $mp->save();

            } else {

            $pa = ProductosAlmacen::where('producto','=',$req->producto)->where('almacen','=',$req->almacen_solicita)->first();
            $pa->cantidad =$pal->cantidad + $request->cantidad;
            $pa->precio =  $producto->precio;
            $pa->vence =  $producto->vence;
            $res = $pa->update();

            //MOVIMIENTO SALIDA

            $mp = new MovimientoProductos();
            $mp->id_producto_almacen = $producto->id;
            $mp->cantidad = $request->cantidad;
            $mp->usuario = Auth::user()->id;
            $mp->accion = 'DESPACHO DE REQUERIMIENTO A'.'-'.$es_alm;
            $mp->save();


            //MOVIMIENTO ENTRADA

            $mp = new MovimientoProductos();
            $mp->id_producto_almacen = $pa->id;
            $mp->cantidad = $request->cantidad;
            $mp->usuario = Auth::user()->id;
            $mp->accion = 'ENTRADA DE PRODUCTO DESDE ALM CENTRAL';
            $mp->save();


                
            }

           
            $pac = ProductosAlmacen::where('producto','=',$req->producto)->where('almacen','=',1)->orderBy('vence','ASC')->get();

            if($pac[0]->cantidad >= $request->cantidad){

                $pc = ProductosAlmacen::where('producto','=',$pac[0]->producto)->first();
                $pc->cantidad = $pac[0]->cantidad - $request->cantidad;
                $res = $pc->update();

              /*  $mp = new MovimientoProductos();
                $mp->id_producto_almacen = $pc->id;
                $mp->cantidad = $request->cantidad;
                $mp->usuario = Auth::user()->id;
                $mp->accion = 'DESPACHO DE REQUERIMIENTO'.'-'.$es_alm;
                $mp->save();*/

                $pa = Requerimientos::where('id','=',$request->id)->first();
                $pa->estatus =  2;
                $pa->cantidad_despachada = $request->cantidad;
                $res = $pa->update();


            } else {


                $totalr = $request->cantidad - $pac[0]->cantidad;


                $pc = ProductosAlmacen::where('producto','=',$pac[0]->producto)->first();
                $pc->cantidad = 0;
                $ress = $pc->update();

               /* $mp = new MovimientoProductos();
                $mp->id_producto_almacen = $pc->id;
                $mp->cantidad = $request->cantidad;
                $mp->usuario = Auth::user()->id;
                $mp->accion = 'DESPACHO DE REQUERIMIENTO'.'-'.$es_alm;
                $mp->save();*/

                $pa = Requerimientos::where('id','=',$request->id)->first();
                $pa->estatus =  2;
                $pa->cantidad_despachada = $request->cantidad;
                $resss = $pa->update();


                if($pac[1]->cantidad >= $totalr){



                    $pca = ProductosAlmacen::where('id','=',$pac[1]->id)->first();
                    $pca->cantidad = $pac[1]->cantidad - $totalr;
                    $resss = $pca->update();

                 /*   $mp = new MovimientoProductos();
                    $mp->id_producto_almacen = $pca->id;
                    $mp->cantidad = $request->cantidad;
                    $mp->usuario = Auth::user()->id;
                    $mp->accion = 'DESPACHO DE REQUERIMIENTO'.'-'.$es_alm;
                    $mp->save();*/


                } else {


                $totalr3 = $request->cantidad - $pac[1]->cantidad;

                $pc3 = ProductosAlmacen::where('id','=',$pac[1]->id)->first();
                $pc3->cantidad = 0;
                $res = $pc3->update();

                
              /*  $mp = new MovimientoProductos();
                $mp->id_producto_almacen = $pc3->id;
                $mp->cantidad = $request->cantidad;
                $mp->usuario = Auth::user()->id;
                $mp->accion = 'DESPACHO DE REQUERIMIENTO'.'-'.$es_alm;
                $mp->save();*/

                $pc4 = ProductosAlmacen::where('id','=',$pac[2]->id)->first();
                $pc4->cantidad = $pac[2]->cantidad - $totalr3;
                $res1 = $pc4->update();


                }

            } 

        }

            return back();


        
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
    public function reversar($id)
    {

            
            $r = Requerimientos::where('id','=',$id)->first();

            $p = ProductosAlmacen::where('producto','=',$r->producto)->where('almacen','=',1)->first();
            $ps = ProductosAlmacen::where('producto','=',$r->producto)->where('almacen','=',$r->almacen_solicita)->first();

            $pa = ProductosAlmacen::where('producto','=',$r->producto)->where('almacen','=',1)->first();
            $pa->cantidad = $p->cantidad + $r->cantidad_despachada;
            $res = $pa->update();

            $pal = ProductosAlmacen::where('producto','=',$r->producto)->where('almacen','=',$r->almacen_solicita)->first();
            $pal->cantidad = $ps->cantidad - $r->cantidad_despachada;
            $res = $pal->update();


            $mp = new MovimientoProductos();
            $mp->id_producto_almacen = $pal->id;
            $mp->cantidad = $r->cantidad_despachada;
            $mp->usuario = Auth::user()->id;
            $mp->accion = 'REVERSO DE REQUERIMIENTO';
            $mp->save();


            

            $req = Requerimientos::where('id','=',$id)->first();
            $req->estatus =  1;
            $req->cantidad_despachada = NULL;
            $res = $req->update();

         return back();

        //
    }

    public function delete($id)
    {

      $cr = Requerimientos::where('id','=',$id)->first();
      $cr->delete();

      return back();
    }

    public function ticket($id)
    {

        $requerimientos = DB::table('requerimientos as a')
        ->select('a.id','a.req','a.producto','a.created_at','a.updated_at','a.almacen_solicita','a.sede','a.cantidad_despachada','a.cantidad_solicita','a.estatus','b.name as user','p.nombre as nompro','p.medida as medida')
        ->join('users as b','b.id','a.usuario')
        ->join('productos as p','p.id','a.producto')
        ->where('a.req','=', $id)
        ->where('a.estatus','=', 2)
        ->get(); 

      


        $view = \View::make('requerimientos.ticket', compact('requerimientos'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
     
    
        return $pdf->stream('requerimientos-pedido'.'.pdf');  
      }
}

