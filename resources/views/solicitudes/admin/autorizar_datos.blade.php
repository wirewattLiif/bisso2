@extends('layouts.app')

@section('extra-css')
    <link href="{{ asset('assets/plugins/bower_components/bootstrap-switch/bootstrap-switch.min.css') }}" rel="stylesheet">
@stop

@section('breadcrumb')
    <div class="row bg-title">
        <div class="col-md-12">
            <a href="/admin/solicitudes/{{ $solicitud->id }}" class="btn btn-default2 btn-rounded">Detalle solicitud</a>
            <h4 class="page-title" style="display:inline-block">Autorización de Documentos</h4>
        </div>
    </div>
@stop


@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2 class="d-inline">
                {{ $solicitud->cliente->nombre . ' ' . $solicitud->cliente->apellido_paterno . ' ' . $solicitud->cliente->apellido_materno}}
            </h2>
            <label class="label label-default label-rouded">Persona {{ $solicitud->cliente->persona_tipo }}</label>
        </div>

        @foreach($apartados as $apartado => $tipos_documentos)
            <div class="col-md-12 drag">
                <h2 style="margin-top:70px">{{ $apartado }}</h2>
            </div>

            @foreach($tipos_documentos as $tipo)

                <div class="col-md-3">
                    <p class="titulo_tipo_documento">
                        @if(isset($files[$tipo->id]))
                            <a href="/documentos/download/{{ $files[$tipo->id]['id'] }}" class="">{{ $tipo->nombre }}</a>
                        @else
                            {{ $tipo->nombre }}
                        @endif
                    </p>

                </div>
                <div class="col-md-6">
                    @if(!empty($tipo->pregunta))
                        <p>
                            <input type="checkbox" class="chk" data-id_toggle="chk{{ $tipo->id }}" {{ ( isset($files[$tipo->id]) && $files[$tipo->id]['aprobado'])?"checked":"" }}>
                            {{ $tipo->pregunta }}
                        </p>
                    @endif
                </div>
                <div class="col-md-3">
                    @if(isset($files[$tipo->id]))
                        @if(!empty($tipo->pregunta))
                            <input type="checkbox" id="chk{{ $tipo->id  }}" class="bootstrapSwitch" data-on-color="success" data-doc_id="{{ $files[$tipo->id]['id']  }}"
                                   data-on-text="SI" data-off-text="NO" {{ ( $files[$tipo->id]['aprobado'] )?" checked ":" disabled=disabled " }}
                            >
                        @else
                            <input type="checkbox" id="chk{{ $tipo->id  }}" class="bootstrapSwitch" data-on-color="success" data-doc_id="{{ $files[$tipo->id]['id']  }}"
                                   data-on-text="SI" data-off-text="NO" {{ ( $files[$tipo->id]['aprobado'] )?" checked ":"" }}
                            >
                        @endif
                    @endif
                        <br><br>
                </div>
            @endforeach
        @endforeach
    </div>
@endsection


@section('extra-js')
<script src="{{ asset('assets/plugins/bower_components/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
<script>
    $(function(){
        $(".bootstrapSwitch").bootstrapSwitch();

        $('.bootstrapSwitch').on('switchChange.bootstrapSwitch', function(event, state) {
            var doc_id = $(this).data('doc_id');
            var formDetail = new FormData();
            formDetail.append('state' , state);
            formDetail.append('doc_id' , doc_id);

            $.ajax({
                url: '{{ route('admin_aprobar_documento') }}',
                type: 'POST',
                dataType: "json",
                data:formDetail,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $.toast({
                        heading: 'Ok.',
                        text: "Documento actualizado correctamente.",
                        position: 'top-right',
                        loaderBg:'#ff6849',
                        icon: 'success',
                        hideAfter: 9500
                    });
                },
                error:function(data){
                    $.toast({
                        heading: 'Error.',
                        text: "Error al cambiar estatus. Intenta otra vez.",
                        position: 'top-right',
                        loaderBg:'#ff6849',
                        icon: 'error',
                        hideAfter: 9500
                    });
                }
            });


        });

        $(".chk").click(function(e){
            var toggle = $(this).data('id_toggle');
            var chk = $('input[id="'+ toggle +'"]');

            if( $(this).prop('checked') ) {
                chk.bootstrapSwitch('disabled', false, true);
            }else{
                chk.bootstrapSwitch('disabled', true, true);
            }
        })
    })
</script>
@endsection