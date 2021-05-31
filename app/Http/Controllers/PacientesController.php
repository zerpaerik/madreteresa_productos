<?php

namespace App\Http\Controllers;
use App\Equipos;
use App\Analisis;
use App\Clientes;
use App\Tiempo;
use App\Material;
use App\Pacientes;
use App\User;
use Auth;
use Illuminate\Http\Request;
use DB;

class PacientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pacientes = DB::table('pacientes as a')
        ->select('a.id','a.nombres','a.dni','a.apellidos','a.fechanac','a.email','a.sexo','a.telefono','a.empresa','a.estatus')
        ->where('a.empresa', '=', Auth::user()->empresa)
        ->where('a.estatus', '=', 1)
        ->get(); 

        return view('pacientes.index', compact('pacientes'));
        //
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('pacientes.create');
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
        'dni' => 'required|unique:pacientes'
            
          ]);
          if($validator->fails()) {
            $request->session()->flash('error', 'El Paciente ya esta Registrado.');
           // Toastr::error('Error Registrando.', 'Paciente- DNI YA REGISTRADO!', ['progressBar' => true]);
            return redirect()->action('PacientesController@create', ['errors' => $validator->errors()]);
          } else {

        $pacientes = new Pacientes();
        $pacientes->nombres =$request->nombres;
        $pacientes->apellidos =$request->apellidos;
        $pacientes->dni =$request->dni;
        $pacientes->telefono =$request->telefono;
        $pacientes->email =$request->email;
        $pacientes->direccion =$request->direccion;
        $pacientes->edocivil =$request->edocivil;
        $pacientes->ocupacion =$request->ocupacion;
        $pacientes->fechanac =$request->fechanac;
        $pacientes->sexo =$request->sexo;
        $pacientes->empresa =Auth::user()->empresa;
        $pacientes->usuario =Auth::user()->id;
        $pacientes->save();

        return redirect()->action('PacientesController@index', ["created" => true, "pacientes" => Pacientes::all()]);
    }

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
     * @param  \App\Pacientes  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pacientes = Pacientes::where('id','=',$id)->first();

        return view('pacientes.edit', compact('pacientes')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pacientes  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pacientes $pacientes)
    {

        $validator = \Validator::make($request->all(), [
            'dni' => 'required|unique:pacientes'
                
              ]);
              if($validator->fails()) {
                $request->session()->flash('error', 'El Paciente ya esta Registrado.');
               // Toastr::error('Error Registrando.', 'Paciente- DNI YA REGISTRADO!', ['progressBar' => true]);
                return redirect()->action('PacientesController@edit', ['errors' => $validator->errors()]);
              } else {

      $pacientes = Pacientes::find($request->id);
      $pacientes->nombres =$request->nombres;
      $pacientes->apellidos =$request->apellidos;
      $pacientes->dni =$request->dni;
      $pacientes->telefono =$request->telefono;
      $pacientes->email =$request->email;
      $pacientes->direccion =$request->direccion;
      $pacientes->edocivil =$request->edocivil;
      $pacientes->ocupacion =$request->ocupacion;
      $pacientes->fechanac =$request->fechanac;
      $res = $pacientes->update();
      return redirect()->action('PacientesController@index');

    }

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pacientes  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $analisis = Pacientes::find($id);
        $analisis->estatus = 0;
        $analisis->save();

        return redirect()->action('PacientesController@index');

        //
    }
}
