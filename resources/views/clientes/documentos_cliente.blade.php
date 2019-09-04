@extends('layouts.app')



@section('breadcrumb')
    <div class="row bg-title">
        <div class="col-md-12">
            <h4 class="page-title d-inline">Mis documentos</h4>
        </div>
    </div>
@endsection



@section('content')
    <div class="row">
        @php $i = 1; @endphp
        @foreach($apartados as $apartado => $tipos_documentos)
            <div class="col-md-6">
                <h3 class="naranja" style="margin-top:20px">{{ $apartado }}</h3>
                @foreach($tipos_documentos as $tipo)
                    <p class="">
                        @if(isset($files[$tipo->id]))
                            <a href="/documentos/download/{{ $files[$tipo->id]['id'] }}" style="font-size: 20px;">
                                <i class="fa fa-file-pdf-o"></i>
                            </a>
                        @endif


                        <b>{{ $tipo->nombre }}</b>
                        @if( isset($files[$tipo->id]) && $files[$tipo->id]['aprobado'])
                            <button type="button" class="btn btn-success btn-circle"><i class="fa fa-check"></i> </button>
                        @endif
                    </p>
                @endforeach
            </div>

            @if( $i % 2 == 0)
                <div class="clearfix"></div>
            @endif
            @php $i++; @endphp
        @endforeach
    </div>


    <div class="row">
        <div class="col-md-12">
            <hr>
            <h3>Documentos firmados</h3>


            @php $i = 1; @endphp
            @foreach($apartados_firmados as $apartado => $tipos_documentos)
                <div class="col-md-6">
                    <h3 class="naranja" style="margin-top:20px">{{ $apartado }}</h3>
                    @foreach($tipos_documentos as $tipo)
                        <p class="">
                            @if(isset($files[$tipo->id]))
                                <a href="/documentos/download/{{ $files[$tipo->id]['id'] }}" style="font-size: 20px;">
                                    <i class="fa fa-file-pdf-o"></i>
                                </a>
                            @endif


                            <b>{{ $tipo->nombre }}</b>
                            @if( isset($files[$tipo->id]) && $files[$tipo->id]['aprobado'])
                                <button type="button" class="btn btn-success btn-circle"><i class="fa fa-check"></i> </button>
                            @endif
                        </p>
                    @endforeach
                </div>

                @if( $i % 2 == 0)
                    <div class="clearfix"></div>
                @endif
                @php $i++; @endphp
            @endforeach
        </div>
    </div>

@endsection