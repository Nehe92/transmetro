@extends('layouts.app')
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
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

    <h5>ROLLES</h5> 
    <a  type="button" class="btn btn-primary m-2" data-toggle="modal" data-target="#ModalIngreso">Crear nuevo</a>
    <!-- Modal ingreso nuevo-->
    <div class="modal fade" id="ModalIngreso" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="demoModalLabel">Creación de nuevo Roll</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <form method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <label for="nombre">Roll Empleado</label>
                    <input type="string" name="roll_empleado" id="roll_empleado" value="">
                  <input type="submit" value="AGREGAR">
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
                    <th>ROLLES</th>
                    <th>EDITAR</th>
                    <th>ELIMINAR</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rolls as $m)
                <tr>
                    <td>{{$m->roll_empleado}}</td>
                    <td width= "10%"><a href="{{route('rolles.edit',$m->id)}}">Editar</a></td>
                    <td width= "10%">
                      <form method="post" action="{{ url('/rolles/'.$m->id) }}">
                        {{csrf_field() }}
                        {{ method_field('DELETE') }}
                        <BUTTON type="submit" onclick="return confirm('¿BORRAR?');">Borrar</BUTTON>
                      </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
    </table>
    </div>
</div>
@endsection
