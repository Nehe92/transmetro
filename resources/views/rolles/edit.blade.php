@extends('layouts.app')

@section('content')

<div>

<h2>
Editar Roll de empleado
</h5>

<form action="{{ route('rolles.update',$id) }}" method="post" enctype="multipart/form-data">
	@csrf
        @method('PUT')
	
	@foreach($roll as $mu)
	<label for="roll_empleado">ROLL</label>
	<input type="text" name="roll" id="roll" value="{{$mu->roll_empleado}}">
	@endforeach
<input type="submit" value="EDITAR">
</form>
</div>

@endsection
	



