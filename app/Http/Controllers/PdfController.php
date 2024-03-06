<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PdfController extends Controller
{
    //
    public function imprimirDatosSolicitud()
    {
        $pdf = PDF::loadView('imprimir', ['datos' => $datos]);
        return $pdf->download(strtoupper($cliente->nombre).' $'.number_format($monto, 2, '.', ',').' '.$Meses. ' Meses ['.date("H:i:s").'].pdf');
    }
}
