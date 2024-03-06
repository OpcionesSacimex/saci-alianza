<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Solicitude;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $data = $request->session()->all();
        $usuario = $request->session()->get('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d');
        $cliente = Cliente::where('user_id',$usuario)->first();
        if(is_null($cliente))
        {
            return redirect()->action([ClienteController::class, 'create']);   
        }else
        {
            $solicitudes = Solicitude::where('idcliente',$cliente->id)->paginate();
            if(sizeof($solicitudes)<1)
            {
                return redirect()->action([ClienteController::class, 'create']);
                return redirect()->action([SolicitudeController::class, 'create']);
            }
            else{
                /*
                $solicitude = $solicitudes->first();
                return redirect()->route('solicitudes.show',$solicitude->id);
                */
                return view('general', compact('solicitudes'))
                ->with('i', (request()->input('page', 1) - 1) * $solicitudes->perPage());
            }
            //return strval($solicitudes);
            
            
            //return view('general')->with('solicitudes' , $solicitudes);
        }
        //return $value;
        return view('home');
        //return redirect()->action([ClienteController::class, 'index']);
    }

    public function fechaHoraActual()
    {
        return date('D M j Y G:i:s');
    }
}
