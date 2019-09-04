<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});


Auth::routes();



Route::get('estados/getMunicipios/{id}','EstadosController@getMunicipios');

Route::get('/', 'ClientesController@registro');
Route::post('/registro_cliente','ClientesController@registro_cliente')->name('registro_cliente');

Route::post('/calcula_periodos','ClientesController@calculaPeriodos')->name('calcula_periodos');

Route::get('/aviso_privacidad',function(){
    return view('aviso_privacidad');
});

Route::get('/terminos_condiciones',function(){
    return view('terminos_condiciones');
});

Route::get('/check/{cliente_id}', 'ClientesController@check');

Route::get('/integradores/registro','IntegradorController@registro')->name('integradores.registro');
Route::post('/integradores/registro/step1','IntegradorController@registro_step1')->name('integradores.registro_step1');
Route::post('/integradores/registro/step3','IntegradorController@registro_step3')->name('integradores.registro_step3');


Route::get('/info_serv',function(){
    phpinfo();
});

Route::group(['middleware'=>'auth'],function(){
    Route::get('/home', 'HomeController@index')->name('home');

    #//Cliente
    Route::get('/aprobacion_credito', 'ClientesController@aprobacion_credito')->name('aprobacion_credito');
    Route::post('/aprobacion_credito','ClientesController@postSteps')->name('postSteps'); //ajax que edita datos de cada step

    #//Solicitudes
    Route::get('/solicitudes','SolicitudesController@solicitudes_cliente')->name('solicitudes_cliente')->middleware(\App\Http\Middleware\CheckCliente::class);
    Route::get('/mis_documentos','SolicitudesController@documentos_cliente')->name('documentos_cliente')->middleware(\App\Http\Middleware\CheckCliente::class);

    Route::get('/carga_documentos/{id}','SolicitudesController@view_carga_documentos')->name('view_carga_documentos')->middleware(\App\Http\Middleware\CheckCliente::class);
    Route::post('/carga_documentos','SolicitudesController@carga_documentos')->name('carga_documentos');

    Route::get('/carga_documentos_firmados/{id}','SolicitudesController@view_carga_documentos_firmados')->name('view_carga_documentos_firmados')->middleware(\App\Http\Middleware\CheckCliente::class);


    #//PDF cotización
    Route::get('/solicitud/pdf/{id}','SolicitudesController@pdf')->name('pdf_solicitud');

    #//Formatos PDF
    Route::get('/solicitud/pagare/{id}','SolicitudesController@pagare')->name('pagare_solicitud');
    Route::get('/solicitud/pagare_obligado_solidario/{id}','SolicitudesController@pagare_obligado_solidario')->name('pagare_obligado_solidario');
    Route::get('/solicitud/autorizacion_crediticia/{id}','SolicitudesController@autorizacion_crediticia')->name('autorizacion_crediticia');
    Route::get('/solicitud/autorizacion_crediticia_obligado_solidario/{id}','SolicitudesController@autorizacion_crediticia_obligado_solidario')->name('autorizacion_crediticia_obligado_solidario');
    Route::get('/solicitud/autorizacion_crediticia_negocio/{id}','SolicitudesController@autorizacion_crediticia_negocio')->name('autorizacion_crediticia_negocio');
    Route::get('/solicitud/carta_propietario/{id}','SolicitudesController@carta_propietario')->name('carta_propietario');
    Route::get('/solicitud/contrato/{id}','SolicitudesController@contrato')->name('contrato');

    #//Documentos
    Route::get('/documentos/download/{id}/{client_id}/{tipo_id}','ClientesDocumentosController@attach')->name('download_documento');

    Route::get('/mi_perfil','UsuariosController@perfil')->name('perfil');
    Route::post('/mi_perfil','UsuariosController@edit_perfil')->name('perfil');


    Route::post('/solicitudes/getMensualidad','CotizacionController@getMensualidad')->name('solicitudes.getMensualidad');

    
    #//Prefijo Admin
    Route::group(['prefix' => 'admin','middleware'=>['checkAdmin']],function(){
        Route::get('/solicitudes','SolicitudesController@admin_index')->name('admin_solicitudes');
        Route::get('/solicitudes/{id}','SolicitudesController@admin_view')->name('admin_solicitud_view');
        Route::get('/autorizar_datos/{id}','SolicitudesController@admin_autorizar_datos')->name('admin_autorizar_datos');
        Route::post('/aprobar_documento','ClientesDocumentosController@aprobar')->name('admin_aprobar_documento');
        Route::post('/solicitudes/estatus','SolicitudesController@admin_estatus')->name('admin_solicitud_cambio_estatus');

        Route::get('/usuarios','UsuariosController@admin_index')->name('admin_index');
        Route::post('/usuarios','UsuariosController@admin_store')->name('admin_store');
        Route::post('/usuarios/edit','UsuariosController@admin_edit')->name('admin_edit');

        Route::get('/configuraciones','ConfiguracionesController@show')->name('show_configuraciones');
        Route::post('/configuraciones','ConfiguracionesController@update')->name('update_configuraciones');

        Route::post('/solicitudes/fico_deuda','SolicitudesController@update_deuda_fico');

        Route::get('/solicitud/edit/{id}','SolicitudesController@admin_show_edit')->name('admin_show_edit');
        Route::post('/solicitud/edit/{id}','SolicitudesController@admin_edit')->name('admin_edit');

        Route::delete('/solicitudes/{id}','SolicitudesController@admin_destroy');

        Route::resource('planes','PlanController');
        Route::resource('razones_sociales','RazonSocialController');

        Route::resource('productos', 'ProductoController');

        Route::delete('/integradores/{id}/activar','IntegradorController@admin_activar')->name('admin.integradores.activar');
        Route::post('/integradores/set_productos','IntegradorController@set_productos')->name('admin.integradores.set_productos');
        Route::resource('integradores', 'IntegradorController');


        Route::get('/cotizaciones_preautorizadas','CotizacionController@admin_preautorizadas')->name('admin.preautorizadas');
        Route::get('/preautorizadas','CotizacionController@admin_listadoPreautorizadas')->name('admin.listado_preautorizadas');

        Route::get('/preautorizacion/{detalle_cotizacion}/preautorizada','CotizacionController@admin_preautorizada')->name('admin.preautorizada');

        Route::get('/preautorizacion/{detalle_cotizacion}/detalle','CotizacionController@admin_preautorizacion_detalle')->name('admin.preautorizacion_detalle');
        Route::post('/preautorizacion/{detalle_cotizacion}/detalle','CotizacionController@admin_preautorizacion_autorizar')->name('admin.preautorizacion_autorizar');
        
        Route::get('/attach_file_dotizacion/{id}/{tipo_persona}/{archivo}','CotizacionController@attach_file_dotizacion')->name('admin.attach_file_dotizacion');        
    });


    Route::group(['prefix' => 'integrador','middleware'=>['checkIntegrador']],function(){
        Route::get('/mis_datos','IntegradorController@integrador_show')->name('integrador.integrador_show');
        Route::get('/cotizaciones','CotizacionController@index')->name('integrador.cotizaciones');
        Route::get('/cotizaciones_preautorizadas','CotizacionController@preautorizadas')->name('integrador.preautorizadas');

        Route::get('/cotizador/{cotizacion_id?}','CotizacionController@create')->name('integrador.cotizador');
        Route::post('/cotizador','CotizacionController@store')->name('integrador.add_cotizacion');

        //Cambiar ruta a controlador correcto
        Route::get('/cotizacion/{detalle_cotizacion}/preautorizar','CotizacionController@show_preautorizar')->name('integrador.show_preautorizar');
        Route::delete('/cotizacion_detalle/{detalle_cotizacion}/delete','CotizacionDetalleController@destroy')->name('integrador.detalle_cotizacion.delete');

        Route::post('/cotizacion/{detalle_cotizacion}/preautorizar','CotizacionController@preautorizar')->name('integrador.preautorizar');

        Route::get('/preautorizacion/{detalle_cotizacion}/detalle','CotizacionController@preautorizacion_detalle')->name('integrador.preautorizacion_detalle');
        Route::post('/preautorizacion/{detalle_cotizacion}/detalle','CotizacionController@preautorizacion_autorizar')->name('integrador.preautorizacion_autorizar');

        Route::get('/cotizacion/{solicitud_id}/solicitud','SolicitudesController@showSolicitudCotizacion')->name('integrador.showSolicitudCotizacion');


        Route::post('/solicitudes/postSteps','SolicitudesController@integrador_postSteps')->name('integrador.postSteps'); //ajax que edita datos de cada step
        Route::get('/solicitudes','SolicitudesController@integrador_solicitudes')->name('integrador.solicitudes'); //ajax que edita datos de cada step
        Route::get('/solicitudes/{id}','SolicitudesController@integrador_show')->name('integrador.solicitud.show');

        Route::get('/carga_documentos/{id}','SolicitudesController@integrador_show_carga_documentos')->name('integrador.show_carga_documentos');

        #//Agregar link para edit de solicitudes desde el integrador
        Route::get('/solicitud/edit/{id}','SolicitudesController@integrador_edit')->name('integrador.solicitudes.edit');
        Route::post('/solicitud/edit/{id}','SolicitudesController@integrador_update')->name('integrador.solicitudes.update');

        Route::get('/attach_file_dotizacion/{id}/{tipo_persona}/{archivo}','CotizacionController@attach_file_dotizacion')->name('integrador.attach_file_dotizacion');        
    });     

    

});



$this->get('logout', 'Auth\LoginController@logout')->name('logout');