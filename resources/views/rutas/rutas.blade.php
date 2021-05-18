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

    <h5>RUTAS</h5> 
       <a type="button" class="btn btn-primary m-2" data-toggle="modal" data-target="#ModalIngreso" >Crear nueva ruta</a>
<!-- Modal ingreso nuevo-->
       <div class="modal fade" id="ModalIngreso" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="demoModalLabel">Creación de nueva Ruta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <form method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <label for="nombre">{{'NOMBRE'}}</label>
                    <input type="string" name="nombre" id="nombre" value=""><br>

                    <label for="nombre">{{'MUNICIPIO'}}</label>
                    <select name="municipio" id="municipio">
                    	@foreach($municipios as $r)
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
                    <th>RUTA</th>
                    <th>MUNICIPIO</th>
                    <th>ESTACIONES</th>
                    <th>BUSES</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rutas as $r)
                <tr height="5px">
                	<td>{{$r->nombre}}</td>
                  <td>{{$r->municipio}}</td>

                    <td>
                    @foreach($estaciones as $e)
                    @if($e->id_ruta == $r->id){{$e->nombre}}    <br>                
                    @endif 
                    @endforeach
                    </td>
                    <td>    
                    @foreach($buses as $b)
                    @if($r->id == $b->id_ruta){{$b->placa}}    <br>                
                    @endif                    
                    @endforeach
                    </td>
                </tr>
                @endforeach              
            </tbody>
    </table>
    </div>
</div>
@endsection
