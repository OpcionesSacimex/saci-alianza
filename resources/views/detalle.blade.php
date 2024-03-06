@extends('layouts.app')
@section('content')
<link href="{{asset('css/resultados.css')}}" rel="stylesheet">
<link href="{{ asset('img/SacimexImagotipo.png') }}" rel="icon">
<title>Resultados de crédito</title>
<style>
    @font-face {
        font-family: 'Presidencia Fina';
        src: url('{{asset('fonts/PresidenciaFina.otf')}}') format('opentype');
    }

    @font-face {
        font-family: 'Presidencia Firme';
        src: url('{{asset('fonts/PresidenciaFirme.otf')}}') format('opentype');
    }
</style>
@php
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    use App\Models\Cliente;
    use App\Models\Documentoscliente;
    use App\Models\Convenios;
    use App\Models\Comunicacion;
@endphp


<section>
    <script src="https://kit.fontawesome.com/56eee1d2a7.js" crossorigin="anonymous"></script>
<a href="#" onclick="window.history.back()" class="kITrbH"><i class="fa-solid fa-arrow-left"></i><span>Volver</span></a>
@php
    $usuario = User::find(Auth::id());
    $cliente = Cliente::find($solicitude->idcliente);
    $convenio = Convenios::find($cliente->convenio);
    $retenciones = $convenio->retenciones;
    if(($solicitude->plazo<=6) && ($solicitude->plazo>3)) $retenciones =2;
    elseif($solicitude->plazo==3) $retenciones=1;
@endphp
    @if ($usuario->tipo=="Admin"||$usuario->tipo=="Aliado"||$usuario->tipo=="Asesor")
        <h3>Cliente: {{$cliente->nombre}}</h3>
    @endif
  <h1>Detalles del crédito.</h1>
       <div class="cuadro-contenedor">
           <div class="info-contenedor">
               <p>Monto total</p>
               <h2>$ {{ number_format($solicitude->prestamosolicitado, 2, '.', ',') }}</h2>
           </div>
           <div class="info-contenedor">
               <p>A un plazo de</p>
               <h3>{{ $solicitude->plazo*2 }} quincenas / {{ $solicitude->plazo }} meses</h3>
           </div>
           <div class="border"></div>
               <div class="info-contenedor-doble">
                @php

                    $terminacion = "";
                    if($retenciones>1) $terminacion="s";
                @endphp
                   <p>{{ $retenciones }} pago{{$terminacion}} retenido{{$terminacion}}:</p>
                   <h3>$ {{ number_format($retenciones*$solicitude->pagoplazo, 2, '.', ',') }}</h3>
               </div>
               <div class="info-contenedor-doble">
                   <div class="tooltip">
                       <span class="question-mark"><img src="{{asset('img/QuestionMark.png')}}"/></span>
                       <span class="tooltip-text">La cobertura de riesgo es un seguro de saldo deudor y gasto funerario.</span>
                   </div>
                   <p>Cobertura de riesgo:</p>
                   <h3>$ {{ number_format($solicitude->coberturariesgo, 2, '.', ',') }}</h3>
               </div>
               <div class="info-contenedor-doble">
                <p>Consulta de buró de crédito:</p>
                <h3>$ {{ number_format(30, 2, '.', ',') }}</h3>
            </div>
           <div class="border"></div>
           <div class="info-contenedor">
               <p>Recibes</p>
               <h2>$ {{ number_format($solicitude->montorecibido, 2, '.', ',') }}</h2>
           </div>
           <div class="info-contenedor-doble">
               <p>Pagando quincenalmente</p>
               <h3>$ {{ number_format($solicitude->pagoplazo, 2, '.', ',') }}</h3>
           </div>
       </div>


        @php
            $user = User::find(Auth::id());
            $documentos = Documentoscliente::where('idcliente',$solicitude->idcliente)->get();
            $comunicacion = Comunicacion::where('idcliente',$cliente->id)->first();
            if(count($documentos)==0) $documentosOK = false;
            else {
                $documentosOK = true;
            }

            foreach ($documentos as $documento) {
                if($documento->estado!="Aprobado")
                {
                    $documentosOK = false;
                    break;
                }
            }
        @endphp
        @if ($user->tipo=="Admin")
            @if (($documentosOK))
                <p>Los documentos ya han sido aprobados, puede pasar a la etapa de integración</p>
                <form action="{{ route('solicitudes.update',$solicitude->id) }}" method="POST">
                    {{ method_field('PATCH') }}
                    @csrf
                    <input name="estado" type="hidden"  value="En integracion" />
                    <button type="submit" class="boton btn btn-danger btn-sm"> {{ __('A integración') }}</button>
                </form>
            @endif
            <a class="boton" href="{{route('file-upload',['idcliente' => $cliente->id])}}">Ver archivos</a>
            
                {{ method_field('PATCH') }}
                @csrf
                
                <a class="boton" href="{{route('clientes.create',['idsolicitud' => $solicitude->id])}}">Modificar</a>
                      
        @endif
        <div class="boton-contenedor">
            <div class="tooltip-left">
                <span class="question-mark"><img src="{{asset('img/QuestionMark.png')}}"/></span>
                <span class="tooltip-text-left">Si lo prefieres, puedes guardar tu solicitud sin enviarla para poder editarla en el futuro.</span>
            </div>

            <a class="boton guardar"  href="{{ route('home') }}">Guardar Solicitud</a>
            @if ($user->tipo=="Cliente")
                <a class="boton"  href="{{ route('clientes.create') }}">Editar</a>
            @endif
 
        @if ($user->tipo=="Cliente")
                @if ($solicitude->estado=="Modificada")
                    <form action="{{ route('solicitudes.update',$solicitude->id) }}" method="POST">
                        {{ method_field('PATCH') }}
                        @csrf
                        <input name="estado" type="hidden"  value="En proceso" />
                        <button type="submit" class="boton btn btn-succes btn-sm" onclick="window.location.href='/imprimirPDF/{{$solicitude->id}}'"> {{ __('Aceptar cambios') }}</button>
                    </form>
                @else


                    @if ($comunicacion->verificado)
                        <form action="{{ route('solicitudes.update',$solicitude->id) }}" method="POST">
                            {{ method_field('PATCH') }}
                            @csrf
                            <input name="estado" type="hidden"  value="En proceso" />
                            <button type="submit" class="boton btn btn-succes btn-sm" onclick="window.location.href='/imprimirPDF/{{$solicitude->id}}'"> {{ __('Enviar') }}</button>
                        </form>
                    @else
                        <a class="boton" 
                        
                        @if ($cliente->convenio==10)
                            href="{{ route('contacto') }}"
                        @else
                            @if (!$comunicacion->verificado)
                                href="{{ route('contacto') }}"
                            @endif
                        @endif
                        
                        >Enviar</a>
                    @endif


                @endif
        @endif
        </div>
</section>
<script>
    document.addEventListener('load',()=>{
        window.open("/imprimirPDF/{{$solicitude->id}}");
    });
</script>
@endsection
