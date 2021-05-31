<?php

namespace App\Http\Controllers;
use App\Equipos;
use App\Analisis;
use App\Debitos;
use App\Creditos;
use App\Tiempo;
use App\Material;
use App\User;
use Auth;
use Illuminate\Http\Request;
use DB;

class GastosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->inicio){

        $gastos = DB::table('debitos as a')
        ->select('a.id','a.descripcion','a.monto','a.usuario','a.cliente','a.created_at','b.name')
        ->join('users as b','b.id','a.usuario')
        ->where('a.created_at','=', $request->inicio)
        ->get(); 
        $f1 = $request->inicio;


        $deb = Debitos::where('created_at', '=',$request->inicio)
        ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
        ->first();

        if ($deb->cantidad == 0) {
        $deb->monto = 0;
        }
            


        } else {
            $gastos = DB::table('debitos as a')
            ->select('a.id','a.descripcion','a.monto','a.usuario','a.cliente','a.created_at','b.name')
            ->join('users as b','b.id','a.usuario')
            ->where('a.created_at', date('Y-m-d'))
            ->get(); 

            $f1 =date('Y-m-d');
            $f2 = date('Y-m-d');

            
        $deb = Debitos::where('created_at', '=',$f1)
        ->select(DB::raw('COUNT(*) as cantidad, SUM(monto) as monto'))
        ->first();

        if ($deb->cantidad == 0) {
        $deb->monto = 0;
        }
            
        }

        return view('gastos.index', compact('gastos','f1','deb'));
        //
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gastos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $gastos = new Debitos();
        $gastos->descripcion =$request->descripcion;
        $gastos->tipopago ='EF';
        $gastos->fecha =date('Y-m-d H:i:s');
        $gastos->monto =$request->monto;
        $gastos->origen ='GASTOS';
        $gastos->nombre =Auth::user()->name;
        $gastos->usuario =Auth::user()->id;
        $gastos->save();

        

        return redirect()->action('GastosController@index', ["created" => true, "gastos" => Debitos::all()]);

    }

  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Analisis  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $gastos = Creditos::where('id','=',$id)->first();

        return view('gastos.edit', compact('gastos')); //
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

      $p = Debitos::find($request->id);
      $p->descripcion =$request->descripcion;
      $p->monto =$request->monto;
      $p->tipopago =$request->tipopago;
      $res = $p->update();
      return redirect()->action('GastosController@index');

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Debitos  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $ingresos = Debitos::where('id','=',$id);
        $ingresos->delete();

        return redirect()->action('GastosController@index');

        //
    }
}

