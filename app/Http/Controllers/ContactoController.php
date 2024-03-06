<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Solicitude;
use App\Models\User;
use App\Models\Comunicacion;
use Illuminate\Support\Facades\Auth;

class ContactoController extends Controller
{
    public function index()
    {
        $error = "";
        $cliente = Cliente::where('user_id',Auth::id())->first();
        $solicitud = Solicitude::where('idcliente',$cliente->id)->first();
        $solicitud->estado="En proceso";
        $solicitud->save();
        return view('solicitude.contacto')->with('error',$error);
    }

    public function metodo(Request $request)
    {
        $wa = $request->input('whatsapp');
        $llamada = $request->input('llamada');
        $sms = $request->input('sms');
        $metodoContacto = "";
        if(!is_null($wa)) $metodoContacto.="Whatsapp ";
        if(!is_null($llamada)) $metodoContacto.= "Llamada ";
        if(!is_null($sms)) $metodoContacto.= "SMS ";
        $cliente = Cliente::where('user_id',Auth::id())->first();
        $comunicacion = Comunicacion::where('idcliente',$cliente->id)->first();
        $solicitud = Solicitude::where('idcliente',$cliente->id)->first();
        $solicitud->estado="En proceso";
        $solicitud->save();
        $comunicacion->metodocomunicacion = $metodoContacto;
        $comunicacion->save();
        //$cliente->metodocomunicacion = $metodoContacto;
        //$cliente->save();
        if(str_contains($metodoContacto, "Whatsapp"))
        {
            $telefono = '52'.$cliente->telefono;
            $this->enviarMensajeConfirmacionNumero($telefono, $comunicacion->codigoverificacion);
            return redirect()->route('confirmarTelefono');
        } else
        {
            return redirect()->route('file-upload');
        }
    }

    private function enviarMensajeConfirmacionNumero($telefono, $numeroConfirmacion)
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
                    . '    "name": "verificacion",'
                    . '    "language": { '
                    . '     "code": "es_MX"'
                    . '    },'
                    . '"components": [
                        {
                            "type": "body",
                            "parameters": [
                            {
                                "type": "text",
                                "text": "'.$numeroConfirmacion.'"
                            },
                            ]
                        },
                        {
                            "type": "button",
                            "sub_type": "url",
                            "index": "0",
                            "parameters": [
                            {
                                "type": "text",
                                "text": "'. $numeroConfirmacion .'"
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
    }
}
