@extends('layouts.app')

@section('content')

<div>

<h2>
Editar Municipio
</h5>

<form action="{{ route('municipios.update',$id) }}" method="post" enctype="multipart/form-data">
	@csrf
        @method('PUT')
	
	@foreach($municipio as $mu)
	<label for="Nombre">NOMBRE</label>
	<input type="text" name="nombre" id="nombre" value="{{$mu->nombre}}">
	@endforeach
<input type="submit" value="EDITAR">
</form>
</div>

@endsection





