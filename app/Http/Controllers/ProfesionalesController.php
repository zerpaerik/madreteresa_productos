<?php

namespace App\Http\Controllers;

use App\Roles;
use App\User;
use App\Especialidades;
use App\Centros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;


class ProfesionalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $prof = User::where('estatus','=',1)->where('tipo','=',2)->get();

        $prof = DB::table('users as a')
        ->select('a.id','a.name','a.lastname','a.telefono','a.especialidad','a.estatus','a.tipo','a.centro','a.email','b.nombre as especialidad','c.nombre as centro')
        ->join('especialidades as b','b.id','a.especialidad')
        ->join('centros as c','c.id','a.centro')
        ->where('a.estatus','=',1)
        ->where('a.tipo','=',2)
        ->distinct('a.id')
        ->get(); 
        return view('profesionales.index', compact('prof'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $especialidades = Especialidades::all();
        $centros = Centros::where('estatus','=',1)->get();

        return view('profesionales.create', compact('especialidades','centros'));
    
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
            'cmp' => 'required|unique:users',
            'email' => 'required|unique:users'
                
              ]);
              if($validator->fails()) {
                $request->session()->flash('error', 'El Profesional ya está REGISTRADO - DNI y EMAIL deben ser únicos.');
                return redirect()->action('ProfesionalesController@create', ['errors' => $validator->errors()]);
              } else {
        $personal = new User();
        $personal->name =$request->nombres;
        $personal->lastname =$request->apellidos;
        $personal->cmp =$request->cmp;
        $personal->email =$request->email;
        $personal->telefono =$request->telefono;
        $personal->centro =$request->centro;
        $personal->cuenta =$request->cuenta;
        $personal->especialidad =$request->especialidad;
        $personal->nacimiento =$request->nacimiento;
        $personal->rol =$request->rol;
        $personal->password =Hash::make($request['password']);
        $personal->tipo =2;
        $personal->save();

        return redirect()->action('ProfesionalesController@index', ["created" => true, "personal" => User::all()]);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function show(Roles $roles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $prof = DB::table('users as a')
        ->select('a.id','a.name','a.lastname','a.telefono','a.cmp','a.nacimiento','a.cargo','a.cuenta','a.especialidad','a.estatus','a.tipo','a.centro','a.email','b.nombre as nomesp','c.nombre as nomcen')
        ->join('especialidades as b','b.id','a.especialidad')
        ->join('centros as c','c.id','a.centro')
        ->where('a.estatus','=',1)
        ->where('a.tipo','=',2)
        ->where('a.id','=',$id)
        ->first(); 
        $especialidades = Especialidades::all();
        $centros = Centros::where('estatus','=',1)->get();
        return view('profesionales.edit', compact('prof','especialidades','centros')); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $personal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $personal)
    {


    
      $personal = User::find($request->id);
      $personal->name =$request->nombres;
      $personal->lastname =$request->apellidos;
      $personal->cmp =$request->cmp;
      $personal->email =$request->email;
      $personal->telefono =$request->telefono;
      $personal->centro =$request->centro;
      $personal->cuenta =$request->cuenta;
      $personal->especialidad =$request->especialidad;
      $personal->nacimiento =$request->nacimiento;
      $res = $personal->update();

    
      return redirect()->action('ProfesionalesController@index');

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $personal = User::find($id);
        $personal->estatus = 0;
        $personal->save();

        return redirect()->action('ProfesionalesController@index');

        //
    }
}
