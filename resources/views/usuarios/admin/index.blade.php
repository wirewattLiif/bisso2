@extends('layouts.app')
@section('breadcrumb')
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <br>
        </div>
    </div>
@stop

@section('content')

    <form method="get" action="/admin/usuarios" class="row">
        <h2 class="col-md-12">Usuarios</h2><br><br>

        <div class="col-md-3">
            <label for="">Nombre</label>
            {{ Form::text('nombre_filtro',null,['class'=>'form-control','id'=>'cliente'] ) }}
        </div>

        <div class="col-md-3">
            <label for="">Email</label>
            {{ Form::text('email_filtro',null,['class'=>'form-control','id'=>'cliente'] ) }}
        </div>

        <div class="col-md-3">
            <label for="">Grupo</label>
            {{ Form::select('grupo_id_filtro',$grupos,null,['class'=>'form-control'] ) }}
        </div>

        <div class="col-md-1">
            <button type="submit" class="btn btn-success" style="margin-top: 22px;">Buscar</button>
        </div>

        <div class="col-md-1">
            <button type="button" id="btnAdd" class="btn btn-success btn-outline" data-target="#addUsuario" data-toggle="modal" style="margin-top: 22px;">(+) Agregar</button>
        </div>
    </form>


    <div class="row">
        <div class="col-md-12">
            <br>
            <table class="table">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Perfil</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->nombre }}</td>
                        <td>{{ $usuario->email}}</td>
                        <td>{{ $usuario->grupo->nombre }}</td>
                        <td>
                            <span class="label label-rouded" style="background-color:#08C394">
                                 <a href="#"
                                    class="button-show-hover btnEdit label label-rouded"
                                    data-toggle="modal"
                                    data-target="#modalEditUsuario"
                                    data-id="{{ $usuario->id }}"
                                    data-nombre="{{ $usuario->nombre }}"
                                    data-email="{{ $usuario->email }}"
                                    data-grupo_id="{{ $usuario->grupo_id }}"
                                    style="font-size:12px"
                                 >
                                    <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" data-original-title="" title=""></i>
                                </a>
                            </span>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $usuarios->links() }}

    <div class="modal fade none-border" id="addUsuario">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Agregar Usuario</h4>
                </div>
                {!! Form::open(['method' => 'POST','url'=>'/admin/usuarios']) !!}
                <div class="modal-body">
                    <div class="row">
                        @csrf
                        <div class="col-md-6">
                            <label for="">Nombre</label>
                            {{ Form::text('nombre',null,['class'=>'form-control','id'=>'cliente','required'=>false] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Email</label>
                            {{ Form::text('email',null,['class'=>'form-control','id'=>'cliente','type'=>'email','required'=>false] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Grupo</label>
                            {{ Form::select('grupo_id',$grupos_add,null,['class'=>'form-control'] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Password</label>
                            {{ Form::password('password',['class'=>'form-control','id'=>'cliente','required'=>false] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Confirmación de Password</label>
                            {{ Form::password('password_confirmation',['class'=>'form-control','id'=>'cliente','required'=>false] ) }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light save-category" >Agregar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="modal fade none-border" id="modalEditUsuario">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Editar Usuario</h4>
                </div>
                {!! Form::open(['method' => 'POST','url'=>'/admin/usuarios/edit']) !!}
                <div class="modal-body">
                    <div class="row">
                        @csrf
                        <div class="col-md-6">
                            <label for="">Nombre</label>
                            <input type="hidden" name="id" id="usuario_id">
                            {{ Form::text('nombre',null,['class'=>'form-control','id'=>'ed_nombre','required'=>false] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Email</label>
                            {{ Form::text('email',null,['class'=>'form-control','id'=>'ed_email','type'=>'email','required'=>false] ) }}
                        </div>

                        <div class="col-md-6">
                            <label for="">Grupo</label>
                            {{ Form::select('grupo_id',$grupos_add,null,['class'=>'form-control','id'=>'ed_grupo_id'] ) }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light save-category" >Editar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


@endsection


@section('extra-js')
<script>
    $(function(){
        $('.btnEdit').click(function(){
            var id = $(this).data('id');
            var nombre = $(this).data('nombre');
            var email = $(this).data('email');
            var grupo_id = $(this).data('grupo_id');

            $('#usuario_id').val(id);
            $('#ed_nombre').val(nombre);
            $('#ed_email').val(email);
            $('#ed_grupo_id').val(grupo_id);
        })
    })
</script>
@endsection