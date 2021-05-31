<?php

namespace App\Http\Controllers;

use App\Clientes;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $clientes = Clientes::all();
        return view('clientes.index', compact('clientes'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('clientes.create');

        //
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create1()
    {

        return view('clientes.create1');

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
        'identificacion' => 'required|unique:clientes'
            
          ]);
          if($validator->fails()) {
            $request->session()->flash('error', 'El Paciente ya esta Registrado.');
           // Toastr::error('Error Registrando.', 'Paciente- DNI YA REGISTRADO!', ['progressBar' => true]);
            return redirect()->action('ClientesController@create', ['errors' => $validator->errors()]);
          } else {

        $clientes = new Clientes();
        $clientes->nombre =$request->nombre;
        $clientes->identificacion =$request->identificacion;
        $clientes->responsable =$request->responsable;
        $clientes->email =$request->email;
        $clientes->tipoid =$request->tipoid;
        $clientes->telefono =$request->telefono;
        $clientes->save();

        return redirect()->action('ClientesController@index')
        ->with('success','Registrado Exitosamente!');


    }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store1(Request $request)
    {

        $validator = \Validator::make($request->all(), [
        'identificacion' => 'required|unique:clientes'
            
          ]);
          if($validator->fails()) {
            $request->session()->flash('error', 'El Paciente ya esta Registrado.');
           // Toastr::error('Error Registrando.', 'Paciente- DNI YA REGISTRADO!', ['progressBar' => true]);
            return redirect()->action('ClientesController@create', ['errors' => $validator->errors()]);
          } else {

        $clientes = new Clientes();
        $clientes->nombre =$request->nombre;
        $clientes->identificacion =$request->identificacion;
        $clientes->responsable =$request->responsable;
        $clientes->email =$request->email;
        $clientes->tipoid =$request->tipoid;
        $clientes->telefono =$request->telefono;
        $clientes->save();

        return redirect()->action('CheckinController@create', ["created" => true, "clientes" => Clientes::all()]);

    }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Clientes  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function show(Clientes $Clientes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Clientes  $Clientes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = Clientes::find($id);
        return view('clientes.edit', compact('cliente')); //
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

      $p = Clientes::find($request->id);
      $p->nombre =$request->nombre;
      $p->identificacion =$request->identificacion;
      $p->responsable =$request->responsable;
      $p->email =$request->email;
      $p->telefono =$request->telefono;
      $p->tipoid =$request->tipoid;
      $res = $p->update();
      return redirect()->action('ClientesController@index')
      ->with('success','Modificado Exitosamente!');
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

        $cliente = Clientes::find($id);
        $cliente->delete();

        return redirect()->action('ClientesController@index')
        ->with('success','Eliminado Exitosamente!');
        //
    }
}
