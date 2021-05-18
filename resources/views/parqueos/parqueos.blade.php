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

    <h5>PARQUEOS</h5> 
       <a type="button" class="btn btn-primary m-2" data-toggle="modal" data-target="#ModalIngreso" >Crear Nuevo</a>
<!-- Modal ingreso nuevo-->
       <div class="modal fade" id="ModalIngreso" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="demoModalLabel">Creación de nuevo Parqueo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <form method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <label for="nombre">{{'NOMBRE'}}</label>
                    <input type="string" name="nombre" id="nombre" value=""><br>
                    <label for="nombre">{{'EDAD'}}</label>
                    <input type="string" name="edad" id="edad" value=""><br>
                    <label for="nombre">{{'PROFESION'}}</label>
                    <input type="string" name="profesion" id="profesion" value=""><br>
                    <label for="nombre">{{'TELEFONO'}}</label>
                    <input type="string" name="telefono" id="telefono" value=""><br>
                    <label for="nombre">{{'DIRECCION'}}</label>
                    <input type="string" name="direccion" id="direccion" value=""><br>
                    <label for="nombre">{{'ROLL'}}</label>
                    <select name="estacion" id="estacion">
                    	@foreach($estaciones as $r)
                    	<option value="{{$r->id}}">{{$r->nombre}}</option>
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
                    <th>NOMBRE</th>
                    <th>ESTACION</th>
                    <th>EDITAR</th>
                    <th>ELIMINAR</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parqueos as $m)
                <tr>
                	<td>{{$m->nombre}}</td>
                     <td>{{$m->estacion}}</td>

                    <td width= "10%">
                    	<a  href="{{route('parqueos.edit',$m->id)}}">Editar</a>
                    </td>
                    <td width= "10%">
                      <form method="post" action="{{ url('/parqueos/'.$m->id) }}">
                        {{csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button  onclick="return confirm('¿BORRAR?');">Borrar</button> 
                      </form>
                    </td>
                </tr>
                @endforeach              
            </tbody>
    </table>
    </div>
</div>
@endsection
