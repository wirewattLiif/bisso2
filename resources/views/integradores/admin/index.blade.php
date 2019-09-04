@extends('layouts.app')
@section('extra-css')
    <link href="{{ asset('assets/plugins/bower_components/bootstrap-switch/bootstrap-switch.min.css') }}" rel="stylesheet">
@stop


@section('breadcrumb')
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <br>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <h2 class="col-md-12">Integradores</h2>
    </div>

    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('integradores.create') }}"  class="btn btn-success btn-outline pull-right"   style="margin-top: 22px;margin-bottom: 10px;">
                    (+) Agregar
            </a>
            {{-- <button type="button" id="btnAdd" class="btn btn-success btn-outline pull-right" data-target="#addProducto" data-toggle="modal"  style="margin-top: 22px;margin-bottom: 10px;">(+) Agregar</button> --}}
        </div>
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre comercial</th>
                        <th>Razón social</th>
                        <th>RFC</th>
                        <th>Usuario</th>
                        <th>Mail</th>
                        <th>Activo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($integradores as $integrador)
                        <tr data-show="/admin/integradores/{{ $integrador->id }}">
                            <td>{{ $integrador->id }}</td>
                            <td>{{ $integrador->nombre_comercial }}</td>
                            <td>{{ $integrador->razon_social }}</td>
                            <td>{{ $integrador->rfc }}</td>
                            <td>{{ @$integrador->user->nombre }}</td>
                            <td>{{ @$integrador->user->email }}</td>
                            <td>
                                <label for="" class="label label-rouded label-{{ ($integrador->activo)?'success':'danger' }}">{{ ($integrador->activo)?'Si':'No' }}</label>
                            </td>
                            <td class="actions">
                                
                                <a href="{{ route('integradores.edit',$integrador->id) }}"
                                    class="button-show-hover btnEdit label label-rouded"
                                    style="background-color:#08C394"
                                >
                                    <i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" data-original-title="" title=""></i>
                                </a>

                                @if (!$integrador->activo)
                                <a href="#"
                                    style="background-color:#08C394"
                                    data-id="{{ $integrador->id }}"
                                    data-url="{{ route("admin.integradores.activar",$integrador->id ) }}"
                                    class="button-destroy button-show-hover label label-rouded"
                                    data-original-title="Autorizar"
                                    data-method="delete"
                                    data-trans-button-cancel="Cancelar"
                                    data-trans-button-confirm="Autorizar"
                                    data-trans-title="¿Está seguro de esta operación?"
                                    data-trans-subtitle="Esta operación activara al integrador seleccionado"
                                    data-confirmButtonColor="#08C394">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                </a>
                                    
                                @endif

                                

                            </td>
                        </tr>    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


@section('extra-js')
<script src="{{ asset('assets/plugins/bower_components/bootstrap-switch/bootstrap-switch.min.js') }}"></script> 

<script>
    $(function(){
        bindClickTabla();
    })

    function bindClickTabla(){
        $('tbody td').bind('click',function(e){
            if (!$(this).hasClass('actions')) {
                window.location.href = $(this).parent().data('show');
            }
        })
    }
</script>
@endsection