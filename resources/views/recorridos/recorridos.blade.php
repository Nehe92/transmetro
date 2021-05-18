@extends('layouts.app')
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
    crossorigin="anonymous">
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

@section('content')

<div class="container">

    <h5>RECORRIDOS</h5> 
       <a type="button" class="btn btn-primary m-2" data-toggle="modal" data-target="#ModalIngreso" >Crear nuevo Recorrido</a>
<!-- Modal ingreso nuevo-->
       <div class="modal fade" id="ModalIngreso" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="demoModalLabel">Creación de nuevo recorrido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <form method="post" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <label for="nombre">BUS</label>
                    <select name="bus" id="bus">
                    @foreach($buses as $r)
                    	<option value="{{$r->id}}">{{$r->placa}} en Ruta {{$r->ruta}}</option>
                    @endforeach
                    </select><br>

                  	<input type="submit" value="Agregar">
                  </form>
                </div>
              </div>
            </div>
          </div>
<!-- fin de modal ingreso nuevo-->
    <div class="table">
        <table id="customers">
            <thead>
                <tr>
                    <th width="5" >RECORRIDO</th>
                    <th>RUTA</th>
                    <th>BUS</th>
                    <th>#PASAJEROS</th>
                    <th>ENTRADA A RUTA</th>
                    <th>SALIDA DE RUTA</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recorridos as $m)
                <tr>
                    <td width="5" >{{$m->id}}</td>
                    <td>{{$m->ruta}}</td>
                    <td>{{$m->bus}}</td>
                    <td>{{$m->cant_pasajeros}}</td>
                    <td>{{$m->h_entrada}}</td>
                    <td>{{$m->h_salida}}</td>
                    <td><a href="{{route('recorridos.edit',$m->id)}}">Editar</a></td>
                </tr>
                @endforeach              
            </tbody>
    </table>
    </div>
</div>
@endsection
