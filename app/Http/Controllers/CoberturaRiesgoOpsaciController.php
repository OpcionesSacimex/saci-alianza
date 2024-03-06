<?php

namespace App\Http\Controllers;

use App\Models\CoberturaRiesgoOpsaci;
use Illuminate\Http\Request;

class CoberturaRiesgoOpsaciController extends Controller
{
    //
    public function getValue($days)
    {
        //return $days;
        $cobertura = CoberturaRiesgoOpsaci::find($days); 
        if($cobertura==null){
            $data = [
                "Message" => "Valor inesperado HDPSM"
            ];
        } else{
            $data = [
                "value" => $cobertura->valor*$cobertura->porcentaje,
            ];
        }
        return response()->json($data);
    }
}
