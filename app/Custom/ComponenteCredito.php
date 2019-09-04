<?php 
namespace App\Custom;

use Spatie\ArrayToXml\ArrayToXml;

class ComponenteCredito
{
    private $aplicante;

    #private $domicilio;
    private $xml;
    private $cotizacion_detalle;
    private $ingresos_mensuales;
    private $monto_solicitado;

    
    private $mensualidad_ww;
    
    private $limit_dti_pre;
    private $limit_dti_post;
    private $max_mensualidad;
    private $ltv;

    private $apto_credito;

    private $plan_seleccionado;

    public $msj_credito;
    public $deuda_mensual;
    public $dti_pre;
    public $dti_post;
    public $fico_score;
    public $error;

    /** 
     * @param array $aplicante
     * @param array $domicilio
     * @param object $cotizacion_detalle      
    */
    function __construct($aplicante, $cotizacion_detalle) {
        $this->aplicante = $aplicante;
        
        $this->xml = '';

        
        $this->cotizacion_detalle = $cotizacion_detalle->toArray();
        $this->mensualidad_ww = $cotizacion_detalle->mensualidad;
        $this->ingresos_mensuales = $aplicante['salario_mensual']; #//TODO: Sumar los de coaplicante
        
        
        $this->fico_score = 0;
        $this->deuda_mensual = 0;
        $this->dti_pre = 0;
        $this->dti_post = 0;
        $this->max_mensualidad = 0;
        $this->ltv = $cotizacion_detalle->monto_financiar / $cotizacion_detalle->monto_solicitado;
        $this->monto_solicitado = $cotizacion_detalle->monto_solicitado;


        #//Buscamos el plan para setear limit_dti
        $this->limit_dti_pre = (!is_null($cotizacion_detalle->plan->dti_pre))? $cotizacion_detalle->plan->dti_pre / 100 :0;
        $this->limit_dti_post = (!is_null($cotizacion_detalle->plan->dti_post))? $cotizacion_detalle->plan->dti_post / 100 :0;

        $this->plan = $cotizacion_detalle->plan;
        
        $this->apto_credito = true;
        $this->msj_credito = [];
        $this->error = false;
        $this->msj_error = false;
        
    }

    
    public function revisaBuro(){

        $this->generaXML();
        #dd($this->getXmlGenerado());

        //De momento regresamos un xml Harcode y suponemos que esa es la estructura de la respuesta
        $respuesta = $this->consulta();

        //Mandamos el xml resultado de la consulta para saber si el cliente es apto o no para el credito
        $this->preautorizacion($respuesta);    
        return ['autorizado'=> $this->apto_credito,'msj_credito'=>$this->msj_credito];
        
    }

    private function createPersona($data){
        unset($data['ine']);        
        $domicilio = $data['Domicilio'];


        unset($data['Domicilio']);        
        $data = array_map([$this,'normaliza'],$data);
        $data = array_map('strtoupper',$data);
        // dd($domicilio);

        #//Generamos array persona para el aplicante
        $estado_display = \App\Estado::select('clave')->where('id',$domicilio['estado_id'])->first();
        $municipio_display = \App\Municipio::select('nombre')->where('id',$domicilio['municipio_id'])->first();
        $domicilio['estado_display'] = $estado_display->clave;
        $domicilio['municipio_display'] = $municipio_display->nombre;
        $domicilio = array_map([$this,'normaliza'],$domicilio);
        $domicilio = array_map('strtoupper',$domicilio);

        // dd($domicilio['colonia']);

        #//Colonia la esta mostrando en minusculas
        $uniqid = strtoupper(uniqid());
        $persona = [
            'DetalleConsulta'=>[
                'FolioConsultaOtorgante'=>$uniqid, //TODO:  Como lo vamos a definir
                'ProductoRequerido'=>26, //14 y 9.
                'TipoCuenta'=>'F', //F - pagos fijos Pag(76)
                'ClaveUnidadMonetaria'=>'MX',
                'ImporteContrato'=>intval($this->monto_solicitado), //TODO: Va el monto a financiar, o el monto solicitado
                'NumeroFirma'=>$uniqid //TODO: Como generar folio. Se va a guardar?
            ],
            'Nombre'=>[
                'ApellidoPaterno'=>@$data['apellido_paterno'],
                'ApellidoMaterno'=>@$data['apellido_materno'],
                'ApellidoAdicional'=>'',
                'Nombres'=>@$data['nombre'],
                'FechaNacimiento'=>date('Y-m-d',strtotime(@$data['fecha_nacimiento'])),
                'RFC'=>@$data['rfc'],
                'CURP'=>@$data['curp'],
                'Nacionalidad'=>'MX', #//TODO: Va a haber distintas opciones?
                'Residencia'=>'', #// TODO: 1 = Propietario,2 = Renta,3 = Vive con familiares,4 = Vivienda Hipotecada
                'EstadoCivil'=>'', #//TODO: D = Divorciado,L = Unión Libre,C = Casado,S = Soltero,V = Viudo,E = Separado
                'Sexo'=>(@$data['genero'] == 'masculino')?'M':'F' ,
                'ClaveElectorIFE'=>'',
                'NumeroDependientes'=>''
            ],
            'Domicilios'=>[
                'Domicilio'=>[
                    'Direccion'=>@$domicilio['calle'] . ' ' . @$domicilio['numero_ext'] .  ((!empty($domicilio['numero_int']))?' Ext ' . @$domicilio['numero_int']:'') ,
                    'ColoniaPoblacion'=>@$domicilio['colonia'],
                    'DelegacionMunicipio'=>@$domicilio['municipio_display'],
                    'Ciudad'=>@$domicilio['ciudad'],
                    'Estado'=>@$domicilio['estado_display'],
                    'CP'=>@$domicilio['cp'],
                    'FechaResidencia'=>'',
                    'NumeroTelefono'=>'',
                    'TipoDomicilio'=>'',
                    'TipoAsentamiento'=>'',
                ]
            ],
            'Empleos'=>[
                'Empleo'=>[
                    'NombreEmpresa'=>'',
                    'Direccion'=>'',
                    'ColoniaPoblacion'=>'',
                    'DelegacionMunicipio'=>'',
                    'Ciudad'=>'',
                    'Estado'=>'',
                    'CP'=>'',
                    'NumeroTelefono'=>'',
                    'Extension'=>'',
                    'Fax'=>'',
                    'Puesto'=>'',
                    'FechaContratacion'=>'',
                    'ClaveMoneda'=>'',
                    'SalarioMensual'=>'',
                    'FechaUltimoDiaEmpleo'=>'',
                ]
            ],
            'CuentasReferencia'=>[
                'NumeroCuenta'=>''
            ]
        
        ];

        #dd($persona);

        return $persona;
    }

    private function generaXML(){
        #//Creamos array de personas
        $personas = [];  
        $aplicante = $this->createPersona($this->aplicante);        
        #//Agregamos el aplicante al array de personas
        array_push($personas,$aplicante);


        if(env('SERVICE_BURO_PRODUCTION_MODE')){
            $array = [
                'Encabezado' => [
                    'ClaveOtorgante' => env('SERVICE_BURO_CLAVE_OTORGANTE'),
                    'NombreUsuario' => env('SERVICE_BURO_NOMBRE_USUARIO'),
                    'Password'=>env('SERVICE_BURO_PASSWORD'),
                ],
                'Personas'=>[
                    'Persona'=>$personas
                ]
            ];
        }else{            
            $array = [
                'Encabezado' => [
                    'ClaveOtorgante' => env('SERVICE_BURO_CLAVE_OTORGANTE_TEST'),
                    'NombreUsuario' => env('SERVICE_BURO_NOMBRE_USUARIO_TEST'),
                    'Password'=>env('SERVICE_BURO_PASSWORD_TEST'),
                ],
                'Personas'=>[
                    'Persona'=>$personas
                ]
            ];
        }

        #dd($array);

        $result = ArrayToXml::convert($array, [
            'rootElementName' => 'Consulta',
            '_attributes'=>[
                'xmlns:xsi'=>'http://www.w3.org/2001/XMLSchema-instance',
                'xsi:noNamespaceSchemaLocation'=>'/Consulta.xsd'
            ],
        ], true, 'ISO-8859-1');

        
        $this->xml = $result;
    }

    private function consulta(){
        #//Proceso de llamada al WS
        #//Aqui solamente va logica del consumo del WS para obtener el XML y lo retornamos
 
        
        #//String para pruebas
        $string_xml = '<?xml version="1.0" encoding="ISO-8859-1"?><Consulta xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="/Consulta.xsd"><Encabezado><ClaveOtorgante>0000081008</ClaveOtorgante><NombreUsuario>IHG8728CCO</NombreUsuario><Password>pru3ba00</Password></Encabezado><Personas><Persona><DetalleConsulta><FolioConsultaOtorgante>0010001</FolioConsultaOtorgante><ProductoRequerido>26</ProductoRequerido><TipoCuenta>F</TipoCuenta><ClaveUnidadMonetaria>MX</ClaveUnidadMonetaria><ImporteContrato>1000</ImporteContrato><NumeroFirma>539105865fb14d92bbd16f9cf</NumeroFirma></DetalleConsulta><Nombre><ApellidoPaterno>OSORIO</ApellidoPaterno><ApellidoMaterno>CHONG</ApellidoMaterno><ApellidoAdicional></ApellidoAdicional><Nombres>MIGUEL ANGEL</Nombres><FechaNacimiento>1980-01-04</FechaNacimiento><RFC></RFC><CURP></CURP><Nacionalidad></Nacionalidad><Residencia></Residencia><EstadoCivil></EstadoCivil><Sexo></Sexo><ClaveElectorIFE></ClaveElectorIFE><NumeroDependientes></NumeroDependientes></Nombre><Domicilios><Domicilio><Direccion>INSURGENTES SUR 1004</Direccion><ColoniaPoblacion>INSURGENTES</ColoniaPoblacion><DelegacionMunicipio>BENITO JUAREZ</DelegacionMunicipio><Ciudad>BENITO JUAREZ</Ciudad><Estado>DF</Estado><CP>04480</CP><FechaResidencia></FechaResidencia><NumeroTelefono></NumeroTelefono><TipoDomicilio></TipoDomicilio><TipoAsentamiento>0</TipoAsentamiento></Domicilio></Domicilios><Empleos><Empleo><NombreEmpresa/><Direccion/><ColoniaPoblacion/><DelegacionMunicipio/><Ciudad/><Estado/><CP/><NumeroTelefono/><Extension/><Fax/><Puesto/><FechaContratacion/><ClaveMoneda/><SalarioMensual/><FechaUltimoDiaEmpleo/></Empleo></Empleos><CuentasReferencia><NumeroCuenta/></CuentasReferencia></Persona></Personas></Consulta>';

        try {
            if(env('SERVICE_BURO_PRODUCTION_MODE')){
                $wsdl = public_path() . "/ConsultaReporteCCProd.wsdl";
            }else{
                $wsdl = public_path() . "/ConsultaReporteCCTest.wsdl";
            }

            $cliente = new \SoapClient($wsdl);

            $parameters = ['arg0' => $this->xml];
            #$parameters = ['arg0' => $string_xml];
            $respuesta = $cliente->generaReporte($parameters);
            ##dd($respuesta);

            $xml_response = simplexml_load_string($respuesta->return);            
        } catch (Exception $e) {
            $this->error = true;
            $this->msj_credito[] = 'Error al consumir WS de consulta de credito.';
            throw new \Exception('Error al consumir WS de consulta de credito.');
        }

        #dd($xml_response);
        
        return $xml_response;
    }

    /**
     * @param object $xmlCC - de momento es un xml
     * 
     * Calculos para validar el credito del aplicante y coaplicante en caso de que se necesite
     */
    private function preautorizacion($xmlCC){
        #//
        #dd($xmlCC); #//Debuguear cuando se necesite ver la respuesta tal cual que regresa Circulo de credito


        if (isset($xmlCC->Errores)) {
            $errores = $xmlCC->Errores->children();
            $this->apto_credito = false;
            foreach ($errores as $k => $er) {                
                $this->msj_credito[] = $er;
            }
            $this->error = true;
            return false;            
        }

        #// TODO: Revisar si el existe el nodo Errores
        if (!isset($xmlCC->Personas)) {
            return false;
        }

        $personas = $xmlCC->Personas;
        if($personas->children()->count() > 0){
            #dd($personas);
            foreach ($personas->children() as  $persona) {
                #dd($persona);
                #//Si nodo Scores esta disponible y si tiene nodos de scores
                if(isset($persona->Scores) && $persona->Scores->children()->count() > 0){
                    foreach ($persona->Scores->children() as $k => $score) {
                        #//Buscamos el Fico score de la persona
                        if($score->NombreScore == 'FICO'){
                            #//Obtenemos el fico score
                            $this->fico_score = $score->Valor;
                        }
                    }
                }

                
                
                if(isset($persona->Cuentas) && $persona->Cuentas->children()->count() > 0){
                    #//TODO: Si persona no tiene cuentas, deuda mensual debe ser 0
                    foreach ($persona->Cuentas->children() as $k => $cuenta) {
                        #//Revisamos si la cuenta en el valor SaldoActual, si es = 1, esta activa la cuenta
                        if( $cuenta->SaldoActual > 0){
                            #//Calculamos deuda mensual, dependiendo el periodo de pago
                            $deuda_mensual = 0;
                            $frecuencia_pagos = $cuenta->FrecuenciaPagos;
                            if ($frecuencia_pagos == 'Q') {
                                $deuda_mensual = $cuenta->MontoPagar * 2;
                            }elseif ($frecuencia_pagos == 'S') {
                                $deuda_mensual = $cuenta->MontoPagar * 4;
                            }elseif($frecuencia_pagos == 'M'){
                                $deuda_mensual = $cuenta->MontoPagar;
                            }
                            $this->deuda_mensual += $deuda_mensual;
                        }            
                    }                 
                }
            }
        }else{            
            throw new \Exception('No hay personas agregadas en la respuesta.');
        }
        #dd($this->ingresos_mensuales);
        #//Calculamos dti_pre y dti_post
        $this->dti_pre = $this->deuda_mensual / $this->ingresos_mensuales;
        $this->dti_post = ($this->deuda_mensual + $this->mensualidad_ww) / $this->ingresos_mensuales;
    }



    public function getXmlGenerado(){
        return $this->xml;
    }

    private function normaliza($cadena){
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = strtolower($cadena);
        return utf8_encode($cadena);
    }


}