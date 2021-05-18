<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class empleadoscontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
         $empleados = DB::select('SELECT e.id, e.nombre, e.edad, e.profesion, e.telefono, e.direccion, r.roll_empleado FROM empleados e inner join rolls r on e.id_roll = r.id Order by r.roll_empleado ASC');

        $rolles = DB::select('SELECT * FROM rolls where roll_empleado!="administrador"');
        return view('empleados.empleados',compact('empleados','rolles')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('empleados.create');
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datosempleado=request()->except('_token');

        DB::table('empleados')->insert([
            'nombre' => $request->nombre,
            'edad'=> $request->edad,
            'profesion'=> $request->profesion,
            'telefono'=> $request->telefono,
            'direccion'=> $request->direccion,
            'id_roll'=> $request->roll_empleado
        ]);     
        return redirect('empleados');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $empleado = DB::select('SELECT e.id, e.nombre, e.edad, e.profesion, e.telefono, e.direccion, r.roll_empleado, r.id as id_roll
        FROM empleados e inner join rolls r on e.id_roll = r.id 
        where e.id=:id
        Order by r.roll_empleado ASC',['id'=>$id]);
       foreach($empleado as $e)
       {
        $oldrol = $e->id_roll;
       }

        $rolles = DB::select('SELECT * FROM rolls where roll_empleado!="administrador" and 
            id != :oldrol',['oldrol'=>$oldrol]);

        return view('empleados.edit',compact('empleado','id','rolles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $empleado = DB::table('empleados')->where('id',$id)
        ->update([
            'nombre' => $request->nombre,
            'edad'=> $request->edad,
            'profesion'=> $request->profesion,
            'telefono'=> $request->telefono,
            'direccion'=> $request->direccion,
            'id_roll'=> $request->roll_empleado
        ]);
        return redirect('empleados');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('empleados')->delete($id);
        return redirect('empleados');
    }
}
