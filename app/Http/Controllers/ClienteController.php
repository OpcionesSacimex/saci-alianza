<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use App\Models\InformacionFinanciera;
use App\Models\Comunicacion;
use Illuminate\Http\Request;
use App\Models\Convenios;
use App\Models\Solicitude;
use Illuminate\Support\Facades\Auth;

/**
 * Class ClienteController
 * @package App\Http\Controllers
 */
class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $usuario = User::find(Auth::id());
        $convenioUsuario = Convenios::where('nombreCorto',$usuario->convenio)->first();
        if($usuario->tipo=="Aliado"||$usuario->tipo=="Asesor")
        {
            $clientes = Cliente::where('convenio',$convenioUsuario->id)->paginate();
        }
        else if ($usuario->tipo=="Admin")
        {
            $clientes = Cliente::paginate();
        }
        else
        {
            return redirect()->route('home');
        }

        return view('cliente.index', compact('clientes'))
            ->with('i', (request()->input('page', 1) - 1) * $clientes->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $idsolicitud = $request->query('idsolicitud');
        $solicitud = Solicitude::find($idsolicitud);
        if(!is_null($solicitud))
        {
            $cliente = Cliente::find($solicitud->idcliente);
            $usuario = User::find($cliente->user_id);
            $convenio = Convenios::where('nombreCorto',$usuario->convenio)->first();
            $iduser = $usuario->id;
        } else
        {
            $iduser = $request->session()->get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
            $usuario = User::find($iduser);
            $cliente = Cliente::where('user_id',$iduser)->first();
            $convenio = Convenios::where('nombreCorto',$usuario->convenio)->first();
        }
        
        if(is_null($cliente)){
            $cliente = new Cliente();
            $cliente->nombre="";
            $cliente->telefono="";
        }
        else
        {
            $datosFinancieros = InformacionFinanciera::where('idcliente',$cliente->id)->first();
            $comunicacion = Comunicacion::where('idcliente',$cliente->id)->first();
        }
        return view('cliente.datosCliente', compact('cliente'))->with('usuario',$iduser)
               ->with('cliente',$cliente)
               ->with('convenio', $convenio)
               ->with('datosFinancieros', $datosFinancieros)
               ->with('comunicacion', $comunicacion);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Debido a que se cuenta con un solo formulario para registrar tanto clientes como solicitudes, 
        //Por este metodo pasan también las solicitudes
        //area donde se procesa la solicitud
        $creditoMaximo=$request->input('creditomaximo');
        if($creditoMaximo!=0||!is_null($creditoMaximo)||$creditoMaximo!="")
        {


            $solicitud = Solicitude::where('idcliente',$request->input('idcliente'))->first();
            if(is_null($solicitud))
            {
                $resultado = (new SolicitudeController)->store($request);
                
            } else
            {
                //return var_dump($solicitud);
                $resultado = (new SolicitudeController)->update($request,$solicitud);
            }
            return $resultado;
            /*
            $solicitud = new Solicitude();
            $solicitud->pagominimo=$request->input('pagominimo');
            $solicitud->pagomaximo=$request->input('pagomaximo');
            $solicitud->pagodeseado=$request->input('pagodeseado');
            $solicitud->plazo=$request->input('plazo');
            $solicitud->creditomaximo=$request->input('creditomaximo');
            $solicitud->prestamosolicitado=$request->input('prestamosolicitado');
            $solicitud->estado='En proceso';
            $solicitud->idcliente=$request->input('idcliente');
            $solicitud->save();
            $idsolicitud = $solicitud->id;
            return redirect()->route('solicitudes.show',$solicitud->id);
            return redirect()->route('home');
            */
        }
        $ingresoquincenal = $request->input('ingresoquincenal');
        $iduser = $request->session()->get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
        //Area donde se procesan los datos del cliente
        if($request->input('idcliente')!==""&&!is_null($request->input('idcliente')))
        {
            $cliente = Cliente::find($request->input('idcliente'));
            request()->validate(Cliente::$rules);
            $cliente->update($request->all());
            //Area para modificar datos financieros
            $infoFinanciera = InformacionFinanciera::where('idcliente',$cliente->id)->first();
            $infoFinanciera->ingresoquincenal = $request->input('ingresoquincenal');
            $infoFinanciera->disponiblequincenal = $request->input('disponiblequincenal');
            $infoFinanciera->ajuste = $request->input('ajuste');
            $infoFinanciera->save();
            $comunicacion = Comunicacion::where('idcliente',$cliente->id)->first();
            $comunicacion->codigoverificacion = $request->input('confirmaciontelefono'); //pendiente
            $comunicacion->save();
            
        } else
        {
            request()->validate(Cliente::$rules);
            $cliente = Cliente::create($request->all());
            $usuario = User::find($iduser);
            $usuario->name=$cliente->nombre;
            $usuario->save();
            $infoFinanciera = new InformacionFinanciera();
            $infoFinanciera->ingresoquincenal = $request->input('ingresoquincenal');
            $infoFinanciera->disponiblequincenal = $request->input('disponiblequincenal');
            $infoFinanciera->ajuste = $request->input('ajuste');
            $infoFinanciera->idcliente = $cliente->id;
            $infoFinanciera->save();
            $comunicacion = new Comunicacion();
            $comunicacion->codigoverificacion = $request->input('confirmaciontelefono'); //pendiente
            $comunicacion->idcliente = $cliente->id;
            $comunicacion->save();
        }
        


        $numeroConfirmacion = $request->input('confirmaciontelefono');
        $telefono = "52".$cliente->telefono;

        
        //$cliente = new Cliente();
        /*
        if($ingresoquincenal==""||is_null($ingresoquincenal)||$ingresoquincenal=0)
        {
            request()->validate(Cliente::$rules);
            $cliente = Cliente::create($request->all());
            $usuario = User::find($iduser);
            $usuario->name=$cliente->nombre;
            $usuario->save();


            $numeroConfirmacion = $request->input('confirmaciontelefono');
            $telefono = "52".$cliente->telefono;
            //$this->enviarMensajeConfirmacionNumero($telefono, $numeroConfirmacion);
            return redirect()->route('confirmarTelefono');
        }else{
            $cliente = Cliente::where('user_id',$iduser)->first();
            $cliente->ingresoquincenal = $request->input('ingresoquincenal');
            $cliente->disponiblequincenal = $request->input('disponiblequincenal');
            $cliente->ajuste = $request->input('ajuste');
            $cliente->convenio = $request->input('convenio');
            $cliente->save();
            return redirect()->route('home');
        }
        */
        
        
        return $cliente->id;
        return redirect()->route('home');
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente created successfully.');
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Cliente::find($id);
        $usuario = User::find(Auth::id());
        if ($usuario->tipo=="Admin")
        {
            return view('cliente.show', compact('cliente'));
        }
        elseif($usuario->tipo=="Aliado")
        {
            $convenioUsuario = Convenios::where('nombreCorto', strtoupper($usuario->convenio))->first();
            if($cliente->convenio==$convenioUsuario->id)
            {
                return view('cliente.show', compact('cliente'));
            }
            else
            {
                return redirect()->route('home');
            }
        }
        else
        {
            return redirect()->route('home');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = Cliente::find($id);

        return view('cliente.edit', compact('cliente'))->with('userid',$cliente->user_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Cliente $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $estado = $request->input('estado');
        if($estado != ""|| !is_null($estado))
        {
            $clienteN = Cliente::find($cliente->id);
            $clienteN->estado = $estado;
            $clienteN->save();
        }else{
            request()->validate(Cliente::$rules);

            $cliente->update($request->all());
        }
        

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id)->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente deleted successfully');
    }
}
