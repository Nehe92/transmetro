@extends('layouts.app')

@section('content')

<div>
<h2>
Editar Empleado
</h5>

<form action="{{ route('empleados.update',$id) }}" method="post" enctype="multipart/form-data">
	@csrf
        @method('PUT')
	
	@foreach($empleado as $mu)
	<label for="Nombre">NOMBRE</label>
	<input type="text" name="nombre" id="nombre" value="{{$mu->nombre}}"><br>
	<label for="nombre">EDAD</label>
    <input type="text" name="edad" id="edad" value="{{$mu->edad}}"><br>
    <label for="nombre">PROFESION</label>
    <input type="text" name="profesion" id="profesion" value="{{$mu->profesion}}"><br>
    <label for="nombre">TELEFONO</label>
    <input type="text" name="telefono" id="telefono" value="{{$mu->telefono}}"><br>
    <label for="nombre">DIRECCION</label>
    <input type="text" name="direccion" id="direccion" value="{{$mu->direccion}}"><br>
     <label for="nombre">ROLL</label>
    <select name="roll_empleado" id="roll_empleado">
    	<option value="{{$mu->id_roll}}">{{$mu->roll_empleado}}</option>
        @foreach($rolles as $r)
        	<option value="{{$r->id}}">{{$r->roll_empleado}}</option>
		@endforeach
     </select><br>
    @endforeach

<input type="submit" value="Editar">
</form>
</div>
@endsection


