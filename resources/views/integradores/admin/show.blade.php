@extends('layouts.app')
@section('extra-css')
    <link href="{{ asset('assets/plugins/bower_components/bootstrap-switch/bootstrap-switch.min.css') }}" rel="stylesheet">
@stop


@section('breadcrumb')
<div class="row bg-title">
        <div class="col-md-9">
            <a href="/admin/solicitudes" class="btn btn-default2 btn-rounded">Integradores</a>
            <h4 class="page-title d-inline">Detalle del integrador</h4>
        </div>

        
    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-md-10">
            <h2 class="d-inline">
                Datos de la cuenta
            </h2>
            <br>
        </div>
        <div class="col-md-2">
                <a href="{{ route('integradores.edit',$integrador->id) }}"
                        class="btn btn-rounded btn-outline btn-success waves-effect waves-light"
                    >
                        Editar
                    </a>
            @if (!$integrador->activo)
                <a href="#"
                    
                    data-id="{{ $integrador->id }}"
                    data-url="{{ route("admin.integradores.activar",$integrador->id ) }}"
                    class="btn btn-rounded btn-outline btn-success waves-effect waves-light button-destroy"
                    data-original-title="Autorizar"
                    data-method="delete"
                    data-trans-button-cancel="Cancelar"
                    data-trans-button-confirm="Autorizar"
                    data-trans-title="¿Está seguro de esta operación?"
                    data-trans-subtitle="Esta operación activara al integrador seleccionado"
                    data-confirmButtonColor="#08C394">
                        Activar
                </a>
                
            @endif
        </div>
        
        <div class="col-md-3">
            <h5>Nombre del usuario</h5>
            <p>{{ $integrador->user->nombre }}</p>
        </div>
        <div class="col-md-3">
            <h5>Email</h5>
            <p>{{ $integrador->user->email }}</p>
        </div>
        <div class="col-md-3">
            <h5>Celular</h5>
            <p>{{ $integrador->user->phone }}</p>
        </div>
        
    </div>

    <br>

    <div class="row">
        <div class="col-md-12">
            <h2 class="d-inline">
                Información de la empresa
            </h2>
            <br>
        </div>
        
        <div class="col-md-3">
            <h5>Razón social</h5>
            <p>{{ $integrador->razon_social }}</p>
        </div>
        <div class="col-md-3">
            <h5>Nombre comercial</h5>
            <p>{{ $integrador->nombre_comercial }}</p>
        </div>
        <div class="col-md-3">
            <h5>RFC</h5>
            <p>{{ $integrador->rfc }}</p>
        </div>
        <div class="col-md-3">
            <h5>Años operando</h5>
            <p>{{ $integrador->anios_operando }}</p>
        </div>
        <div class="col-md-3">
            <h5>Ventas Anuales</h5>
            <p>{{ $integrador->ventas_anuales }}</p>
        </div>
        <div class="col-md-3">
            <h5>¿Cuál es tu producto principal?</h5>
            <p>{{ $integrador->producto_principal }}</p>
        </div>
    </div>
 
    <br>

    <div class="row">
        <div class="col-md-12">
            <h2 class="d-inline">
                Dirección
            </h2>
            <br>
        </div>

        <div class="col-md-3">
            <h5>Calle</h5>
            <p>{{ $integrador->domicilio->calle }}</p>
        </div>
        <div class="col-md-3">
            <h5>Número exterior</h5>
            <p>{{ $integrador->domicilio->numero_ext }}</p>
        </div>
        <div class="col-md-3">
            <h5>Número interior (opcional)</h5>
            <p>{{ $integrador->domicilio->numero_int }}</p>
        </div>
        <div class="col-md-3">
            <h5>Colonia</h5>
            <p>{{ $integrador->domicilio->colonia }}</p>
        </div>
        <div class="col-md-3">
            <h5>Estado</h5>
            <p>{{ $integrador->domicilio->estado->nombre }}</p>
        </div>
        <div class="col-md-3">
            <h5>Municipio / Delegación</h5>
            <p>{{ $integrador->domicilio->municipio->nombre }}</p>
        </div>
        <div class="col-md-3">
            <h5>Código Postal</h5>
            <p>{{ $integrador->domicilio->cp }}</p>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-12">
            <h2 class="d-inline">
                Información del socio
            </h2>
            <br>
        </div>

        <div class="col-md-3">
            <h5>Nombre</h5>
            <p>{{ $integrador->nombre_socio }}</p>
        </div>
        <div class="col-md-3">
            <h5>Apellido paterno</h5>
            <p>{{ $integrador->apellido_paterno_socio }}</p>
        </div>
        <div class="col-md-3">
            <h5>Apellido materno</h5>
            <p>{{ $integrador->apellido_materno_socio }}</p>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-12">
            <h2 class="d-inline">
                Dirección del socio
            </h2>
            <br>
        </div>

        <div class="col-md-3">
            <h5>Calle</h5>
            <p>{{ $integrador->domicilio_socio->calle }}</p>
        </div>
        <div class="col-md-3">
            <h5>Número exterior</h5>
            <p>{{ $integrador->domicilio_socio->numero_ext }}</p>
        </div>
        <div class="col-md-3">
            <h5>Número interior (opcional)</h5>
            <p>{{ $integrador->domicilio_socio->numero_int }}</p>
        </div>
        <div class="col-md-3">
            <h5>Colonia</h5>
            <p>{{ $integrador->domicilio_socio->colonia }}</p>
        </div>
        <div class="col-md-3">
            <h5>Estado</h5>
            <p>{{ $integrador->domicilio_socio->estado->nombre }}</p>
        </div>
        <div class="col-md-3">
            <h5>Municipio / Delegación</h5>
            <p>{{ $integrador->domicilio_socio->municipio->nombre }}</p>
        </div>
        <div class="col-md-3">
            <h5>Código Postal</h5>
            <p>{{ $integrador->domicilio_socio->cp }}</p>
        </div>
    </div>

    

    <div class="row">
        <div class="col-md-12">
            <br>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="nav-item" aria-expanded="false">
                    <a href="#productos" class="nav-link active" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true">
                        Productos
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="productos" aria-expanded="false">
                    <div class="row">
                        @foreach ($productos as $k => $v)
                            <div class="col-md-3">
                                <a href="#" class="cardProduct" data-asignado="{{ (in_array($k,$prods_integrador))?"true":"false" }}" data-producto_id="{{ $k }}">
                                    <div class="ribbon-wrapper">
                                        <div class="ribbon ribbon-pencil ribbon-{{ (in_array($k,$prods_integrador))?"success":"danger" }}  ">
                                            <i class="fa fa-{{ (in_array($k,$prods_integrador))?"check":"times" }}" aria-hidden="true"></i>
                                        </div>
                                        <p class="ribbon-content">{{ $v }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>            
        
    </div>
@endsection


@section('extra-js')
<script>
    $(function(){
        $('.cardProduct').click(function(e){
            e.preventDefault();
            var _token = $('meta[name="csrf-token"]').attr('content');
            var asignado = $(this).data('asignado')
            var producto_id = $(this).data('producto_id')
            var integrador_id = {{ $integrador->id }};

            var texto = "¿Seguro de asignar este producto al integrador?";
            if(asignado){
                texto = "¿Seguro de retirar este producto al integrador?";
            }

            swal({
                title: "Aviso",
                text: texto,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#01C292",
                confirmButtonText:  "Aceptar",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false
            },
            function(){
                var form =
                $('<form>', {
                    'method': 'POST',
                    'action': "{{ route("admin.integradores.set_productos") }}"
                });

                var token =
                $('<input>', {
                    'name': '_token',
                    'type': 'hidden',
                    'value': _token
                });

                var hiddenInput =
                $('<input>', {
                    'name': '_method',
                    'type': 'hidden',
                    'value': 'POST'
                });

                var hiddenProduct =
                $('<input>', {
                    'name': 'product_id',
                    'type': 'hidden',
                    'value': producto_id
                });

                var hiddenIntegrador =
                $('<input>', {
                    'name': 'integrador_id',
                    'type': 'hidden',
                    'value': integrador_id
                });

                form.append(token, hiddenInput, hiddenProduct,hiddenIntegrador).appendTo('body').submit();
            });
        })
    })
</script>
@endsection