@extends('layouts.app')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/input-styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sacialianza.css') }}" rel="stylesheet">
    <link href="{{ asset('img/SacimexImagotipo.png') }}" rel="icon">
    <title>SaciAlianza</title>
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
</head>
<body>
    <!-- LOGO -->
    @section('content')
    <script src="https://kit.fontawesome.com/56eee1d2a7.js" crossorigin="anonymous"></script>
    <section>
    <a href="#" onclick="window.history.back()" class="kITrbH"><i class="fa-solid fa-arrow-left"></i><span>Volver</span></a>
        <div class="titulo-contenedor">
            <p id="titulo-paso" class="titulo">Paso 1. Ingrese sus datos personales.</p>
            <div id="contenedor-form" class="form-contenedor">
                <form id="formulario" action="{{route('clientes.store')}}" method="POST" autocomplete="off">
                    @csrf
                    <div class="pasos-contenedor">
                        <!-- PASO 1 -->
                        <div class="paso">
                            {{Form::hidden('user_id',$usuario)}}
                            {{Form::hidden('ajuste', "0")}}
                            {{Form::hidden('convenio', $convenio->id)}}
                            @php
                                $caracteres = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
                                $totalCaracteres = strlen($caracteres);
                                $codigoVerificacion = '';
                                for ($i=0; $i < 4; $i++) { 
                                    $codigoVerificacion .= $caracteres[random_int(0, $totalCaracteres - 1)];
                                }
                            @endphp
                            {{Form::hidden('confirmaciontelefono', $codigoVerificacion)}}
                            <p class="d-none" id="paso"></p>
                            <div class="inp-contenedor">
                                <input type="text" id="nombre" name="nombre" value="{{ $cliente->nombre }}" class="inp sa" tabindex="-1" required>
                                <label for="nombre" class="etq">Nombre completo</label>
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span class="bar sa"></span>
                                <p id="alerta-nombre" class="alerta"></p>   
                            </div> 
                            <div class="inp-contenedor">
                                <input type="text" id="telefonofeik" value="{{ $cliente->telefono }}" name="telefonofeik" class="inp sa" maxlength="12" tabindex="-1" oninput="separarNumeros()" required>
                                <input type="number" class="d-none" id="telefono" name="telefono" value="{{ $cliente->telefono }}" >
                                <label for="telefonofeik" class="etq">WhatsApp</label>
                                @error('telefono')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span class="bar sa"></span>
                                <p id="alerta-telefono" class="alerta"></p> 
                            </div>   
                            @error('error')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                                    
                        </div>
                        <!-- PASO 2 -->
                        <div class="paso">
                            <div class="inp-contenedor">
                                <input type="text" id="ingresoquincenalfeik" value="{{ $datosFinancieros->ingresoquincenal }}" onload="formatoMexico(this)" onkeydown="soloNumeros()" name="ingresoquincenalfeik" oninput="formatoMexico(this)" class="inp sa" tabindex="-1" required>
                                <input type="number" class="d-none" name="ingresoquincenal" id="ingresoquincenal" value="{{ $cliente->ingresoquincenal }}">
                                <label for="ingresoquincenal" class="etq">Ingresos quincenales</label>
                                @error('ingresoquincenal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span class="bar sa"></span>
                                <span class="quincena-span">$</span>
                                <p id="alerta-quincena" class="alerta"></p> 
                            </div>
                            <div class="inp-contenedor">
                                <input type="text" id="disponiblequincenalfeik" value="{{ $datosFinancieros->disponiblequincenal }}" onload="formatoMexico(this)" onkeydown="soloNumeros()" name="disponiblequincenal" oninput="formatoMexico(this)" class="inp sa" tabindex="-1" required>
                                <input type="number" id="disponiblequincenal" class="d-none" name="disponiblequincenal" value="{{ $cliente->disponiblequincenal }}">
                                <label for="disponiblequincenal" class="etq">¿Cuánto te queda disponible?</label>
                                @error('disponiblequincenal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span class="bar sa"></span>
                                <span class="quincena-span">$</span>
                                <p id="alerta-disponible" class="alerta"></p> 
                            </div>    
                            <div class="inp-contenedor @if (auth()->user()->tipo!="Admin") d-none @endif">
                                <input type="text" id="ajustePasivosfeik" value="" onload="formatoMexico(this)" name="ajustePasivosfeik" oninput="formatoMexico(this)" onkeydown="soloNumeros()" class="inp sa" tabindex="-1" required>
                                <input type="number" id="ajustePasivos" class="d-none" name="ajustePasivos" value="">
                                <label for="ajustePasivosfeik" class="etq">Ajuste (+ - ) quincenal por pasivos</label>
                                @error('ajustePasivos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span class="bar sa"></span>
                                <span class="quincena-span">$</span>
                                <p id="alerta-disponible" class="alerta"></p> 
                            </div>      
                               
                        </div>
                        <!--
                    </form>  -->
                        <!-- PASO 3 -->
                        <!--
                        <form action="{{route('solicitudes.store')}}" method="POST">
                            @csrf -->
                            {{ Form::hidden('idcliente', $cliente->id) }} 
                        <div class="paso">
                            <div class="pagos-contenedor">
                                <div class="pagos-subcontenedor">
                                    <label for="pagominimo" class="pagos-etiqueta">Pago mínimo (quincenal)</label>
                                    <div class="pagos-ssc">
                                        <span class="pagos-span">$</span>
                                        <input type="number" name="pagominimo" id="pagominimo" class="pagos-input" tabindex="-1" required readonly>
                                    </div>
                                </div>
                                <div class="pagos-subcontenedor">
                                    <label for="pagomaximo" class="pagos-etiqueta">Pago máximo (quincenal)</label>
                                    <div class="pagos-ssc">
                                        <span class="pagos-span">$</span>
                                        <input type="number" name="pagomaximo" id="pagomaximo" class="pagos-input" tabindex="-1" required readonly>
                                    </div>
                                </div>                           
                            </div>
                            <div class="range-contenedor">
                                <label for="range" class="pagos-etiqueta">Pago quincenal deseado</label>
                                <input type="range" name="range" id="range" step="50" tabindex="-1">
                                <div class="pagos-ssc">
                                    <span class="pagos-span">$</span>
                                    <input type="number" name="pagodeseado" id="pagodeseado" class="pagos-input" tabindex="-1" readonly required>
                                </div>
                            </div>
                            <div class="range-contenedor">
                                <p id="plazoMinimo" class="d-none">{{$convenio->plazoMinimo}}</p>
                                <p id="plazoMaximo" class="d-none">{{$convenio->plazoMaximo}}</p>
                                <p id="montoMinimo" class="d-none">{{$convenio->montoMinimo}}</p>
                                <p id="montoMaximo" class="d-none">{{$convenio->montoMaximo}}</p>
                                <p id="tasa" class="d-none">{{$convenio->tasa}}</p>
                                <p id="fechaTermino" class="d-none">{{$convenio->fechaTermino}}</p>
                                <label for="range-meses" class="pagos-etiqueta">¿A cuántos meses?</label>
                                @php
                                    $fechaActual = date_create(date("Y-m-d"));
                                    $fechaFin = date_create($convenio->fechaTermino);
                                    $diferencia = date_diff($fechaActual, $fechaFin);
                                    $plazoMaximo = ($diferencia->y*12)+($diferencia->m);
                                    if($diferencia->invert==1) $plazoMaximo*=-1;
                                    if($plazoMaximo>$convenio->plazoMaximo) $plazoMaximo = $convenio->plazoMaximo;
                                @endphp
                                <input type="range" name="range-meses" id="range-meses" min="{{$convenio->plazoMinimo}}" max="{{$plazoMaximo}}" value="12" step="1" tabindex="-1">
                                <div class="pagos-ssc">
                                    <input value="12" type="number" name="plazo" id="number-meses" class="meses-input" tabindex="-1" readonly required>
                                    <span class="meses-span">Meses</span>
                                </div>
                            </div>           
                        </div>
                        <!-- PASO 4 -->
                        <div class="paso">
                            <div class="pagos-subcontenedor">
                                <label for="creditomaximo" class="pagos-etiqueta">Crédito máximo</label>
                                <div class="pagos-ssc">
                                    <span class="pagos-span">$</span>
                                    <input type="number" name="creditomaximo" id="creditomaximo" class="pagos-input" tabindex="-1" required readonly>
                                </div>
                                <p id="meses-etq" class="pagos-etiqueta"></p>
                            </div>
                            <div class="inp-contenedor">
                                <input type="text" id="prestamosolicitadofeik" name="prestamosolicitadofeik" oninput="formatoMexico(this)" class="inp sa" tabindex="-1" required>
                                <input type="hidden" id="prestamosolicitado" name="prestamosolicitado" class="inp sa" tabindex="-1" required>
                                <label for="prestamosolicitado" class="etq">Prestamo solicitado:</label>
                                <span class="bar sa"></span>
                                <span class="quincena-span">$</span>
                                <p id="alerta-solicitado" class="alerta"></p> 
                            </div>
                            <div class="meses-contenedor d-none">
                                <span>Pagando el día</span>  
                                <div id="boton-menos-dias" class="meses-boton dias gris">-</div>
                                <input type="number" name="días-mes" id="días-mes" min="1" max="30" class="meses-input" value="1" tabindex="-1" required readonly>
                                <div id="boton-mas-dias" class="meses-boton">+</div>
                                <span>de cada mes.</span>                                
                            </div>    
                            {{Form::hidden('estado','Editando')}}              
                        </div>      
                    </div>
                </form>        
            </div>
            <button id="btn-desp-atr" class="button oculto" tabindex="-1">Volver</button>
            <button id="btn-desp-sig" class="button der" tabindex="-1">Siguiente</button>
        </div>
    </section>
    
    <script src="{{asset('js/validarDatos.js')}}"></script>
    <script src="{{asset('js/desplazarForm.js')}}"></script>
    <script src="{{asset('js/calcularMontos.js')}}"></script>
    <script src="{{asset('js/calcularTotal.js')}}"></script>
    <script>
        const separarNumeros = () => {
            let input = document.getElementById('telefonofeik');
            let numero = input.value.replace(/\D/g, '');
            let formateado = '';
      
            for (let i = 0; i < numero.length; i++) {
                if (i === 3 || i === 6) {
                    formateado += ' ';
                }
        
                formateado += numero.charAt(i);
            }
      
            input.value = formateado;
            juntarNumeros();
        }
        function juntarNumeros()
        {
            let inputtelefono = document.getElementById("telefono");
            let inputFeik = document.getElementById("telefonofeik");
            inputtelefono.value=inputFeik.value.replaceAll(' ','');
        }
        const formatoMexico = (number) => {
            let numero = number.value;
            numero = numero.replaceAll(',','');
            const exp = /(\d)(?=(\d{3})+(?!\d))/g;
            const rep = '$1,';
            number.value = numero.toString().replace(exp,rep);
            let idInputBueno = number.id.replaceAll('feik','');
            document.getElementById(idInputBueno).value=numero;
            actualizarMontos();
            return numero.toString().replace(exp,rep);
        }

        function moverAlInicio()
        {
            formatoMexico(document.getElementById("ingresoquincenalfeik"));
            formatoMexico(document.getElementById("disponiblequincenalfeik"));
            formatoMexico(document.getElementById("prestamosolicitadofeik"));
            separarNumeros();
        }
        document.getElementsByTagName("body")[0].onload=moverAlInicio();
    </script>
    @endsection