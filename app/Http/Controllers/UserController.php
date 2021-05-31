<?php

namespace App\Http\Controllers;

use App\Clientes;
use App\Roles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = DB::table('users as a')
        ->select('a.id','a.name','a.email','a.password','a.rol','b.nombre as rol')
        ->join('roles as b','b.id','a.rol')
        ->where('a.rol', '<>', NULL)
        ->where('a.password', '<>', NULL)
        ->get(); 

        $roles = Roles::all();
        $clientes = Clientes::all();

        return view('users.index', compact('users', 'roles' ,'clientes'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles = Roles::all();
        $clientes = Clientes::all();

        return view('users.create' , compact( 'roles' ,'clientes'));

        //
    }

    public function sesion()
    {

        $roles = Roles::all();


    
        return view('users.sesion', compact('roles'));

        //
    }

    public function otros()
    {

    
        return view('users.otros');

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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
          ]);
          if($validator->fails()) 
            return redirect()->action('UserController@create', ['errors' => $validator->errors()]);
            $user = new User();
            $user->name =$request->name;
            $user->email =$request->email;
            $user->rol =$request->rol;
            $user->password =Hash::make($request['password']);
            $user->save();


        return redirect()->action('UserController@index', ["created" => true, "user" => User::all()]);

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
        $user = User::find($id);
        $roles = Roles::all();
        $clientes = Clientes::all();
        return view('users.edit', compact('user','roles','clientes')); //
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
          

            $p = User::find($request->id);
            $p->name =$request->name;
            $p->email =$request->email;
            $p->rol =$request->rol;
            $p->empresa =$request->empresa;
            $p->password =Hash::make($request['password']);
            $res = $p->update();
      return redirect()->action('UserController@index');

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

        $cliente = User::find($id);
        $cliente->delete();

        return redirect()->action('UserController@index');

        //
    }


    public function updatepasswd()
    {
        $id= Auth::user()->id;
        $usuario = User::where('id', '=', $id)->first();
        return view('users.updatepasswd', compact('usuario'));
    }

    public static function updatepass(Request $request){
    

        $id= Auth::user()->id;
        $usuario = User::where('id', '=', $id)->get()[0];
        $usuario->password = \Hash::make($request->password);
        $usuario = $usuario->update();


         return redirect()->route('home');

     


    }




}