@extends('layouts.app')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/bower_components/dropify/dist/css/dropify.min.css') }}">
@stop

@section('content')
<div class="row thin-steps-numbered-bg">
    <div class="col-md-4 column-step">
        <div class="step-number">1</div>
        <div class="step-title">PREAPROBACIÓN</div>
    </div>
    <div class="col-md-4 column-step active">
        <div class="step-number">2</div>
        <div class="step-title">RECOLECCIÓN DE DOCUMENTOS</div>
    </div>
    <div class="col-md-4 column-step">
        <div class="step-number">3</div>
        <div class="step-title">RECIBE TU PRÉSTAMO</div>
    </div>
</div>


<br><br>
<div class="row">

    <h3>
        {{ Auth::user()->nombre }}, recuerda que puedes subir fotos o PDFs.
    </h3>
    <p>
        Antes de subirlos asegúrate	que	se alcanzan a leer bien	y que se vea el	documento completo. <br>
        Puedes ir subiendo los documentos por partes, al subir cada	documento se guardarán en automático. <br>
        Puedes revisar el estatus de cada documento	una	vez	revisados y	aprobados por nuestros analistas.
    </p>


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
                @if( isset($files[$tipo->id]) && !$files[$tipo->id]['aprobado'])
                    <a href="#" class="btn btn-outline btn-rounded btn-warning" style="margin-top:10px">En revisión</a>
                @elseif( isset($files[$tipo->id]) && $files[$tipo->id]['aprobado'])
                    <a href="#" class="btn btn-rounded btn-warning" style="margin-top:10px">Aprobado</a>
                @endif
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
                        console.log(response)

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
                            icon : 'success',
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
