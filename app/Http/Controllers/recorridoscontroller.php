<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
class recorridoscontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recorridos = DB::select('SELECT e.id, e.cant_pasajeros, e.h_salida, e.h_entrada, b.placa as bus , r.nombre as ruta  
        FROM detalle_recorridos e 
        inner join rutas r on e.id_ruta = r.id
        inner join buses b on e.id_bus = b.id;');
        
        $rutas = DB::select('SELECT * FROM rutas');
        $buses = DB::select('SELECT b.id, b.placa, r.nombre as ruta, r.id as rutaid FROM buses b inner join rutas r on r.id = b.id_ruta;');
        return view('recorridos.recorridos',compact('recorridos','rutas','buses')) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('recorridos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datosrecorrido=request()->except('_token');
        $buses = DB::select('SELECT b.id, b.id_ruta FROM buses b where b.id = :id',['id'=>$request->bus]);
        foreach($buses as $b)
        {
            DB::table('detalle_recorridos')->insert([
                'id_bus'=>$b->id,
               'id_ruta'=>$b->id_ruta]); 
        }
        return redirect('recorridos');
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recorridos=DB::SELECT('SELECT  b.placa, r.nombre, d.cant_pasajeros as cant_pasajeros FROM detalle_recorridos d
        inner join buses b on d.id_bus = b.id
        inner join rutas r on d.id_ruta = r.id
        where d.id = :id', ['id'=>$id]);
        $tiempos_recorridos=DB::SELECT('SELECT t.id, t.id_recorrido, t.id_estacion, t.h_entrada, t.h_salida, d.orden,  
        d.distancia_sig_ruta, e.nombre, e.cant_usuarios, d.id_ruta
        FROM tiempos_recorridos t 
        inner join detalle_rutas d on t.id_estacion = d.id_estacion 
        inner join estaciones e on d.id_estacion = e.id
        where t.id_recorrido = :id', ['id'=>$id]);

        return view('recorridos.edit',compact('recorridos','tiempos_recorridos','id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $recorridos=DB::SELECT('SELECT * FROM detalle_recorridos where id = :id', ['id'=>$id]);  
        
        foreach($recorridos as $r){
            $pasajeros = $r->cant_pasajeros;
            $ruta = $r->id_ruta;
        }
        if($pasajeros === null){
            $detalle_rutas=DB::SELECT('SELECT * FROM detalle_rutas where id_ruta = :id order by orden ASC limit 1;', ['id'=>$ruta]);
            foreach($detalle_rutas as $dr){
                $estacion= $dr->id_estacion;
            }
            
            DB::table('detalle_recorridos')->where('id',$id)->update(['cant_pasajeros'=>0,'h_entrada'=>Carbon::now()]);

            DB::table('tiempos_recorridos')->insert([
                'h_entrada'=>Carbon::now(),
                'id_recorrido'=>$id,
                'id_estacion'=>$estacion
                
            ]);
           

        }
        else if ($pasajeros == 0){
             

        }
        return redirect()->route('recorridos.show',$id);
        
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
        $tiempos_recorridos=DB::SELECT('SELECT * FROM tiempos_recorridos where id_recorrido = :id', ['id'=>$id]);
        $ruta=DB::SELECT('SELECT * FROM detalle_recorridos where id = :idr', ['idr'=>$request->id_recorrido]);
        foreach($ruta as $r){
            $bus = $r->id_bus;
            $pasajeros = $r->cant_pasajeros;
            $id_ruta = $r->id_ruta;
        }
        $buses=DB::SELECT('SELECT * FROM buses where id = :idb',['idb'=>$bus]);
        
       
        foreach($buses as $b){
            $capacidad = $b->capacidad;
        }
        if(($request->pasajero_arriba+$pasajeros-$request->pasajero_abajo) < ($capacidad*0.25)){
            if(($request->pasajero_arriba+$pasajeros-$request->pasajero_abajo)<0){
                DB::TABLE('detalle_recorridos')->where('id',$request->id_recorrido)->update(['cant_pasajeros'=>0]);
            }
            else{DB::TABLE('detalle_recorridos')->where('id',$request->id_recorrido)->update(['cant_pasajeros'=>($request->pasajero_arriba-$request->pasajero_abajo+$pasajeros)]);
            \Session::flash('message', 'LA CANTIDAD DE PASAJEROS NO SUPERA EL 25% DE OCUPACION EN EL BUS');
            }
            return back();
        }
        else if(($request->pasajero_arriba+$pasajeros-$request->pasajero_abajo) >= ($capacidad*0.25)&&($request->pasajero_arriba+$pasajeros-$request->pasajero_abajo) < ($capacidad*0.5)){
            DB::TABLE('detalle_recorridos')->where('id',$request->id_recorrido)->update(['cant_pasajeros'=>($request->pasajero_arriba-$request->pasajero_abajo+$pasajeros)]);
            DB::TABLE('tiempos_recorridos')->where('id',$id)->update(['h_salida'=>Carbon::now()]);

            $detalle_rutas=DB::SELECT('SELECT * FROM detalle_rutas where id_ruta = :id AND id_estacion != :esta AND orden > :mayor
            order by orden ASC limit 1;', ['id'=>$request->id_ruta, 'esta'=>$request->id_estacion, 'mayor'=>$request->id_orden]);
            foreach($detalle_rutas as $dr){
                $estacion= $dr->id_estacion;
            }
            
            DB::table('tiempos_recorridos')->insert([
                'h_entrada'=>Carbon::now(),
                'id_recorrido'=>$request->id_recorrido,
                'id_estacion'=>$estacion
                
            ]);
            \Session::flash('messageSigEstacion', 'PUEDE CONTINUAR A SIGUIENTE ESTACIÓN');
            return back();
        }
        else if(($request->pasajero_arriba+$pasajeros-$request->pasajero_abajo) >= ($capacidad*0.5)){
            DB::TABLE('detalle_recorridos')->where('id',$request->id_recorrido)->update(['cant_pasajeros'=>($request->pasajero_arriba-$request->pasajero_abajo+$pasajeros)]);
            DB::TABLE('tiempos_recorridos')->where('id',$id)->update(['h_salida'=>Carbon::now()]);

            $detalle_rutas=DB::SELECT('SELECT * FROM detalle_rutas where id_ruta = :id AND id_estacion != :esta AND orden > :mayor
            order by orden ASC limit 1;', ['id'=>$request->id_ruta, 'esta'=>$request->id_estacion, 'mayor'=>$request->id_orden]);
            foreach($detalle_rutas as $dr){
                $estacion= $dr->id_estacion;
            }
            
            DB::table('tiempos_recorridos')->insert([
                'h_entrada'=>Carbon::now(),
                'id_recorrido'=>$request->id_recorrido,
                'id_estacion'=>$estacion
                
            ]);
            \Session::flash('messageSigEstacion', 'PUEDE CONTINUAR A SIGUIENTE ESTACIÓN');
            \Session::flash('busapoyo', 'NECESARIO BUS DE APOYO');
            return back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tiempos_recorridos=DB::SELECT('SELECT * FROM tiempos_recorridos where id = :id', ['id'=>$id]);
       
        foreach($tiempos_recorridos as $t){
            $id_recorrido = $t->id_recorrido;

        }

        DB::TABLE('detalle_recorridos')->where('id',$id_recorrido)->update(['cant_pasajeros'=>0,'h_salida'=>Carbon::now()]);
        DB::TABLE('tiempos_recorridos')->where('id',$id)->update(['h_salida'=>Carbon::now()]);
        \Session::flash('final', 'FIN DEL RECORRIDO');
        return back();
    }
}
