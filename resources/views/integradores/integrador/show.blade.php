@extends('layouts.app')
@section('extra-css')
    <link href="{{ asset('assets/plugins/bower_components/bootstrap-switch/bootstrap-switch.min.css') }}" rel="stylesheet">
@stop


@section('breadcrumb')
<div class="row bg-title">
        <div class="col-md-9">
            <a href="/admin/solicitudes" class="btn btn-default2 btn-rounded">Mis datos</a>            
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
                                <a href="#"  data-asignado="true">
                                    <div class="ribbon-wrapper">
                                        <div class="ribbon ribbon-pencil ribbon-success">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        </div>
                                        <p class="ribbon-content">{{ $v->nombre }}</p>
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

@endsection