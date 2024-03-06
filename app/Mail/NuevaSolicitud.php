<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NuevaSolicitud extends Mailable
{
    use Queueable, SerializesModels;

    public $datos;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datos)
    {
        //
        $this->datos=$datos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $idcliente = $this->datos['idcliente'];
        $idsolicitud = $this->datos['idsolicitud'];
        //Comentar-des Comentar según si sea en producción o no. La ruta cambia parece que así esta bien
        //return $this->subject('Solicitud de crédito registrada')->view('emails.nuevaSolicitud')->attachFromStorage('files/'.$idcliente.'/solicitudes/'.$idsolicitud.'.pdf');
        return $this->subject('Solicitud de crédito registrada')->markdown('emails.nuevaSolicitud')->attachFromStorage('files/'.$idcliente.'/solicitudes/'.$idsolicitud.'.pdf');
    }
}
