<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitude;
use App\Models\Cliente;

class Webhook extends Controller
{
    public function prueba(Request $request)
    {

        $mode = $request->hub_mode;
        $challenge = $request->hub_challenge;
        $token = $request->hub_verify_token;
        echo $challenge;
        $mensaje = $request->input('entry.0.changes.0.value.messages');
        //error_log(var_dump($mensaje));
        $mensajeRespondido = $request->input("entry.0.changes.0.value.messages.0.button.text");
        $telefonoCliente = $request->input("entry.0.changes.0.value.messages.0.from");
        $estadoMensaje=$request->input('entry.0.changes.0.value.statuses.0.status');
        error_log($estadoMensaje);
        error_log($mensajeRespondido);
        try
        {
            $diferenciadigitos = strlen($telefonoCliente)-10;
            $nuevoNum = substr($telefonoCliente, $diferenciadigitos, 10);
            $clientes = Cliente::where('telefono',$nuevoNum)->get();
            if($mensajeRespondido=="Quiero mi recibo")
            {
                error_log(($clientes));
                foreach ($clientes as $cliente) 
                {
                    error_log("Cliente ".$cliente->id);
                    $solicitude = Solicitude::where('idcliente',$cliente->id)->first();
                    if(isset($solicitude))
                    {
                        error_log("Solicitud ".$solicitude->id);
                        $response = [
                            'clientes' => array($cliente),
                            'solicitudes' => array($solicitude)
                        ]; 
                        self::mandarPDF($telefonoCliente, $solicitude);
                    }
                    else
                    {
                        error_log("El cliente ".$cliente->nombre." no tiene solicitudes registradas");
                        $response = 
                        [
                            'cliente' => $cliente,
                            'solicitud' =>null,
                        ];
                    }
                }
            }
            else
            {
                if($estadoMensaje=="read"||$estadoMensaje=="delivered"||$estadoMensaje=="sent")
                {
                    error_log('No se respondió el mensaje');
                }
                $response = 
                [
                    'success' => true,
                    'mensaje' => $request->all(),
                ];
            }
        }
        catch(Exception $e)
        {
            error_log("Error mortal, pero no se que es xd");
            $response=
            [
                'success' => false,
                'error' => $e,
            ];
        }

        
        return $response;

    }

    public function feik(Request $request)
    {

        $mode = $request->hub_mode;
        $challenge = $request->hub_challenge;
        $token = $request->hub_verify_token;
        echo $challenge;
    }

    private function mandarPDF($telefono, $solicitude)
    {
        $telefono;
        error_log($telefono);
        //$ruta = "https://convenio.opcionessacimex.com/storage/public/files/".$solicitude->idcliente."/solicitudes/".$solicitude->id.".pdf";
        $ruta = "https://4585-187-217-222-19.ngrok-free.app/storage/files/".$solicitude->idcliente."/solicitudes/".$solicitude->id.".pdf";
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
                    . '"recipient_type": "individual", '
                    . '"type": "document",'
                    . '"document": {'
                        . '"link": "'.$ruta.'",'
                        . '"filename" : "Detalle.pdf"'
                        .'}'
                    .'}';



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
            //error_log($response);
            //OBTENEMOS EL CODIGO DE LA RESPUESTA
            $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            //CERRAMOS EL CURL
            curl_close($curl);
    }

}
