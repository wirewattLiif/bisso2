@extends('layouts.app')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/bower_components/dropify/dist/css/dropify.min.css') }}">
@stop

@section('breadcrumb')
    <div class="row bg-title">
        <div class="col-md-12">
            <h2>
                <a href="{{ route('integrador.solicitud.show',$solicitud->id) }}" class="btn btn-default2 btn-rounded">Solicitud: {{ $solicitud->id }}</a>            
                Carga de documentos
            </h2>
        </div>
    </div>    
@stop

@section('content')
    <div class="row">

        
        <hr>


        @foreach($apartados as $apartado => $tipos_documentos)
            <div class="col-md-12 drag">
                <h2 style="margin-top:70px">{{ $apartado }}</h2>
            </div>

            @foreach($tipos_documentos as $tipo)
                <div class="col-md-4 drag">
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
                           {!! ( isset($files[$tipo->id]) )?"data-default-file=\"".$files[$tipo->id]['filename']."\"" :"" !!}
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


@endsection

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
