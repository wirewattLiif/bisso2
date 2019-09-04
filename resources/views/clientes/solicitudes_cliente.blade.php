
@extends('layouts.app')
@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/bower_components/dropify/dist/css/dropify.min.css') }}">
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
        <h2 class="col-md-12">Mis Solicitudes</h2>

        <div class="col-md-12">
            @if($solicitudes[0]->estatus_id == 1)
                <h3>¡Super!	Ya	estamos	procesando	 tu	solicitud.</h3>
                <p>Cuando estemos listos, el estatus de	esta página se actualizará automáticamente, avisándote sobre el	resultado de tu trámite.</p>
            @elseif($solicitudes[0]->estatus_id == 4)
                <h3>¡Felicidades, {{ Auth::user()->nombre }}! Tu crédito ha sido pre-autorizado.</h3>
                <p>Dale	click en "Cargar documentos" para seguir avanzando en el proceso y validar tu información.</p>
            @elseif($solicitudes[0]->estatus_id == 5)
                <h3>Estamos	revisando tus documentos.</h3>
                <p>En caso de requerir información adicional, un analista se pondrá en contacto contigo.</p>
            @elseif($solicitudes[0]->estatus_id == 2)
                <h3>¡Felicidades, {{ Auth::user()->nombre }}! Tu crédito	acaba	de	ser	autorizado.</h3>
                <p>Un	analista	se	pondrá	en	contacto	contigo. <br>
                    Por	el	momento,	descarga	el	contrato	y	fírmalo
                </p>
            @endif
        </div>


        <div class="col-md-12">
            <br><br><br>
            <table class="table">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Valor Sistema</th>
                        <th>Enganche</th>
                        <th>Préstamo Solicitado</th>
                        <th>Pago Inicial</th>
                        <th>Fecha Solicitud</th>
                        <th>Estatus</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($solicitudes as $solicitud)
                        <tr>
                            <td>{{ $solicitud->folio }}</td>
                            <td>${{ number_format($solicitud->precio_sistema,2) }}</td>
                            <td>${{ number_format($solicitud->enganche,2) }}</td>
                            <td>${{ number_format($solicitud->monto_financiar,2) }}</td>
                            <td>${{ number_format($solicitud->pago_inicial,2) }}</td>
                            <td>{{ date('d/m/Y',strtotime($solicitud->created_at)) }}</td>
                            <td>
                                <span class="label label-rouded" style="background-color:{{ $solicitud->estatus->color }}" data-toggle="tooltip" data-placement="top" title="{{ $solicitud->estatus->tooltip }}"> {{ $solicitud->estatus->nombre }}</span>
                            </td>
                            <td>


                                @if($solicitud->estatus_id == 4 || $solicitud->estatus_id == 5)
                                    <a href="/carga_documentos/{{ $solicitud->id }}" class="label label-rouded label-success" data-toggle="tooltip" data-placement="top" title="Cargar documentos">
                                        <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                    </a>
                                @elseif($solicitud->estatus_id == 2 || $solicitud->estatus_id == 1)


                                    @if($solicitud->estatus_id == 2)
                                        <a href="/carga_documentos_firmados/{{ $solicitud->id }}" class="label label-rouded label-success" data-toggle="tooltip" data-placement="top" title="Cargar documentos firmados">
                                            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                        </a>
                                    @elseif($solicitud->estatus_id == 1)
                                            <a href="#" class="label label-rouded label-success" data-target="#modal_docs_autorizacion" data-toggle="modal"  data-placement="top" title="Carga de documentos de autorización crediticia">
                                                <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                            </a>
                                    @endif
                                    <div class="btn-group m-r-10">
                                        <button aria-expanded="true" data-toggle="dropdown" style="background-color: #08C394"  class="btn btn-info dropdown-toggle waves-effect waves-light" type="button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <span class="caret"></span></button>
                                        <ul role="menu" class="dropdown-menu">


                                            @if($solicitud->estatus_id == 2)
                                                <li>
                                                    <a href="/solicitud/contrato/{{ $solicitud->id }}" title="Formato Pagare" target="_blank" style="">
                                                        Contrato
                                                    </a>
                                                </li>
                                            @endif

                                            @if($tipo_cliente == 1)
                                                @if($solicitud->estatus_id == 2)
                                                <li>
                                                    <a href="/solicitud/pagare/{{ $solicitud->id }}" title="Formato Pagare" target="_blank" style="">
                                                        Formato Pagare
                                                    </a>
                                                </li>
                                                @elseif($solicitud->estatus_id == 1)
                                                    <li>
                                                        <a href="/solicitud/autorizacion_crediticia/{{ $solicitud->id }}" title="Autorización Crediticia - Solicitante" target="_blank" style="">
                                                            Autorización Crediticia - Solicitante
                                                        </a>
                                                    </li>
                                                @endif


                                            @elseif($tipo_cliente == 2)

                                                @if($solicitud->estatus_id == 2)
                                                    <li>
                                                        <a href="/solicitud/pagare_obligado_solidario/{{ $solicitud->id }}" title="Formato Pagare - Obligado Solidario" target="_blank" style="">
                                                            Formato Pagare - Obligado Solidario
                                                        </a>
                                                    </li>
                                                @elseif($solicitud->estatus_id == 1)
                                                    <li>
                                                        <a href="/solicitud/autorizacion_crediticia/{{ $solicitud->id }}" title="Autorización Crediticia - Solicitante" target="_blank" style="">
                                                            Autorización Crediticia - Solicitante
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/solicitud/autorizacion_crediticia_obligado_solidario/{{ $solicitud->id }}" title="Autorización Crediticia - Obligado Solidario" target="_blank" style="">
                                                            Autorización Crediticia - Obligado Solidario
                                                        </a>
                                                    </li>
                                                @endif
                                            @elseif($tipo_cliente == 3)
                                                @if($solicitud->estatus_id == 2)
                                                    <li>
                                                        <a href="/solicitud/pagare/{{ $solicitud->id }}" title="Formato Pagare" target="_blank" style="">
                                                            Formato Pagare
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/solicitud/carta_propietario/{{ $solicitud->id }}" title="Carta Propietario"  target="_blank" style="">
                                                            Carta Propietario
                                                        </a>
                                                    </li>
                                                @elseif($solicitud->estatus_id == 1)
                                                    <li>
                                                        <a href="/solicitud/autorizacion_crediticia/{{ $solicitud->id }}" title="Autorización Crediticia - Solicitante"  target="_blank" style="">
                                                            Autorización Crediticia - Solicitante
                                                        </a>
                                                    </li>
                                                @endif
                                            @elseif($tipo_cliente == 4)

                                                @if($solicitud->estatus_id == 2)
                                                    <li>
                                                        <a href="/solicitud/pagare_obligado_solidario/{{ $solicitud->id }}" title="Formato Pagare - Obligado Solidario" target="_blank" style="">
                                                            Formato Pagare - Obligado Solidario
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/solicitud/carta_propietario/{{ $solicitud->id }}" title="Carta Propietario"  target="_blank" style="">
                                                            Carta Propietario
                                                        </a>
                                                    </li>
                                                @elseif($solicitud->estatus_id == 1)
                                                    <li>
                                                        <a href="/solicitud/autorizacion_crediticia/{{ $solicitud->id }}" title="Autorización Crediticia - Solicitante" target="_blank" style="">
                                                            Autorización Crediticia - Solicitante
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/solicitud/autorizacion_crediticia_obligado_solidario/{{ $solicitud->id }}" title="Autorización Crediticia - Obligado Solidario"  target="_blank" style="">
                                                            Autorización Crediticia - Obligado Solidario
                                                        </a>
                                                    </li>
                                                @endif
                                            @elseif($tipo_cliente == 5)

                                                @if($solicitud->estatus_id == 2)
                                                    <li>
                                                        <a href="/solicitud/pagare_obligado_solidario/{{ $solicitud->id }}" title="Formato Pagare - Obligado Solidario"  target="_blank" style="">
                                                            Formato Pagare - Obligado Solidario
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="/solicitud/carta_propietario/{{ $solicitud->id }}" title="Carta Propietario"  target="_blank" style="">
                                                            Carta Propietario
                                                        </a>
                                                    </li>
                                                @elseif($solicitud->estatus_id == 1)
                                                    @if(isset($solicitud->cliente->obligado_solidario) && !empty($solicitud->cliente->obligado_solidario->nombre))
                                                        <li>
                                                            <a href="/solicitud/autorizacion_crediticia_obligado_solidario/{{ $solicitud->id }}" title="Autorización Crediticia - Obligado Solidario"  target="_blank" style="">
                                                                Autorización Crediticia - Socio
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a href="/solicitud/autorizacion_crediticia_negocio/{{ $solicitud->id }}" title="Autorización Crediticia - Obligado Solidario"  target="_blank" style="">
                                                            Autorización Crediticia - Negocio
                                                        </a>
                                                    </li>
                                                @endif
                                            @endif
                                        </ul>
                                    </div>


                                @endif

                                <a href="/solicitud/pdf/{{ $solicitud->id }}" title="Detalle de solicitud" data-toggle="tooltip" class="label label-rouded label-danger" target="_blank" style="">
                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" id="modal_docs_autorizacion" aria-labelledby="" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="#" method="post">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="lbl_msj_estatus">Carga de documentos</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            @foreach($apartados as $apartado => $tipos_documentos)
                                <div class="col-md-12 drag">
                                    <h2 style="margin-top:70px;text-align: center">{{ $apartado }}</h2>
                                </div>

                                @foreach($tipos_documentos as $tipo)
                                    <div class="col-md-7 drag">
                                        <p class="titulo_tipo_documento" style="margin-top:35px !important;">
                                            <span>
                                                {{ $tipo->nombre }}
                                            </span>
                                            @if( !empty($tipo->tooltip) )
                                                <button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="top" title="{{ $tipo->tooltip }}">?</button>
                                            @endif



                                            @if(isset($files[$tipo->id]))
                                                <a href="/documentos/download/{{ $files[$tipo->id]['id'] }}" class="pull-right">Descargar</a>
                                            @else
                                                <a href="#" class="pull-right"></a>
                                            @endif
                                        </p>

                                        <input type="file"
                                               class="dropify"
                                               {{ ( isset($files[$tipo->id]) )?"data-default-file=".$files[$tipo->id]['filename']:""}}
                                               data-show-remove="false"
                                               data-max-file-size="5M"
                                                {{ (isset($files[$tipo->id]) && $files[$tipo->id]['aprobado'])?"disabled=disabled":"" }}

                                        />
                                        <input type="hidden" class="solicitud_id" value="{{ $solicitud->id }}">
                                        <input type="hidden" class="documento_id" value="{{ ( isset($files[$tipo->id]) )? $files[$tipo->id]['id'] : ""}} ">
                                        <input type="hidden" class="documento_tipo_id" value="{{ $tipo->id }} ">

                                    </div>
                                @endforeach
                            @endforeach

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop




@section('extra-js')
    <script src="{{ asset('assets/plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>
    <script>
        $(function(){
            $('.dropify').dropify({
                error:{
                    'fileSize': 'El peso del archivo no puede ser mayor a 5MB.'
                },
                tpl: {
                    errorLine:'<p class="dropify-error"></p>',
                    message:'<div class="dropify-message"><span class="file-icon" /> <p>Arrasta aquí el archivo o da click para cargarlo.</p></div>',

                }
            });


            $('.dropify').change(function(){
                var _this = $(this);
                var formData = new FormData();
                formData.append('archivo' , $(this).prop('files')[0]);


                var solicitud_id = $(this).parent().parent().find('.solicitud_id').val();
                var documento_id = $(this).parent().parent().find('.documento_id').val();
                var documento_tipo_id = $(this).parent().parent().find('.documento_tipo_id').val();
                formData.append('solicitud_id' , solicitud_id);
                formData.append('documento_id' , documento_id);
                formData.append('documento_tipo_id' , documento_tipo_id);

                $.ajax({
                    url: '{{ route('carga_documentos') }}',
                    type: 'POST',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    success: function (response) {

                        var p = _this.parent().parent().find('.titulo_tipo_documento');
                        var titulo = p.find('span').html();
                        var span = "<span>"+ titulo +"</span>";
                        var link = "<a href=\"/documentos/download/"+ response.data.id +"\" class=\"pull-right\">Descargar</a>";
                        p.html(span).append(link);

                        _this.parent().parent().find('.documento_id').val(response.data.id);

                        $.toast({
                            heading: 'Procesado',
                            text: 'Archivo cargado correctamente.',
                            position: 'top-right',
                            loaderBg:'#ff6849',
                            icon: 'success',
                            hideAfter: 9500
                        });

                        if(response.docs_completos){
                            $.toast({
                                heading: '¡Listo!',
                                text: 'Haz cargado todos los documentos que necesitabamos para seguir avanzando. En breve recibiras una llamada para continuar con el proceso.',
                                position: 'top-right',
                                loaderBg:'#ff6849',
                                icon: 'success',
                                hideAfter: false
                            });
                        }

                    },
                    error:function(){
                        alert('Error.')
                    }
                });
            })
        })
    </script>
@endsection
