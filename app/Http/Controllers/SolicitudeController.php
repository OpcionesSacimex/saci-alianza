<?php

namespace App\Http\Controllers;

use App\Models\Solicitude;
use App\Models\Cliente;
use App\Models\User;
use App\Models\Convenios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\NuevaSolicitud;
use Illuminate\Support\Facades\Auth;
//use Barryvdh\DomPDF\Facade\Pdf;
use PDF;

/**
 * Class SolicitudeController
 * @package App\Http\Controllers
 */
class SolicitudeController extends Controller
{
    /**
     * Obtiene las solicitudes que estan en proceso, modificadas y en integracion
     * ordenandolas por fecha de modificacion, de tal forma que se siga un primeras entradas primeras salidas
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //se llama al metodo paginate con parametros para poder mantener paginias saparadas para cada tipo de solicitud
        $solicitudes = Solicitude::where('estado','En proceso')->orderBy('updated_at')->paginate($perPage = 10, $columns = ['*'], $pageName = 'enProceso');  
        $solicitudesRechazadas = Solicitude::where('estado','Modificada')->orderBy('updated_at')->paginate($perPage = 2, $columns = ['*'], $pageName = 'rechazadas');
        $solicitudesIntegracion = Solicitude::where('estado','En integracion')->orderBy('updated_at')->paginate($perPage = 2, $columns = ['*'], $pageName = 'enIntegracion');
        if(auth()->user()->tipo=="Admin"||auth()->user()->tipo=="Aesor")
        {
            return view('solicitude.panelAdmin', compact('solicitudes', 'solicitudesRechazadas', 'solicitudesIntegracion'))
            ->with('i', (request()->input('enProceso', 1) - 1) * $solicitudes->perPage())
            ->with('j', (request()->input('rechazadas', 1) - 1) * $solicitudesRechazadas->perPage())
            ->with('k', (request()->input('enIntegracion', 1) - 1) * $solicitudesIntegracion->perPage());
        }

        return view('solicitude.index', compact('solicitudes'))
            ->with('i', (request()->input('page', 1) - 1) * $solicitudesPag->perPage());
    }

    /**
     * Obtiene las solicitudes que estan en proceso, modificadas y en integracion únicamente para un convenio
     * ordenandolas por fecha de modificacion, de tal forma que se siga un primeras entradas primeras salidas
     * @return \Illuminate\Http\Response
     */
    public function Aliado()
    {
        $aliado = User::find(Auth::id())->convenio;
        $convenioAliado = Convenios::where('nombreCorto',$aliado)->first();
        $solicitudes = Solicitude::join('clientes', 'solicitudes.idcliente','=','clientes.id')
                       ->select('solicitudes.*')
                       ->where('solicitudes.estado','En proceso')
                       ->where('clientes.convenio',$convenioAliado->id)
                       ->orderBy('solicitudes.updated_at')
                       ->paginate($perPage = 10, $columns = ['*'], $pageName = 'enProceso');  
        $solicitudesRechazadas = Solicitude::join('clientes','solicitudes.idcliente','=','clientes.id')
                                 ->select('solicitudes.*')
                                 ->where('solicitudes.estado','Modificada')
                                 ->where('clientes.convenio',$convenioAliado->id)
                                 ->orderBy('solicitudes.updated_at')
                                 ->paginate($perPage = 2, $columns = ['*'], $pageName = 'rechazadas');
        $solicitudesIntegracion = Solicitude::join('clientes','solicitudes.idcliente','=','clientes.id')
                                  ->select('solicitudes.*')
                                  ->where('solicitudes.estado','En integracion')
                                  ->where('clientes.convenio',$convenioAliado->id)
                                  ->orderBy('solicitudes.updated_at')
                                  ->paginate($perPage = 2, $columns = ['*'], $pageName = 'enIntegracion');
        if(auth()->user()->tipo=="Admin"||auth()->user()->tipo=="Aesor"||auth()->user()->tipo=="Aliado")
        {
            return view('solicitude.panelAdmin', compact('solicitudes', 'solicitudesRechazadas', 'solicitudesIntegracion'))
            ->with('i', (request()->input('enProceso', 1) - 1) * $solicitudes->perPage())
            ->with('j', (request()->input('rechazadas', 1) - 1) * $solicitudesRechazadas->perPage())
            ->with('k', (request()->input('enIntegracion', 1) - 1) * $solicitudesIntegracion->perPage());
        }

        return view('solicitude.index', compact('solicitudes'))
            ->with('i', (request()->input('page', 1) - 1) * $solicitudesPag->perPage());
    }

    /**
     * Show the form for creating a new resource.
     * Método sin usar. El formumalrio para crear o editar solicitudes se maneja a traves de ClienteController
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $solicitude = new Solicitude();
        $iduser = $request->session()->get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
        $cliente = Cliente::where('user_id', $iduser)->first();
        return view('solicitude.create', compact('solicitude'))->with('idcliente',$cliente->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
        $iduser = $request->session()->get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
        $cliente = Cliente::where('user_id', $iduser)->first();
        
        $solicitude = new Solicitude();
        $solicitude->pagominimo=$request->input('pagominimo');
        $solicitude->pagomaximo=$request->input('pagomaximo');
        $solicitude->pagodeseado=$request->input('pagodeseado');
        $solicitude->plazo=$request->input('plazo');
        $solicitude->creditomaximo=$request->input('creditomaximo');
        $solicitude->prestamosolicitado=$request->input('prestamosolicitado');
        $solicitude->estado="En proceso";
        $solicitude->idcliente=$cliente->id;
        request()->validate(Solicitude::$rules);
        $solicitude->save();
        */
        //Esta primera parte guarda únicamente datos de
        //Prestamo solicitado, Cretido maximo, plazo, pago minimo, pago maximo, pago deseado
        //Los calculos para obtener y guardar monto retenido, cobertura de riesgo, monto recibido
        //y pago por plazo se realizan en el método show
        //Como anotación adicional, probablemente el proceso de como se realiza eso esta mal
        //Intentar cambiar si considera adecuado y si logra entender como hacerlo XD
        request()->validate(Solicitude::$rules);
        $solicitude = Solicitude::create($request->all());
        //Parte para calcular retemciones y seguros
        $cliente = Cliente::find($solicitude->idcliente);
        $Meses = $solicitude->plazo;
        $convenioT = Convenios::find($cliente->convenio);
        $retenciones=$convenioT->retenciones;
        if(($Meses<=6) && ($Meses>3)) $retenciones=2;
        elseif($Meses==3) $retenciones=1;
        else $retenciones = $convenioT->retenciones;
        $diaMes = 1;
        $fechaInicio = date("Y-m-d");
        $Transaccion = rand(10,10000000);
        //Se deben calcular los datos de los pagos, retencion y demás


        $monto = $solicitude->prestamosolicitado;
        
        $convenio = $convenioT->InstitucionNominaID.".00";
        $datos = $this->calcularRetencionesYSeguro(
                $monto, 
                $convenio, 
                $diaMes,
                $fechaInicio,
                $Meses,
                $Transaccion, 
                $retenciones,
                $solicitude,
                $cliente
        );
        $this->imprimirPDF($solicitude->id);

        $this->mandarCorreo($solicitude);
        //Se supone que ajuste pasivo si lo toma de la vista
        //fecha de inicio lo dejamos así, aunque se supone lo debería 
        //Hacer el observer, pero lo dejamos así por si marca un día
        //Inhabil o algo así
        //Y el convenio también lo hace el observer
        /*
        if(is_null($solicitude->estado)||$solicitude->estado="")
        {
            $solicitude->estado="En proceso";
            $solicitude->save();
        }
        */
        return redirect()->route('solicitudes.show',$solicitude->id);
        //return redirect()->route('home');
        /*
        return redirect()->route('solicitudes.index')
            ->with('success', 'Solicitude created successfully.');
        */
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $datos = session('datosSolicitud');
        $solicitude = Solicitude::find($id);
        $cliente = Cliente::find($solicitude->idcliente);
        $Meses = $solicitude->plazo;
        $convenioT = Convenios::find($cliente->convenio);
        //$convenioT = Convenios::where('nombreCorto',$usuario->convenio)->first();
        $retenciones=$convenioT->retenciones;
        //Se deben calcular los datos de los pagos, retencion y demás


        $monto = $solicitude->prestamosolicitado;
        $usuario = User::find(Auth::id());
        
        $convenio = $convenioT->InstitucionNominaID.".00";
        $retenciones = $convenioT->retenciones;
        if(($Meses<=6) && ($Meses>3)) $retenciones=2;
        elseif($Meses==3) $retenciones=1;
        else $retenciones = $convenioT->retenciones;
        //$convenio = 54.00;
        $diaMes = 1;
        $fechaInicio = date("Y-m-d");
        $Transaccion = rand(10,10000000);

        if(!isset($solicitude->fechainicio))
        {
            $fechaInicio=date_create($solicitude->updated_at);
            $fechaInicio = date_format($fechaInicio,"Y-m-d");
            $datos = $this->calcularRetencionesYSeguro(
                $monto,
                $convenio, 
                $diaMes,
                $fechaInicio,
                $Meses,
                $Transaccion, 
                $retenciones,
                $solicitude,
                $cliente
            );
        }

        //opcion para cuando se va a imprimir el pdf, para que no se vuelvan a realizar los calculos
        //Ya no se para que se hace esto
        //Se tiene un método individual para imprimir el pdf, y además hay que ver en que parte del 
        //proceso se hace
        if( !is_null(session('datosSolicitud'))&&isset($datos)&&!empty($datos)  )
        {
            $opcion=$request->get('opcion');
            if(Auth::user()->tipo=="Cliente"){
                //return redirect()->route('imprimirDatosSolicitud',$datos);
                /*
                $datos=session('datosSolicitud');
                $pdf = PDF::loadView('imprimir', ['cliente' => $cliente, 'solicitude'=> $solicitude]);
                $nombrepdf=strtoupper($cliente->nombre).'$'.number_format($monto, 2, '.', ',').$Meses.'Meses['.date("H:i:s").'].pdf';
                $descarga = $pdf->download($nombrepdf);
                $contenido = $descarga->getOriginalContent();
                $ruta = "public/files/".$cliente->id."/solicitudes/".$solicitude->id.'.pdf';
                Storage::put($ruta, $contenido);
                $datosCorreo = [
                    'idcliente' => $cliente->id,
                    'idsolicitud' =>$solicitude->id,
                ];
                $mailCliente = Auth::user();
                Mail::to($mailCliente)->send(new NuevaSolicitud($datosCorreo));
                */
                //Verificar en que parte se envía el PDF
                //return $descarga;
                //imprimir($datos);
            }
            return view('detalle', compact('solicitude'))->with('datos',$datos)->with('cliente',$cliente)->with('convenios', $convenioT);
        }
        
        
        /*
        //Consultas a la base de datos del antiguo sacialianza, pero parece ser que llama a un metodo de safi
        $simulacion     = DB::connection('produccion')->select("
                CALL CREPAGCRECAMORPRO($monto,$convenio,30,'M','D',$diaMes,'$fechaInicio',$Meses,3001,20235,'S','N','N',0.0,'S',@a,@b,@c,@d,@e,@f,@g,1,184,'$fechaInicio','192.168.100.184','/microfin/catalogoCliente.htm',13,-$Transaccion)
            ");
            DB::disconnect('produccion');
            $cuotasMensuales = count($simulacion);
            $cuotasQuincenales = count($simulacion)*2;
            $Par_FechaInicio = $simulacion[0]->Par_FechaInicio;
            $Par_FechaVenc = $simulacion[0]->Par_FechaVenc;
            $MontoCuotaMensual = $simulacion[0]->MontoCuota;
            $MontoCuotaQuincenal = ($MontoCuotaMensual/2);
            $montoRetenciones = $retenciones*$MontoCuotaQuincenal;

            //Consultas a la base de datos del antiguo sacialianza
            $seguro     = DB::connection('produccion')->select("
                CALL CALCSEGUROINDVPRO(DATEDIFF('$Par_FechaVenc','$Par_FechaInicio'),$monto,3001,@a,'S',@b,@c,1,0,'1900-01-01', '','SolicitudCreditoDAO',0,0);
            ");
            DB::disconnect('produccion');

            $MontoSeguro = $seguro[0]->MontoSeguro;
            $consultaBuro = 30;             //Pago de la consulta a buró de crédito, de momento son 30 peso, pero puede cambiar
            $montoRecibir = ($monto)-($montoRetenciones+$MontoSeguro)-$consultaBuro;

            //     Se guardan los detalles de la solicitud - Comentar si es que algo truena
            //     Se estan guardando de nuevo las solicitudes cada que se entra a ver el detalle
            //     Hay que tener cuidado, porque cuando se actualiza una solicitud se pasaba por alto esta parte
            if((!isset($solicitude->montoretenido))||
                (is_null($solicitude->montoretenido))||
                ($solicitude->montoretenido=="")||
                ($solicitude->montoretenido==0)||
                ($solicitude->estado=="Modificada"))
            {
                $solicitude->montoretenido=$montoRetenciones;
                $solicitude->coberturariesgo=$MontoSeguro;
                $solicitude->montorecibido=$montoRecibir;
                $solicitude->pagoplazo = $MontoCuotaQuincenal;
                $solicitude->save();
            }

            $datos = array(
                'cuotasQuincenales' => $cuotasQuincenales,
                'cuotasMensuales' => $cuotasMensuales,
                'Par_FechaInicio' => $Par_FechaInicio,
                'Par_FechaVenc' => $Par_FechaVenc,
                'MontoCuotaMensual' => $MontoCuotaMensual,
                'MontoCuotaQuincenal' => $MontoCuotaQuincenal,
                'MontoSeguro' => $MontoSeguro,
                'Monto' => $monto,
                'retenciones' => $retenciones,
                'montoRetenciones' => $montoRetenciones,
                'montoRecibir' => $montoRecibir,
                'pagoConsultaBuro' => 30,


                'NombreCompleto' => strtoupper($cliente->nombre),
                'whatsapp' => $cliente->telefono,
                'cuantoGana' => $cliente->ingresoquincenal,
                'cuantoDisponible' => $cliente->disponiblequincenal,
                'ajustePasivos' => $cliente->ajuste,
                'pagoMinimo' => $solicitude->pagominimo,
                'porcentajePago' => 0.4,        //Porcentaje que estaba por defecto
                'pagoMaximo' => $solicitude->pagomaximo,
                'pagoQuincenal' => $solicitude->pagodeseado,
                'meses' => $solicitude->plazo,
                'creditoMaximo' => $solicitude->creditomaximo,
                'plazoCredito' => $solicitude->meses,
                'montoSolicitado' => $solicitude->prestamosolicitado,
                'diaPago' => 1,
                'fechaInicio' => date("Y-m-d"),
                //'button' => $request->button,
            );
            session(['datosSolicitud' => $datos]);
            */
            /*
            $fecha = date_create($solicitude->fechainicio);
            $pdf = PDF::loadView('imprimir', ['cliente' => $cliente, 'solicitude'=> $solicitude]);
            $nombrepdf=strtoupper($cliente->nombre).'$'.number_format($monto, 2, '.', ',').$Meses.'Meses['.date_format($fecha,"d-m-Y").'].pdf';
            $descarga = $pdf->download($nombrepdf);
            $contenido = $descarga->getOriginalContent();
            $ruta = "files/".$cliente->id."/solicitudes/".$solicitude->id.'.pdf';
            Storage::put($ruta, $contenido);
            */
            //En la vista, el botón imprimir, redirige a este mismo controlador, mismo metodo
            //pero se incluye un campo opcion, donde se da la opción para generar el pdf y mandarlo por correo

            
        return view('detalle', compact('solicitude'))->with('datos',$datos)->with('cliente',$cliente)->with('convenios', $convenioT)->with('solicitude',$solicitude);  
        return view('solicitude.show', compact('solicitude'))->with('datos',$datos)
               ->with('cliente',$cliente)->with('convenios', $convenioT);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $solicitude = Solicitude::find($id);

        return view('solicitude.edit', compact('solicitude'))->with('idcliente',$solicitude->idcliente);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Solicitude $solicitude
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Solicitude $solicitude)
    {
        $estado = $request->input('estado');
        $prestamosolicitado = $request->input('prestamosolicitado');
        //Me parece que esto es para cuando simplemente se cambian de estado, sin modificar datos del credito
        // Y aplica solo para mandar a integración o para poner en proceso una solicitud
        if((($estado != "")&&(!is_null($estado)))&&((is_null($prestamosolicitado))||($prestamosolicitado=="")))
        {
            $SolicitudN = Solicitude::find($solicitude->id);
            $SolicitudN->estado = $estado;
            $SolicitudN->save();
            $cliente = Cliente::find($solicitude->idcliente);
            $telefono = "52". $cliente->telefono;
            if($estado=="Modificada")
            {
                $SolicitudN->estado = $estado;
                $SolicitudN->save($request->all());
                $cliente->convenio = $request->input('convenio');
                $cliente->save();
                $this->imprimirPDF($SolicitudN->id);
                $this->mandarCorreo($SolicitudN);
                return $this->enviarMensajeSolicitudRechazada($telefono, $SolicitudN->id);
            }elseif($estado=="En integracion")
            {
                $this->enviarMensajeSolicitudAceptada($telefono);
            }
            if($estado=="En proceso")
            {
                $this->imprimirPDF($SolicitudN->id);
                $this->mandarCorreo($SolicitudN);
                TelefonoController::enviarMensajeSolicitarRecibo($telefono);
                $url = str_replace("/solicitudes/".$solicitude->id,"",$request->url());
                
                $rutapdf = $url."/storage/public/files/".$cliente->id."/solicitudes/".$solicitude->id.".pdf";

                //return $rutapdf;
            }
            return redirect()->route('home');
        }
        else
        {
            /*
            request()->validate(Cliente::$rules);

            $cliente->update($request->all());
            */
            //return 1;
            request()->validate(Solicitude::$rules);
            $solicitude->update($request->all());
            //Parte para calcular retemciones y seguros
            $cliente = Cliente::find($solicitude->idcliente);
            $cliente->convenio=$request->input('convenio');
            $cliente->save();
            $Meses = $solicitude->plazo;
            $convenioT = Convenios::find($cliente->convenio);
            $retenciones=$convenioT->retenciones;
            if(($Meses<=6) && ($Meses>3)) {$retenciones=2;}
            elseif($Meses==3) {$retenciones=1;}
            else {$retenciones = $convenioT->retenciones;}
            $diaMes = 1;
            $fechaInicio = date("Y-m-d");
            $Transaccion = rand(10,10000000);
            //Se deben calcular los datos de los pagos, retencion y demás


            $monto = $solicitude->prestamosolicitado;
            
            $convenio = $convenioT->InstitucionNominaID.".00";
            $datos = $this->calcularRetencionesYSeguro(
                    $monto, 
                    $convenio, 
                    $diaMes,
                    $fechaInicio,
                    $Meses,
                    $Transaccion, 
                    $retenciones,
                    $solicitude,
                    $cliente
            );
            //$solicitude->ajustePasivos = $request->input('ajustePasivos');
            $solicitude->save();
            if(Auth::user()->tipo=="Admin")
            {
                $cliente = Cliente::find($solicitude->idcliente);
                $telefono = "52". $cliente->telefono;
                $solicitude->estado="Modificada";
                $solicitude->save();
                $this->imprimirPDF($solicitude->id);
                $this->mandarCorreo($solicitude);
                $this->enviarMensajeSolicitudRechazada($telefono, $solicitude->id);
            }
            elseif (($solicitude->estado=="Modificada")&&(Auth::user()->tipo=="Cliente"))
            {
                $solicitude->estado="En proceso";
                $solicitude->save();
            }

        }

        return redirect()->route('solicitudes.show',$solicitude->id);
        return redirect()->route('home');
        return redirect()->route('solicitudes.index')
            ->with('success', 'Solicitude updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $solicitude = Solicitude::find($id)->delete();

        return redirect()->route('home');
        return redirect()->route('solicitudes.index')
            ->with('success', 'Solicitude deleted successfully');
    }

    private function enviarMensajeSolicitudAceptada($telefono)
    {
        // ***************     Area de mensajes **********************
            //TOKEN QUE NOS DA FACEBOOK
            $token = 'EAADTQdf3uewBAFPzoi5in5hwB0lrGPDvmdK7i2j4kYbU4EonEZCq74KnMMVYnCIt1iDvONklkU6hFOHvtDW1782IPIZAdiLSeFZAJ6r8aYAzQtP6mNU9fdfvQZBZC2CgcZBMEGOSnDVHairOOmPeezA8FhJKXNV7L0tbZBlBoAtbbXuRdlhBxTFVYD2XcyifgOqeNdg0jfYCQZDZD';
            //Telefono del cliente
            
            //$telefono = "52".$cliente->telefono;
            //URL A DONDE SE MANDARA EL MENSAJE
            $url = 'https://graph.facebook.com/v17.0/101917919641657/messages';

            //CONFIGURACION DEL MENSAJE
            $mensaje = ''
                    . '{'
                    . '"messaging_product": "whatsapp", '
                    . '"to": "'.$telefono.'", '
                    . '"type": "template", '
                    . '"template": {'
                    . '    "name": "cliente_aprobado",'
                    . '    "language": { '
                    . '     "code": "es_MX"'
                    . '    },'
                    . '
                    }
                    }';



            //DECLARAMOS LAS CABECERAS
            $header = array("Authorization: Bearer " . $token, "Content-Type: application/json",);
            //INICIAMOS EL CURL
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            //OBTENEMOS LA RESPUESTA DEL ENVIO DE INFORMACION
            $response = json_decode(curl_exec($curl), true);
            //IMPRIMIMOS LA RESPUESTA 
            //print_r($response);
            //OBTENEMOS EL CODIGO DE LA RESPUESTA
            $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            //CERRAMOS EL CURL
            curl_close($curl);
    }

    private function enviarMensajeSolicitudRechazada($telefono, $idsoclicitud)
    {
        // ***************     Area de mensajes **********************
            //TOKEN QUE NOS DA FACEBOOK
            $token = 'EAADTQdf3uewBAFPzoi5in5hwB0lrGPDvmdK7i2j4kYbU4EonEZCq74KnMMVYnCIt1iDvONklkU6hFOHvtDW1782IPIZAdiLSeFZAJ6r8aYAzQtP6mNU9fdfvQZBZC2CgcZBMEGOSnDVHairOOmPeezA8FhJKXNV7L0tbZBlBoAtbbXuRdlhBxTFVYD2XcyifgOqeNdg0jfYCQZDZD';
            //Telefono del cliente
            
            //$telefono = "52".$cliente->telefono;
            //URL A DONDE SE MANDARA EL MENSAJE
            $url = 'https://graph.facebook.com/v17.0/101917919641657/messages';

            //CONFIGURACION DEL MENSAJE
            $mensaje = ''
                    . '{'
                    . '"messaging_product": "whatsapp", '
                    . '"to": "'.$telefono.'", '
                    . '"type": "template", '
                    . '"template": {'
                    . '    "name": "cliente_rechazado",'
                    . '    "language": { '
                    . '     "code": "es_MX"'
                    . '    },'
                    . '"components": [
                        {
                            "type": "button",
                            "sub_type": "url",
                            "index": "0",
                            "parameters": [
                            {
                                "type": "text",
                                "text": "'. $idsoclicitud .'"
                            }
                            ]
                        }
                        ]
                        }
                    }';



            //DECLARAMOS LAS CABECERAS
            $header = array("Authorization: Bearer " . $token, "Content-Type: application/json",);
            //INICIAMOS EL CURL
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            //OBTENEMOS LA RESPUESTA DEL ENVIO DE INFORMACION
            $response = json_decode(curl_exec($curl), true);
            //IMPRIMIMOS LA RESPUESTA 
            //print_r($response);
            //OBTENEMOS EL CODIGO DE LA RESPUESTA
            $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            //CERRAMOS EL CURL
            curl_close($curl);
            //return $response;
    }

    public function abr(Request $request)
    {
        $idsolicitud = $request->query('idsolicitud');
        $solicitud = Solicitude::find($idsolicitud);
        $solicitud->estado="En integracion";
        $solicitud->save();
        return redirect()->route('home');
    }

    public function calcularRetencionesYSeguro($monto, $convenio, $diaMes,$fechaInicio,$Meses,$Transaccion, $retenciones, $solicitude, $cliente)
    {
        $simulacion     = DB::connection('produccion')->select("
                CALL CREPAGCRECAMORPRO($monto,$convenio,30,'M','D',$diaMes,'$fechaInicio',$Meses,3001,20235,'S','N','N',0.0,'S',@a,@b,@c,@d,@e,@f,@g,1,184,'$fechaInicio','192.168.100.184','/microfin/catalogoCliente.htm',13,-$Transaccion)
            ");
            DB::disconnect('produccion');
            $cuotasMensuales = count($simulacion);
            $cuotasQuincenales = count($simulacion)*2;
            $Par_FechaInicio = $simulacion[0]->Par_FechaInicio;
            $Par_FechaVenc = $simulacion[0]->Par_FechaVenc;
            $MontoCuotaMensual = $simulacion[0]->MontoCuota;
            $MontoCuotaQuincenal = ($MontoCuotaMensual/2);
            $montoRetenciones = $retenciones*$MontoCuotaQuincenal;

            //Consultas a la base de datos del antiguo sacialianza
            $seguro     = DB::connection('produccion')->select("
                CALL CALCSEGUROINDVPRO(DATEDIFF('$Par_FechaVenc','$Par_FechaInicio'),$monto,3001,@a,'S',@b,@c,1,0,'1900-01-01', '','SolicitudCreditoDAO',0,0);
            ");
            DB::disconnect('produccion');

            $MontoSeguro = $seguro[0]->MontoSeguro;
            $consultaBuro = 30;             //Pago de la consulta a buró de crédito, de momento son 30 peso, pero puede cambiar
            $montoRecibir = ($monto)-($montoRetenciones+$MontoSeguro)-$consultaBuro;

            $solicitude->montoretenido=$montoRetenciones;
            $solicitude->coberturariesgo=$MontoSeguro;
            $solicitude->montorecibido=$montoRecibir;
            $solicitude->pagoplazo = $MontoCuotaQuincenal;
            $solicitude->save();

            $datos = array(
                'cuotasQuincenales' => $cuotasQuincenales,
                'cuotasMensuales' => $cuotasMensuales,
                'Par_FechaInicio' => $Par_FechaInicio,
                'Par_FechaVenc' => $Par_FechaVenc,
                'MontoCuotaMensual' => $MontoCuotaMensual,
                'MontoCuotaQuincenal' => $MontoCuotaQuincenal,
                'MontoSeguro' => $MontoSeguro,
                'Monto' => $monto,
                'retenciones' => $retenciones,
                'montoRetenciones' => $montoRetenciones,
                'montoRecibir' => $montoRecibir,
                'pagoConsultaBuro' => 30,


                'NombreCompleto' => strtoupper($cliente->nombre),
                'whatsapp' => $cliente->telefono,
                'cuantoGana' => $cliente->ingresoquincenal,
                'cuantoDisponible' => $cliente->disponiblequincenal,
                'ajustePasivos' => $cliente->ajuste,
                'pagoMinimo' => $solicitude->pagominimo,
                'porcentajePago' => 0.4,        //Porcentaje que estaba por defecto
                'pagoMaximo' => $solicitude->pagomaximo,
                'pagoQuincenal' => $solicitude->pagodeseado,
                'meses' => $solicitude->plazo,
                'creditoMaximo' => $solicitude->creditomaximo,
                'plazoCredito' => $solicitude->meses,
                'montoSolicitado' => $solicitude->prestamosolicitado,
                'diaPago' => 1,
                'fechaInicio' => date("Y-m-d"),
                //'button' => $request->button,
            );
            //Se supone que ajuste pasivo si lo toma de la vista
            //fecha de inicio lo dejamos así, aunque se supone lo debería 
            //Hacer el observer, pero lo dejamos así por si marca un día
            //Inhabil o algo así
            $solicitude->fechainicio = $datos['Par_FechaInicio'];
            $solicitude->fechavencimiento = $datos['Par_FechaVenc'];
            $solicitude->convenio = $cliente->convenio;
            $solicitude->save();
            //session(['datosSolicitud' => $datos]);
            return $datos;
    }

    public function llenarDatos($solicitud)
    {
        $cliente = Cliente::find($solicitude->idcliente);
        $datos = array(
            'cuotasQuincenales' => $solicitude->plazo*2,
            'cuotasMensuales' => $solicitude->plazo,
            'Par_FechaInicio' => $Par_FechaInicio,
            'Par_FechaVenc' => $Par_FechaVenc,
            'MontoCuotaMensual' => $MontoCuotaMensual,
            'MontoCuotaQuincenal' => $MontoCuotaQuincenal,
            'MontoSeguro' => $MontoSeguro,
            'Monto' => $monto,
            'retenciones' => $retenciones,
            'montoRetenciones' => $montoRetenciones,
            'montoRecibir' => $montoRecibir,
            'pagoConsultaBuro' => 30,


            'NombreCompleto' => strtoupper($cliente->nombre),
            'whatsapp' => $cliente->telefono,
            'cuantoGana' => $cliente->ingresoquincenal,
            'cuantoDisponible' => $cliente->disponiblequincenal,
            'ajustePasivos' => $cliente->ajuste,
            'pagoMinimo' => $solicitude->pagominimo,
            'porcentajePago' => 0.4,        //Porcentaje que estaba por defecto
            'pagoMaximo' => $solicitude->pagomaximo,
            'pagoQuincenal' => $solicitude->pagodeseado,
            'meses' => $solicitude->plazo,
            'creditoMaximo' => $solicitude->creditomaximo,
            'plazoCredito' => $solicitude->meses,
            'montoSolicitado' => $solicitude->prestamosolicitado,
            'diaPago' => 1,
            'fechaInicio' => date("Y-m-d"),
            //'button' => $request->button,
        );
        //Se supone que ajuste pasivo si lo toma de la vista
        //fecha de inicio lo dejamos así, aunque se supone lo debería 
        //Hacer el observer, pero lo dejamos así por si marca un día
        //Inhabil o algo así
        $solicitude->fechainicio = $datos['Par_FechaInicio'];
        $solicitude->fechavencimiento = $datos['Par_FechaVenc'];
        $solicitude->convenio = $cliente->convenio;
        return $datos;
    }

    public function imprimirPDF($solicitud)
    {
        $solicitude = Solicitude::find($solicitud);
        $cliente = Cliente::find($solicitude->idcliente);
        $monto = $solicitude->prestamosolcitado;
        $Meses = $solicitude->plazo;
        $fecha = date_create($solicitude->fechainicio);
        $pdf = PDF::loadView('imprimir', ['cliente' => $cliente, 'solicitude'=> $solicitude]);
        //return view('imprimir', ['cliente' => $cliente, 'solicitude'=> $solicitude]);
        $nombrepdf=strtoupper($cliente->nombre).'$'.number_format($monto, 2, '.', ',').$Meses.'Meses['.date_format($fecha,"d-m-Y").'].pdf';
        $descarga = $pdf->download($nombrepdf);
        $contenido = $descarga->getOriginalContent();
        $ruta = "files/".$cliente->id."/solicitudes/".$solicitude->id.'.pdf';
        Storage::put($ruta, $contenido);
        return $descarga;
    }

    private function mandarCorreo($solicitude)
    {
        $cliente = Cliente::find($solicitude->idcliente);
        $datosCorreo = [
            'idcliente' => $cliente->id,
            'idsolicitud' =>$solicitude->id,
        ];
        $mailCliente = Auth::user();
        Mail::to($mailCliente)->send(new NuevaSolicitud($datosCorreo));
    }
}
