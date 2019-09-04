$(function() {

	//jQuery time
	var current_fs, next_fs, previous_fs; //fieldsets
	var left, opacity, scale; //fieldset properties which we will animate
	var animating; //flag to prevent quick multi-click glitches
	var errores = '';

	$(".next").click(function(){
		if(animating) return false;
		animating = true;

		current_fs = $(this).parent();
		next_fs = $(this).parent().next();

		//show the next fieldset
		var res = true;
		if( $(this).attr('id') == 'btnStep1'){
            res = validateStep1();
		}else if($(this).attr('id') == 'btnStep2'){
            res = validateStep2();
		}else if($(this).attr('id') == 'integradoresBtnStep1'){
            res = integradoresValidateStep1();
        }else if($(this).attr('id') == 'integradoresBtnStep2'){
            res = integradoresValidateStep2();
        }else if($(this).attr('id') == 'integradoresBtnStep3'){
            res = integradoresValidateStep3();
        }

		if (!res){
            animating = false;
            return false;
        }

        //activate next step on progressbar using the index of next_fs
        $("#eliteregister li").eq($("fieldset").index(next_fs)).addClass("active");

        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now, mx) {
                scale = 1 - (1 - now) * 0.2;
                left = (now * 50)+"%";
                opacity = 1 - now;
                current_fs.css({'transform': 'scale('+scale+')'});
                next_fs.css({'left': left, 'opacity': opacity});
            },
            duration: 800,
            complete: function(){
                current_fs.hide();
                animating = false;
            },
            easing: 'easeInOutBack'
        });

	});

	$(".previous").click(function(){
		if(animating) return false;
		animating = true;

		current_fs = $(this).parent();
		previous_fs = $(this).parent().prev();

		//de-activate current step on progressbar
		$("#eliteregister li").eq($("fieldset").index(current_fs)).removeClass("active");

		//show the previous fieldset
		previous_fs.show();
		//hide the current fieldset with style
		current_fs.animate({opacity: 0}, {
			step: function(now, mx) {
				//as the opacity of current_fs reduces to 0 - stored in "now"
				//1. scale previous_fs from 80% to 100%
				scale = 0.8 + (1 - now) * 0.2;
				//2. take current_fs to the right(50%) - from 0%
				left = ((1-now) * 50)+"%";
				//3. increase opacity of previous_fs to 1 as it moves in
				opacity = 1 - now;
				current_fs.css({'left': left});
				previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
			},
			duration: 800,
			complete: function(){
				current_fs.hide();
				animating = false;
			},
			//this comes from the custom easing plugin
			easing: 'easeInOutBack'
		});
	});
});


function validateStep1(){
	var errores = "";
	if ( $('#precio_sistema').val() == ''){
		errores += "*El precio del sistema es necesario. <br>";
	}

	// if( $('#enganche').val() == 0){
     //    errores += "*No se seleccionó valor para enganche. <br>";
	// }

    if( $('#plazo_financiar').val() == 0){
        errores += "*No se seleccionó el plazo a financiar.<br>";
    }

	if (errores != ""){
        $.toast({
            heading: 'Errores detectados',
            text: errores,
            position: 'top-right',
            loaderBg:'#ff6849',
            icon: 'error',
            hideAfter: 9500
        });
		return false;
	}

    return true;
}


function validateStep2(){
    var errores = "";
    if ( $('#correo').val() == ''){
        errores += "*El email es necesario para avanzar. <br>";
    }

    if ( $('#nombre').val() == ''){
        errores += "*El nombre es necesario para avanzar. <br>";
    }

    if ( $('#apellido_paterno').val() == ''){
        errores += "*El apellido paterno es necesario para avanzar. <br>";
    }

    if ( $('#estado_nacimiento_id').val() == ''){
        errores += "*El estado de nacimiento es necesario para avanzar. <br>";
    }

    if (errores != ""){
        $.toast({
            heading: 'Errores detectados',
            text: errores,
            position: 'top-right',
            loaderBg:'#ff6849',
            icon: 'error',
            hideAfter: 9500
        });
        return false;
    }


    var formDetail = new FormData();
    formDetail.append('solicitud_precio_sistema' , $('#precio_sistema').val() );
    formDetail.append('solicitud_enganche' , $('#enganche').val() );
    formDetail.append('solicitud_plazo_financiar' , $('#plazo_financiar').val() );

    formDetail.append('solicitud_comision_apertura' , $('#input_comision_apertura').val() );
    formDetail.append('solicitud_costo_anual_seguro' , $('#input_costo_anual_seguro').val() );
    formDetail.append('solicitud_pago_inicial' , $('#input_pago_inicial').val() );

    formDetail.append('solicitud_plan_id' , $('#plan_id').val() );

    formDetail.append('cliente_nombre' , $('#nombre').val() );
    formDetail.append('cliente_apellido_paterno' , $('#apellido_paterno').val() );
    formDetail.append('cliente_apellido_materno' , $('#apellido_materno').val() );
    formDetail.append('cliente_telefono_movil' , $('#telefono_movil').val() );
    formDetail.append('cliente_correo' , $('#correo').val() );
    formDetail.append('cliente_estado_nacimiento_id' , $('#estado_nacimiento_id').val() );
    formDetail.append('cliente_inmueble_id' , $('#inmueble_id').val() );




    var pass = "";
    $.ajax({
        url: "/registro_cliente",
        type: 'POST',
        dataType: "json",
        data:formDetail,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            pass = true;

        	if(data.error){
                $.toast({
                    heading: 'Errores detectados',
                    text: data.msj,
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'error',
                    hideAfter: 9500
                });
                pass = false;
			}

            getPeriodos();
            $('#btnPdf').attr('href','/solicitud/pdf/' + data.solicitud.id);
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
}


function integradoresValidateStep1(){
    var errores = "";

    if( $('input[name="user_nombre"]').val() == '' ){
        errores += "*El nombre de usuario es necesario. <br>";
    }

    if( $('input[name="user_apellidos"]').val() == '' ){
        errores += "*Los apellidos del usuario son necesarios. <br>";
    }

    if( $('input[name="user_email"]').val() == '' ){
        errores += "*El email es necesario. <br>";
    }

    if( $('input[name="user_phone"]').val() == '' ){
        errores += "*El celular es necesario. <br>";
    }

    if ( $('input[name="user_password"]').val() == ''){
        errores += "*La contraseña es necesaria. <br>";
    }else{
        if ( $('input[name="user_password"]').val() != $('input[name="user_password_confirmation"]').val()){
            errores += "*La contraseña no coincide. <br>";
        }
    }

    if (errores != ""){
        $.toast({
            heading: 'Errores detectados',
            text: errores,
            position: 'top-right',
            loaderBg:'#ff6849',
            icon: 'error',
            hideAfter: 9500
        });
        return false;
    }

    var formDetail = new FormData();
    formDetail.append('nombre' , $('input[name="user_nombre"]').val() );
    formDetail.append('apellidos' , $('input[name="user_apellidos"]').val() );
    formDetail.append('email' , $('input[name="user_email"]').val() );
    formDetail.append('phone' , $('input[name="user_phone"]').val() );
    formDetail.append('password' , $('input[name="user_password"]').val() );
    formDetail.append('password_confirmation' , $('input[name="user_password_confirmation"]').val() );

    var pass = "";
    $.ajax({
        url: "/integradores/registro/step1",
        type: 'POST',
        dataType: "json",
        data:formDetail,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            pass = true;

            if(!data.success){
                $.toast({
                    heading: 'Errores detectados',
                    text: data.msj,
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'error',
                    hideAfter: 9500
                });
                pass = false;
            }else{
                $('#usuario_id').val( data.data['id']);
            }
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
}

function integradoresValidateStep2(){
    var errores = "";

    if( $('input[id="integrador_razon_social"]').val() == '' ){
        errores += "*La razón social es necesaria. <br>";
    }

    if( $('input[id="integrador_nombre_comercial"]').val() == '' ){
        errores += "*El nombre comercial es necesario. <br>";
    }

    if( $('input[id="integrador_rfc"]').val() == '' ){
        errores += "*El RFC es necesario. <br>";
    }

    if (errores != ""){
        $.toast({
            heading: 'Errores detectados',
            text: errores,
            position: 'top-right',
            loaderBg:'#ff6849',
            icon: 'error',
            hideAfter: 9500
        });
        return false;
    }

    return true;
}


function integradoresValidateStep3(){
    $('#msform').attr('action',"/integradores/registro/step3").submit();
}
