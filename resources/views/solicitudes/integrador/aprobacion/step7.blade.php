<div class="row">
    <div class="col-md-12">
        <h2>Proyecto</h2>
    </div>
</div>


<div class="row">
    <div class="col-md-5">
        <p>Tipo de Proyecto</p>
        <select id="tipo_proyecto_id" class="form-control input_underline">
            @foreach($tipos_proyectos as $k => $v)
                <option value="{{ $k }}">{{ $v }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="row">

    <div class="col-md-2">
        <p>Cantidad</p>
        <input id="nota_cantidad"
                placeholder="{{ __('Cantidad') }}"
                type="text"
                class="input_underline form-control"
                value="0"
        >
    </div>

    <div class="col-md-5">
        <p>Descripción</p>
        <input id="nota_descripcion"
                placeholder="{{ __('Descripción') }}"
                type="text"
                class="input_underline form-control"
                value=""
        >
    </div>
    <div class="col-md-2">
        <p>Modelo / Marca</p>
        <input id="nota_modelo"
                placeholder="{{ __('Modelo / Marca') }}"
                type="text"
                class="input_underline form-control"
                value=""
        >
    </div>
    <div class="col-md-2">
        <p># de serie</p>
        <input id="nota_serie"
                placeholder="{{ __('# de serie') }}"
                type="text"
                class="input_underline form-control"
                value=""
        >
    </div>

    <div class="col-md-12">
        <div class="pull-right">
            <br>            
            <button class="btn btn-success btn-sm" id="btnNotas">Agregar (+)</button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <br>
        <table class="table" id="tblNotas">
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Descripción</th>
                    <th>Modelo / Marca</th>
                    <th># de serie</th>
                    <th></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <textarea name="" id="nota" cols="120" rows="10" style="display:none"></textarea>
    </div>
</div>




<script>
$(function(){
    $('#btnNotas').click(function(){
        var cantidad = $('#nota_cantidad').val();
        var descripcion = $('#nota_descripcion').val();
        var modelo = $('#nota_modelo').val();
        var serie = $('#nota_serie').val();

        var html = `<tr>
                        <td>${ cantidad }</td>
                        <td>${ descripcion }</td>
                        <td>${ modelo }</td>
                        <td>${ serie }</td>
                        <td><a href="#" class="delete">Eliminar</a></td>
                    </tr>`;
        
        $('#tblNotas tbody').append(html);
        var nota = `Cantidad:${cantidad}  |  Desc:${descripcion}   |   ${modelo}    |   ${serie} \n`;
                    
        $('#nota').append(nota);
    })

    $(document).on('click','.delete',function(e){
        e.preventDefault();
        if( confirm("¿Seguro de eliminar el row?") ){
            var tr = $(this).parent().parent();
            tr.remove();

        }
    })
})

function validateStep7(){

    if( $('#tblNotas tbody tr').length > 0){
        pass = false;
        var formDetail = new FormData();
        formDetail.append('step' , 7);
        formDetail.append('solicitud_id' ,  {{ $solicitud->id }});
        formDetail.append('cliente_id' , {{ $solicitud->cliente_id }});
        formDetail.append('tipo_proyecto_id' , $('#tipo_proyecto_id').val());
        formDetail.append('descripcion_de_bienes' , $('#nota').val());
        $.ajax({
            url: '{{ route('integrador.postSteps') }}',
            type: 'POST',
            dataType: "json",
            data:formDetail,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data);
                //pass = true;
                window.location = "{{ route('integrador.solicitudes') }}";
            },
            error:function(data){
                console.log(data.responseJSON.errors);
                var errors = "";
                $.each(data.responseJSON.errors,function(k,v){
                    errors += "<b>"+ k +"</b><br>";
                    $.each(v,function(i,err){
                        errors += "*" + err + "<br>";
                    })
                })
    
                $.toast({
                    heading: 'Errores detectados',
                    text: errors,
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'error',
                    hideAfter: 9500
                });
                pass = false;
            }
        });
        return pass;
    }else{
        $.toast({
            heading: 'Errores detectados',
            text: 'No hay partidas agregadas',
            position: 'top-right',
            loaderBg:'#ff6849',
            icon: 'error',
            hideAfter: 9500
        });
    }
}
</script>