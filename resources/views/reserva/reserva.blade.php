    <!--*************************************************************** */
    /*****************DIEGO MAURICIO MANCERA SUAREZ***************** */
    /*************************************************************** *-->


@extends('layouts.app')

@section('content')

<!--FORMULARIO DE REGISTROS DE RESERVAS-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Crear nueva reserva</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('reserva.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="sel_lab" class="col-md-4 col-form-label text-md-right">Laboratorios<span style="color: red;"> *</span></label>
                            <select name="sel_lab" id="sel_lab" class="col-md-6 form-control">
                                @foreach ($laboratorios as $laboratorio)
                                    <option value="{{$laboratorio->id}}">{{$laboratorio->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="sel_usu" class="col-md-4 col-form-label text-md-right">Usuarios<span style="color: red;"> *</span></label>
                            <select name="sel_usu" id="sel_usu" class="col-md-6 form-control">
                                @foreach ($usuarios as $usuario)
                                    <option value="{{$usuario->id}}">{{$usuario->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="fecha_hora_inicio" class="col-md-4 col-form-label text-md-right">Fecha/hora inicial<span style="color: red;"> *</span></label>
                            <input type="datetime-local" id="fecha_hora_inicio" name="fecha_hora_inicio" class="col-md-6 form-control" required>
                            @if($errors->has('fecha_hora_inicio'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('fecha_hora_inicio') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group row">
                            <label for="fecha_hora_fin" class="col-md-4 col-form-label text-md-right">Fecha/hora final<span style="color: red;"> *</span></label>
                            <input type="datetime-local" id="fecha_hora_fin" name="fecha_hora_fin" class="col-md-6 form-control" required>
                            @if($errors->has('fecha_hora_fin'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('fecha_hora_fin') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group row">
                            <label for="obs_rsv" class="col-md-4 col-form-label text-md-right">Observaciones</label>
                            <textarea id="obs_rsv" name="obs_rsv" cols="10" rows="2" class="col-md-6 form-control"></textarea>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Crear reserva
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- mostrar notificaciones -->
    @if(session("status") == 'La reserva ha sido creada')
    <script>
        Swal.fire(
            'Éxito!',
            'La reserva ha sido creada',
            'success'
        )
    </script>
    @endif
<br>
<hr>
<br>

<!--TABLA DE LISTADO DE RESERVAS-->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Lista de Reservas</div>
                    <div class="card-body">
                        <form id="rsv_upt" method="POST" action="#">
                            @csrf
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Laboratorio</th>
                                        <th>Usuario</th>
                                        <th>Fecha hora inicio</th>
                                        <th>Fecha hora fin</th>
                                        <th>Observaciones</th>
                                        <th>Edicion</th>
                                        <th>Eliminacion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reservas as $reserva)

                                    <tr>
                                        <td><select id="rsv_des_{{$reserva->id}}" name="rsv_des_{{$reserva->id}}" disabled><option value="{{$reserva->id_laboratorio}}">{{$reserva->descripcion}}</option></select></td>
                                        <td><select id="rsv_nom_{{$reserva->id}}" name="rsv_nom_{{$reserva->id}}" disabled><option value="{{$reserva->id_usuario}}">{{$reserva->nombre}}</option></select></td>
                                        <td><input type="datetime-local" id="rsv_fec_ini_{{$reserva->id}}" name="rsv_fec_ini_{{$reserva->id}}" value="{{$reserva->fecha_hora_inicio}}" disabled required></td>
                                        <td><input type="datetime-local" id="rsv_fec_fin_{{$reserva->id}}" name="rsv_fec_fin_{{$reserva->id}}" value="{{$reserva->fecha_hora_fin}}" disabled required></td>
                                        <td><textarea name="rsv_obs_{{$reserva->id}}" id="rsv_obs_{{$reserva->id}}" cols="10" rows="2" class="form-control" disabled>{{$reserva->observaciones}}</textarea></td>
                                        <td><button class="btn btn-warning" id="rsv_edt_{{$reserva->id}}">Editar</button></td>
                                        <td><button class="btn btn-danger" id="rsv_elm_{{$reserva->id}}">Eliminar</button></td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- mostrar notificaciones -->
    @if(session("status") == 'La reserva ha sido actualizada')
    <script>
        Swal.fire(
            'Éxito!',
            'La reserva ha sido actualizada',
            'success'
        )
    </script>
    @endif

    @if(session("status") == 'La reserva ha sido eliminada')
    <script>
        Swal.fire(
            'Éxito!',
            'La reserva ha sido eliminada',
            'success'
        )
    </script>
    @endif

    <div id="mod_warn" class="modal" tabindex="-1" role="dialog" style="display: none">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Advertencia</h5>
                    <button id="close" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Esta seguro de eliminar este registro</p>
                </div>
                <div class="modal-footer">
                    <button id="confirm" type="button" class="btn btn-primary">Si</button>
                    <button id="reject" type="button" class="btn btn-secondary">No</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


