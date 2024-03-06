<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conyuge;
use App\Models\Cliente;
use App\Models\User;
use App\Models\PLD;
use App\Models\Domicilio;
use App\Models\ReferenciaPersonal;
use App\Models\Beneficiario;
use App\Models\DatosLaborales;
use DateTime;
use Illuminate\Support\Facades\Auth;

class VisitaDomiciliarController extends Controller
{
    public function index()
    {
        $cliente = Cliente::where('user_id',Auth::id())->first();
        $domicilio = Domicilio::where('idcliente',$cliente->id)->first();
        $datosLaborales = DatosLaborales::where('idcliente',$cliente->id)->first();
        $datosConyuge = Conyuge::where('idcliente',$cliente->id)->first();
        $referencias = ReferenciaPersonal::where('idcliente',$cliente->id);
        $referenciaPRO = $referencias->get();
        $beneficiario = Beneficiario::where('idcliente',$cliente->id)->first();
        $pld = PLD::where('idcliente',$cliente->id)->first();
        if(is_null($domicilio))
        {
            $domicilio = new Domicilio();
            $domicilio->idcliente = $cliente->id;
        }
        if(is_null($datosLaborales))
        {
            $datosLaborales = new DatosLaborales();
            $datosLaborales->idcliente = $cliente->id;
        }
        if(is_null($datosConyuge))
        {
            $datosConyuge = new Conyuge();
            $datosConyuge->idcliente = $cliente->id;
        }
        if(is_null($referencias)||$referencias->count()<1)
        {
            $referencia = new ReferenciaPersonal();
            $referencia->idcliente = $cliente->id;
            $referencia2 = new ReferenciaPersonal();
            $referencia2->idcliente = $cliente->id;
        }else
        {
            if(($referencias->count())>1)
            {
                $referencia = $referencias->first();
                $referencia2 = $referenciaPRO[1];
            }
            elseif(($referencias->count())<=1)
            {
                $referencia = $referencias->first();
                $referencia2 = new ReferenciaPersonal();
                $referencia2->idcliente = $cliente->id;
            }
        }
        if(is_null($beneficiario))
        {
            $beneficiario = new Beneficiario();
            $beneficiario->idcliente = $cliente->id;
        }
        if(is_null($pld))
        {
            $pld = new PLD();
            $pld->idcliente = $cliente->id;
        }
        $estadosRepublica = [
            "Aguascalientes" => "Aguascalientes",
            "Baja California" => "Baja California",
            "Baja California Sur" => "Baja California Sur",
            "Campeche" => "Campeche",
            "Chiapas" => "Chiapas",
            "Chihuahua" => "Chihuahua",
            "Coahuila" => "Coahuila",
            "Colima" => "Colima",
            "Ciudad de México" => "Ciudad de México",
            "Durango" => "Durango",
            "Estado de México" => "Estado de México",
            "Guanajuato" => "Guanajuato",
            "Guerrero" => "Guerrero",
            "Hidalgo" => "Hidalgo",
            "Jalisco" => "Jalisco",
            "Michoacan" => "Michoacan",
            "Morelos" => "Morelos",
            "Nayarit" => "Nayarit",
            "Nuevo León" => "Nuevo León",
            "Oaxaca" => "Oaxaca",
            "Puebla" => "Puebla",
            "Querétaro" => "Querétaro",
            "Quintana Roo" => "Quintana Roo",
            "San Luis Potosí" => "San Luis Potosí",
            "Sinaloa" => "Sinaloa",
            "Sonora" => "Sonora",
            "Guerrero" => "Guerrero",
            "Tabasco" => "Tabasco",
            "Tamaulipas" => "Tamaulipas",
            "Tlaxcala" => "Tlaxcala",
            "Veracruz" => "Veracruz",
            "Yucatán" => "Yucatán",
        ];
        $regimenMatrimonial =[
            "Bienes mancomunados" => "Bienes mancomunados",
            "Unión Libre" => "Unión Libre",
            "Bienes separados" => "Bienes separados"
        ];
        $destino = [
            "Comercial" => "Comercial",
            "Consumo" => "Consumo",
            "Vivienda" => "Vivienda"
        ];
        return view('VisitaDomiciliar')->with('cliente',$cliente)
                                       ->with('estados', $estadosRepublica)
                                       ->with('domicilio',$domicilio)
                                       ->with('laborales',$datosLaborales)
                                       ->with('conyuge', $datosConyuge)
                                       ->with('regimen',$regimenMatrimonial)
                                       ->with('destino',$destino)
                                       ->with('beneficiario',$beneficiario)
                                       ->with('referencias', $referencias)
                                       ->with('referencia', $referencia)
                                       ->with('referencia2', $referencia2)
                                       ->with('pld', $pld);
    }

    public function guardarDatos(Request $request)
    {
        $cliente = Cliente::where('user_id',Auth::id())->first();
        $fechanacimiento = $request->input('fechanacimiento');
        $estadocivil = $request->input('estadocivil');
        $entidadNacimiento = $request->input('entidadnacimiento');
        $sexo = $request->input('gender');
        $escolaridad = $request->input('escolaridad');
        $tipoVivienda = $request->input('tipovivienda');
        $dob = new DateTime($fechanacimiento);
        $today = new DateTime('today');
        $edad = $dob->diff($today)->y;
        $cliente->fechanacimiento = $fechanacimiento;
        $cliente->estadocivil = $estadocivil;
        $cliente->entidadnacimiento = $entidadNacimiento;
        $cliente->sexo = $sexo;
        $cliente->escolaridad = $escolaridad;
        $cliente->tipovivienda = $tipoVivienda;
        $cliente->edad = $edad;
        $cliente->save();
        $domicilio = Domicilio::where('idcliente',$cliente->id)->first();
        if(is_null($domicilio))
        {
            $domicilio = Domicilio::create($request->all());
        }
        else
        {
            $domicilio->idcliente = $cliente->id;
            $domicilio->update($request->all());
        }
        self::guardarLaborales($request);
        self::guardarConyuge($request);
        self::guardarReferencias($request);
        self::guardarBeneficiario($request);
        self::guardarPLD($request);
        return redirect('visitadomiciliar');
    }

    public function guardarLaborales(Request $request)
    {
        $datosLaborales = DatosLaborales::where('idcliente',$request->input('idcliente'))->first();
        if(is_null($datosLaborales))
        {
            $datosLaborales = new DatosLaborales();
            $datosLaborales->idcliente = $request->input('idcliente');
            $datosLaborales->create($request->all());
        }
        else
        {
            $datosLaborales->update($request->all());
        }
    }

    public function guardarConyuge(Request $request)
    {
        $datosConyuge = Conyuge::where('idcliente',$request->idcliente)->first();
        if(is_null($datosConyuge))
        {
            $datosConyuge = new Conyuge();
            $datosConyuge->idcliente = $request->input('idcliente');
            $datosConyuge->create($request->all());
        }
        else
        {
            $datosConyuge->update($request->all());
        }
    }

    public function guardarReferencias(Request $request)
    {
        $referencias = ReferenciaPersonal::where('idcliente',$request->input('idcliente'));
        $referenciaPRO = $referencias->get();
        if(is_null($referencias)||$referencias->count()<1)
        {
            $referencia = new ReferenciaPersonal();
            $referencia->create($request->all());
            /*
            $referencia = new ReferenciaPersonal();
            $referencia->nombrecompletoreferencia = $request->input('nombrecompletoreferencia');
            $referencia->domicilioreferencia = $request->input('domicilioreferencia');
            $referencia->telefonoreferencia = $request->input('telefonoreferencia');
            $referencia->tiporelacion = $request->input('tiporelacion');
            $referencia->idcliente = $request->inpu('idcliente');
            $referencia->save();
            */
            $referencia2 = new ReferenciaPersonal();
            $referencia2->nombrecompletoreferencia = $request->input('nombrecompletoreferencia2');
            $referencia2->domicilioreferencia = $request->input('domicilioreferencia2');
            $referencia2->telefonoreferencia = $request->input('telefonoreferencia2');
            $referencia2->tiporelacion = $request->input('tiporelacion2');
            $referencia2->idcliente = $request->input('idcliente');
            $referencia2->save();
        }
        else
        {
            if($referencias->count()<=1)
            {
                $referencia = $referencias->first();
                $referencia->update($request->all());

                $referencia2 = new ReferenciaPersonal();
                $referencia2->nombrecompletoreferencia = $request->input('nombrecompletoreferencia2');
                $referencia2->domicilioreferencia = $request->input('domicilioreferencia2');
                $referencia2->telefonoreferencia = $request->input('telefonoreferencia2');
                $referencia2->tiporelacion = $request->input('tiporelacion2');
                $referencia2->idcliente = $request->input('idcliente');
                $referencia2->save();
            }
            elseif(($referencias->count())>1)
            {
                $referencia = $referencias->first();
                $referencia->update($request->all());

                $referencia2 = $referenciaPRO[1];
                $referencia2->nombrecompletoreferencia = $request->input('nombrecompletoreferencia2');
                $referencia2->domicilioreferencia = $request->input('domicilioreferencia2');
                $referencia2->telefonoreferencia = $request->input('telefonoreferencia2');
                $referencia2->tiporelacion = $request->input('tiporelacion2');
                $referencia2->idcliente = $request->input('idcliente');
                $referencia2->save();   
            }
        }
    }

    public function guardarBeneficiario(Request $request)
    {
        $beneficiario = Beneficiario::where('idcliente',$request->input('idcliente'))->first();
        if(is_null($beneficiario))
        {
            $beneficiario = new Beneficiario();
        }
        $beneficiario->nombrecompleto=$request->input('nombrecompletobeneficiario');
        $beneficiario->fechanacimiento = $request->input('fechanacimientobeneficiario');
        $beneficiario->destino = $request->input('destino');
        $beneficiario->proyecto = $request->input('proyecto');
        $beneficiario->monto = $request->input('monto');
        $beneficiario->plazo = $request->input('plazo');
        $beneficiario->sueldo = $request->input('sueldo');
        $beneficiario->gastos = $request->input('gastos');
        $beneficiario->idcliente = $request->input('idcliente');
        $beneficiario->save();
    }

    public function guardarPLD(Request $request)
    {
        $pld = PLD::where('idcliente', $request->input('idcliente'))->first();
        if(is_null($pld))
        {
            $pld = PLD::create($request->all());
        }
        else
        {
            $pld->update($request->all());
        }
    }


}
