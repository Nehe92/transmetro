@extends('layouts.app')

@section('content')

<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  height: 20%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #bbbbbb;
  color: white;
}
</style>
<div>
<h5>
@foreach($recorridos as $t)
<ul>
    <li><b>Ruta: </b> {{$t->nombre}}</li>
    <li><b>Placa de Bus: </b>{{$t->placa}}</li>
</ul>
</h5>

@endforeach

<h4 class='bg-warning' style='color:#fff' >
@if(Session::has('message'))
   {!! Session::get('message') !!}
@endif
</h4>
<h4 class='bg-success' style='color:#fff' >
@if(Session::has('messageSigEstacion'))
  {!! Session::get('messageSigEstacion') !!}
@endif
</h4>
<h4 class='bg-danger' style='color:#fff' >
@if(Session::has('busapoyo'))
  {!! Session::get('busapoyo') !!}
@endif
</h4>
<h4 class='bg-info' style='color:#fff' >
@if(Session::has('final'))
  {!! Session::get('final') !!}
@endif
</h4>
<div class="table">
        <table id="customers">
            <thead>
                <tr>
                    <th>RECORRIDO</th>
                    <th>ESTACION</th>
                    <th>PROXIMA ESTACION A</th>
                    <th>#PASAJEROS ARRIBA</th>
                    <th>#PASAJEROS BAJANDO</th>
                    <th>ENTRADA A ESTACIÓN</th>
                    <th>SALIDA DE ESTACIÓN</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
            
                @foreach($tiempos_recorridos as $m)
                @if($m->h_salida == '' && $m->distancia_sig_ruta > 0)
                    <form action="{{ route('recorridos.update',$m->id) }}" method="post" enctype="multipart/form-data">

                @csrf
                        @method('PUT')
                <tr>
                    <td>{{$m->id_recorrido}}</td>
                    <td>{{$m->nombre}}</td>
                    <td>{{$m->distancia_sig_ruta}} kilómetros</td>
                    <td><input type='numbre' name='pasajero_arriba' value='{{$t->cant_pasajeros}}'></td>
                    <td><input type='numbre' name='pasajero_abajo'></td>
                    <input type='number' name='id_recorrido' value='{{$id}}' style='display:none;'>
                    <input type='number' name='id_orden' value='{{$m->orden}}' style='display:none;'>
                    <input type='number' name='id_estacion' value='{{$m->id_estacion}}' style='display:none;'>
                    <input type='number' name='id_ruta' value='{{$m->id_ruta}}' style='display:none;'>
                    <td>{{$m->h_entrada}}</td>
                    <td>{{$m->h_salida}}</td>
                    <td><button type='submit'>GUARDAR</button></td>
                </tr>
                </form>
                @elseif($m->distancia_sig_ruta == 0 && $m->h_salida == '')
                <tr>
                    <td>{{$m->id_recorrido}}</td>
                    <td>{{$m->nombre}}</td>
                    <td>{{$m->distancia_sig_ruta}} kilómetros</td>
                    <td></td>
                    <td></td>
                    <td>{{$m->h_entrada}}</td>
                    <td>{{$m->h_salida}}</td>
                    <td><form method="post" action="{{ url('/recorridos/'.$m->id) }}">
                        {{csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button>FINALIZAR</button> 
                      </form></td>
                </tr>
                @elseif(($t->cant_pasajeros == 0) && ($m->distancia_sig_ruta == 0 ))
                <tr>
                    <td>{{$m->id_recorrido}}</td>
                    <td>{{$m->nombre}}</td>
                    <td>{{$m->distancia_sig_ruta}} kilómetros</td>
                    <td></td>
                    <td></td>
                    <td>{{$m->h_entrada}}</td>
                    <td>{{$m->h_salida}}</td>
                    <td></td>
                </tr>
                @else
                    <tr>
                    <td>{{$m->id_recorrido}}</td>
                    <td>{{$m->nombre}}</td>
                    <td>{{$m->distancia_sig_ruta}} kilómetros</td>
                    <td></td>
                    <td></td>
                    <td>{{$m->h_entrada}}</td>
                    <td>{{$m->h_salida}}</td>
                    <td></td>
                </tr>
                
                @endif
                
                @endforeach              
            
            </tbody>
    </table>
    </div>
</div>
@endsection


