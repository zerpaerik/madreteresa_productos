<?php

namespace App\Http\Controllers;

use App\Roles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $personal = User::where('estatus','=',1)->where('tipo','=',1)->get();
        return view('personal.index', compact('personal'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('personal.create');

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

        $validator = \Validator::make($request->all(), [
            'dni' => 'required|unique:users',
            'email' => 'required|unique:users'
                
              ]);
              if($validator->fails()) {
                $request->session()->flash('error', 'El Personal ya está REGISTRADO - DNI y EMAIL deben ser únicos.');
                return redirect()->action('PersonalController@create', ['errors' => $validator->errors()]);
              } else {
        $personal = new User();
        $personal->name =$request->nombres;
        $personal->lastname =$request->apellidos;
        $personal->dni =$request->dni;
        $personal->email =$request->email;
        $personal->telefono =$request->telefono;
        $personal->direccion =$request->direccion;
        $personal->cargo =$request->cargo;
        $personal->tipo_personal =$request->tipo;
        $personal->rol =$request->rol;
        $personal->password =Hash::make($request['password']);
        $personal->tipo =1;
        $personal->save();

        return redirect()->action('PersonalController@index', ["created" => true, "personal" => User::all()]);
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
        $personal = User::find($id);
        return view('personal.edit', compact('personal')); //
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
      $personal->dni =$request->dni;
      $personal->email =$request->email;
      $personal->telefono =$request->telefono;
      $personal->direccion =$request->direccion;
      $personal->cargo =$request->cargo;
      $personal->tipo_personal =$request->tipo;
      $res = $personal->update();

    
      return redirect()->action('PersonalController@index');

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

        return redirect()->action('PersonalController@index');

        //
    }
}
