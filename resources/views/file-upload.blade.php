@php
    use App\Models\Solicitude;
    use App\Models\User;
    use App\Models\Cliente;
@endphp
@extends('layouts.app')
@section('content')
<link href="{{asset('css/subirArchivos.css')}}" rel="stylesheet">
<link href="{{ asset('img/SacimexImagotipo.png') }}" rel="icon">
<script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.2/dist/leaflet.css" />
<title>Subir archivos</title>
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
<script src="https://kit.fontawesome.com/56eee1d2a7.js" crossorigin="anonymous"></script>
<section>
<a href="{{url()->previous()}}" class="kITrbH"><i class="fa-solid fa-arrow-left"></i><span>Volver</span></a>
    <form method="post" enctype="multipart/form-data" action="{{ url('store') }}" >
      @csrf
      @if (is_null($documentosN['ine']))
          
      @endif
      {{Form::hidden('idcliente',$documentosN['ine']->idcliente)}}
      <!-- Si el usuario es admin o seyor de la empresa del convenio, que se muestre el nombre del cliente-->
      @php
        $usuario = User::find(Auth::id());
        $cliente = Cliente::find($documentosN['ine']->idcliente);
    @endphp
    @if ($usuario->tipo=="Admin"||$usuario->tipo=="Aliado"||$usuario->tipo=="Asesor")
        <h3>Cliente: {{$cliente->nombre}}</h3>
    @endif
        <div class="tabla">
            <div class="cVrddT">
                <div class="nombre">Identificación (frente)</div>
                <div class="input-contenedor">
                    <input type="hidden" id="documentoIne" name="documentoIne" value="{{$documentosN['ine']->id}}">
                    <div class="grid-x @if ($documentosN['ine']->estado=="Aprobado")  d-none @endif " id="subirIne">
                        <input type="file" name="ine" id="ine" class="input-file" accept="image/png, .jpeg, .jpg, .pdf"/>
                        <input type="text" name="hiddenine" value="{{$documentosN['ine']->documento}}" style="display: none;">
                        <label for="ine" class="label-file">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="upload" class="svg-inline--fa fa-upload fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"></path>
                            </svg>
                            <span>Subir archivo.</span>
                        </label>
                        <div class="contenedor-nombre"><span id="nombre-ine"></span></div>  
                    </div>  
                </div>
                <div class="estado">
                    <div class="estado">
                        @if(($documentosN['ine']->documento)!="")
                            @php
                                $ruta = "storage/".str_replace("public/","",$documentosN['ine']->documento);
                            @endphp              
                            <h6>Ya se subió un documento</h6>
                        @endif
                    </div>
                </div>
            </div>
            <div class="cVrddT">
                @if(($documentosN['ine']->documento)!="")
                    <div class="visualizacion-contenedor">
                        <embed id="inepro" src="{{asset($ruta)}}"  frameborder="0">
                    </div>
                    <a class="lupa" href="{{$ruta}}" target="_blank"><i class="fa-solid fa-magnifying-glass"></i></a>
                    @endif
            </div>
            @if (Auth::user()->tipo=="Admin"&&$documentosN['ine']->estado!="")
                <div class="cVrddT">
                    @if (($documentosN['ine']->documento)!="")
                    <div class="botones-contenedor">
                        <a id="aprobarIne" onclick="movimiento(this)" href="#" class=" boton-ap-re verde" style="@if($documentosN['ine']->estado=="Aprobado") pointer-events : none @endif">
                            <i class="fa-regular fa-thumbs-up"></i>
                        </a>
                        <a id="rechazarIne" onclick="movimiento(this)" href="#" class=" boton-ap-re rojo" style="@if($documentosN['ine']->estado=="Rechazado") pointer-events : none @endif">
                            <i class="fa-regular fa-thumbs-down"></i>
                        </a>
                    </div>
                    <input id="motivoIne" name="motivoIne" type="text" placeholder="Observaciones" value="{{$documentosN['ine']->observaciones}}" class="observaciones">
                    @endif
                    
                </div>        
                @else
                    @if ($documentosN['ine']->estado!="")
                        <div class="cVrddT">
                            <p class="text-center">Estado</p>
                            <p class="text-center">{{$documentosN['ine']->estado}}</p>
                            <label for="motivoIne" class="form-control">Observaciones</label>
                            <input class="observaciones disabled" type="text" name="motivoIne" id="motivoIne" value="{{$documentosN['ine']->observaciones}}" readonly>
                        </div>
                    @endif
            @endif    
                    @if ($documentosN['ine']->estado!=""&&Auth::user()->tipo=="Admin")
                            <div>
                                <p id="estadoIne" class="text-center">{{$documentosN['ine']->estado}}</p>
                                <label for="motivoIne" class="form-control">Observaciones</label>
                                <input class="form-control disabled" type="text" name="motivoIne" id="motivo2Ine" value="{{$documentosN['ine']->observaciones}}" readonly>
                            </div>
                    @endif
                <div class="qKabfr">
                    <ul>
                        <li>Se aceptan los siguientes documentos: INE (vigente), Pasaporte, Cédula profesional.</li>
                    </ul>
                </div>
            
        </div>
        <div class="tabla">
            <div class="cVrddT">
                <div class="nombre">Identificación (dorso)</div>
                <div class="input-contenedor">
                    <input type="hidden" id="documentoIne2" name="documentoIne2" value="{{$documentosN['ine2']->id}}">
                    <div class="grid-x @if ($documentosN['ine2']->estado=="Aprobado")  d-none @endif " id="subirIne2">
                        <input type="file" name="ine2" id="ine2" class="input-file" accept="image/png, .jpeg, .jpg, .pdf"/>
                        <input type="text" name="hiddenine" value="{{$documentosN['ine2']->documento}}" style="display: none;">
                        <label for="ine2" class="label-file">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="upload" class="svg-inline--fa fa-upload fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"></path>
                            </svg>
                            <span>Subir archivo.</span>
                        </label>
                        <div class="contenedor-nombre"><span id="nombre-ine2"></span></div>  
                    </div>  
                </div>
                <div class="estado">
                    <div class="estado">
                        @if(($documentosN['ine2']->documento)!="")
                            @php
                                $ruta = "storage/".str_replace("public/","",$documentosN['ine2']->documento);
                            @endphp              
                            <h6>Ya se subió un documento</h6>
                        @endif
                    </div>
                </div>
            </div>
            <div class="cVrddT">
                @if(($documentosN['ine2']->documento)!="")
                    <div class="visualizacion-contenedor">
                        <embed id="inepro" src="{{asset($ruta)}}"  frameborder="0">
                    </div>
                    <a class="lupa" href="{{$ruta}}" target="_blank"><i class="fa-solid fa-magnifying-glass"></i></a>
                    @endif
            </div>
            @if (Auth::user()->tipo=="Admin"&&$documentosN['ine2']->estado!="")
                <div class="cVrddT">
                    @if (($documentosN['ine2']->documento)!="")
                    <div class="botones-contenedor">
                        <a id="aprobarIne2" onclick="movimiento(this)" href="#" class=" boton-ap-re verde" style="@if($documentosN['ine2']->estado=="Aprobado") pointer-events : none @endif">
                            <i class="fa-regular fa-thumbs-up"></i>
                        </a>
                        <a id="rechazarIne2" onclick="movimiento(this)" href="#" class=" boton-ap-re rojo" style="@if($documentosN['ine2']->estado=="Rechazado") pointer-events : none @endif">
                            <i class="fa-regular fa-thumbs-down"></i>
                        </a>
                    </div>
                    <input id="motivoIne2" name="motivoIne2" type="text" placeholder="Observaciones" value="{{$documentosN['ine2']->observaciones}}" class="observaciones">
                    @endif
                    
                </div>        
                @else
                    @if ($documentosN['ine2']->estado!="")
                        <div class="cVrddT">
                            <p class="text-center">Estado</p>
                            <p class="text-center">{{$documentosN['ine2']->estado}}</p>
                            <label for="motivoIne2" class="form-control">Observaciones</label>
                            <input class="observaciones disabled" type="text" name="motivoIne2" id="motivoIne2" value="{{$documentosN['ine2']->observaciones}}" readonly>
                        </div>
                    @endif
            @endif    
                    @if ($documentosN['ine2']->estado!=""&&Auth::user()->tipo=="Admin")
                            <div>
                                <p id="estadoIne2" class="text-center">{{$documentosN['ine2']->estado}}</p>
                                <label for="motivoIne2" class="form-control">Observaciones</label>
                                <input class="form-control disabled" type="text" name="motivoIne2" id="motivo2Ine2" value="{{$documentosN['ine2']->observaciones}}" readonly>
                            </div>
                    @endif
                <div class="qKabfr">
                    <ul>
                        <li>Se aceptan los siguientes documentos: INE (vigente), Pasaporte, Cédula profesional.</li>
                    </ul>
                </div>
            
        </div>
        <div class="tabla">
            <div class="cVrddT">
                <div class="nombre">Comprobante de ingresos</div>
                <div class="input-contenedor">
                    <input type="hidden" id="documentoIngresos" name="documentoIngresos" value="{{$documentosN['ingresos']->id}}">
                    <div class="grid-x @if ($documentosN['ingresos']->estado=="Aprobado") d-none @endif " id="subirIngresos">
                        <input type="file" name="ingresos" id="ingresos" class="input-file" accept="image/png, .jpeg, .jpg, .pdf"/>
                        <input type="text" name="hiddeningresos" value="{{$documentosN['ingresos']->documento}}" style="display: none;">
                        <label for="ingresos" class="label-file">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="upload" class="svg-inline--fa fa-upload fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"></path>
                            </svg>
                            <span>Subir archivo.</span>
                        </label>
                        <div class="contenedor-nombre"><span id="nombre-ingresos"></span></div>  
                    </div>  
                </div>
                <div class="estado">
                    <div class="estado">
                        @if(($documentosN['ingresos']->documento)!="")
                            @php
                                $ruta = "storage/".str_replace("public/","",$documentosN['ingresos']->documento);
                            @endphp              
                            <h6>Ya se subió un documento</h6>
                        @endif
                    </div>
                </div>
            </div>
            <div class="cVrddT">
                @if(($documentosN['ingresos']->documento)!="")
                    <div class="visualizacion-contenedor">
                        <embed id="ingresospro" src="{{asset($ruta)}}"  frameborder="0">
                    </div>
                    <a class="lupa" href="{{$ruta}}" target="_blank"><i class="fa-solid fa-magnifying-glass"></i></a>
                @endif
            </div>
            @if ((Auth::user()->tipo=="Admin")&&($documentosN['ingresos']->documento)!="")
                <div class="cVrddT">
                    <div class="botones-contenedor">
                        <!--como hacer que se pase que opcion fue la que se pulsó -->
                        <a id="aprobarIngresos" onclick="movimiento(this)" href="#" class=" boton-ap-re verde" style="@if($documentosN['ingresos']->estado=="Aprobado") pointer-events : none @endif ">
                            <i class="fa-regular fa-thumbs-up"></i>
                        </a>
                        <a id="rechazarIngresos" onclick="movimiento(this)" href="#" class=" boton-ap-re rojo" style="@if($documentosN['ingresos']->estado=="Rechazado") pointer-events : none @endif">
                            <i class="fa-regular fa-thumbs-down"></i>
                        </a>
                    </div>
                    <input type="text" name="motivoIngresos" id="motivoIngresos" value="{{$documentosN['ingresos']->observaciones}}" class="observaciones">
                    
                </div>        
            @else
                @if ($documentosN['ingresos']->estado!="")
                    <div class="cVrddT">
                        <p class="text-center">Estado</p>
                        <p class="text-center">{{$documentosN['ingresos']->estado}}</p>
                        <label for="motivoIngresos" class="form-control">Observaciones</label>
                        <input class="observaciones disabled" type="text" name="motivoIngresos" id="motivoIngresos" value="{{$documentosN['ingresos']->observaciones}}" readonly>
                    </div>
                @endif
            @endif
            @if ($documentosN['ingresos']->estado!=""&&Auth::user()->tipo=="Admin")
                <div class="cVrddT">
                    <p id="estadoIngresos" class="text-center">{{$documentosN['ingresos']->estado}}</p>
                    <label for="motivo2Ingresos" class="form-control">Observaciones</label>
                    <input class="form-control disabled" type="text" name="motivoIngresos" id="motivo2Ingresos" value="{{$documentosN['ingresos']->observaciones}}" readonly>
                </div>
            @endif
                <div class="qKabfr">
                    <ul>
                        <li>Este puede variar según la ubicación del cliente. En el caso de ciertos municipios es aceptable un comprobante de pago emitido por la entidad municipal.</li>
                    </ul>
                </div>
        </div>
        <div class="tabla">
            <div class="cVrddT">
                <div class="nombre">Comprobante de domicilio</div>
                <div class="input-contenedor">
                    <input type="hidden" id="documentoDomicilio" name="documentoDomicilio" value="{{$documentosN['domicilio']->id}}">
                    <div class="grid-x @if ($documentosN['domicilio']->estado=="Aprobado") d-none @endif " id="subirDomicilio">
                        <input type="file" name="comprobantedomicilio" id="comprobantedomicilio" class="input-file" accept="image/png, .jpeg, .jpg, .pdf"/>
                        <input type="text" name="hiddencomprobante" value="{{$documentosN['domicilio']->documento}}" style="display: none;">
                        <label for="comprobantedomicilio" class="label-file">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="upload" class="svg-inline--fa fa-upload fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"></path>
                            </svg>
                            <span>Subir archivo.</span>
                        </label>
                        <div class="contenedor-nombre"><span id="nombre-domicilio"></span></div>  
                    </div>  
                </div>
                <div class="estado">
                    <div class="estado">
                        @if(($documentosN['domicilio']->documento)!="")
                            @php
                                $ruta = "storage/".str_replace("public/","",$documentosN['domicilio']->documento);
                            @endphp              
                            <h6>Ya se subió un documento</h6>
                        @endif
                    </div>
                </div>
            </div>
            <div class="cVrddT">
                @if(($documentosN['domicilio']->documento)!="")
                    <div class="visualizacion-contenedor">
                        <embed id="domiciliopro" src="{{asset($ruta)}}"  frameborder="0">
                    </div>
                    <a class="lupa" href="{{$ruta}}" target="_blank"><i class="fa-solid fa-magnifying-glass"></i></a>
                @endif
            </div>
            @if (Auth::user()->tipo=="Admin"&&$documentosN['domicilio']->estado!="")
                <div class="cVrddT">
                    <div class="botones-contenedor">
                        <!--como hacer que se pase que opcion fue la que se pulsó -->
                        <a id="aprobarDomicilio" onclick="movimiento(this)" href="#" class=" boton-ap-re verde" style="@if($documentosN['domicilio']->estado=="Aprobado") pointer-events : none @endif">
                            <i class="fa-regular fa-thumbs-up"></i>
                        </a>
                        <a id="rechazarDomicilio" onclick="movimiento(this)" href="#" class=" boton-ap-re rojo" style="@if($documentosN['domicilio']->estado=="Rechazado") pointer-events : none @endif">
                            <i class="fa-regular fa-thumbs-down"></i>
                        </a>
                    </div>
                    <input type="text" name="motivoDomicilio" id="motivoDomicilio" value="{{$documentosN['domicilio']->observaciones}}" class="observaciones">
                    
                </div>        
            @else
                @if ($documentosN['domicilio']->estado!="")
                    <div class="cVrddT">
                        <p class="text-center">Estado</p>
                        <p class="text-center">{{$documentosN['domicilio']->estado}}</p>
                        <label for="motivoDomicilio" class="form-control">Observaciones</label>
                        <input class="observaciones disabled" type="text" name="motivoDomicilio" id="motivoDomicilio" value="{{$documentosN['domicilio']->observaciones}}" readonly>
                    </div>
                @endif
            @endif
            @if ($documentosN['domicilio']->estado!=""&&Auth::user()->tipo=="Admin")
                    <div class="cVrddT">
                        <p id="estadoDomicilio" class="text-center">{{$documentosN['domicilio']->estado}}</p>
                        <label for="motivoDomicilio" class="form-control">Observaciones</label>
                        <input class="form-control   disabled" type="text" name="motivoDomicilio" id="motivo2Domicilio" value="{{$documentosN['domicilio']->observaciones}}" readonly>
                    </div>
                @endif
                <div class="qKabfr">
                    <ul>
                        <li>El comprobante debe haber sido expedido hace máximo tres meses.</li>
                        <li>Solo se aceptan los siguientes documentos: Recibo de CFE, agua, predial y constancia.</li>
                    </ul>
                </div>
        </div>
        <div class="tabla">
            <div class="cVrddT">
                <div class="nombre">Fotografía</div>
                <div class="input-contenedor">
                    <input type="hidden" id="documentoFoto" name="documentoFoto" value="{{$documentosN['foto']->id}}">
                    <div class="grid-x @if ($documentosN['foto']->estado=="Aprobado") d-none @endif " id="subirFoto">
                        <input type="file" name="fotografia" id="fotografia" class="input-file" accept="image/png, .jpeg, .jpg, .pdf"/>
                        <input type="text" name="hiddenfotografia" value="{{$documentosN['foto']->documento}}" style="display: none;">
                        <label for="fotografia" class="label-file">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="upload" class="svg-inline--fa fa-upload fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"></path>
                            </svg>
                            <span>Subir archivo.</span>
                        </label>
                        <div class="contenedor-nombre"><span id="nombre-foto"></span></div>  
                    </div>  
                </div>
                <div class="estado">
                    <div class="estado">
                        @if(($documentosN['foto']->documento)!="")
                            @php
                                $ruta = "storage/".str_replace("public/","",$documentosN['foto']->documento);
                            @endphp              
                            <h6>Ya se subió un documento</h6>
                        @endif
                    </div>
                </div>
            </div>
            <div class="cVrddT">
                @if(($documentosN['foto']->documento)!="")
                    <div class="visualizacion-contenedor">
                        <embed id="fotopro" src="{{asset($ruta)}}"  frameborder="0">
                    </div>
                    <a class="lupa" href="{{$ruta}}" target="_blank"><i class="fa-solid fa-magnifying-glass"></i></a>
                @endif
            </div>
            @if (Auth::user()->tipo=="Admin"&&$documentosN['foto']->documento!="")
                <div class="cVrddT">
                    <div class="botones-contenedor">
                        <!--como hacer que se pase que opcion fue la que se pulsó -->
                        <a id="aprobarFoto" onclick="movimiento(this)" href="#" class=" boton-ap-re verde" style="@if($documentosN['foto']->estado=="Aprobado") pointer-events : none @endif">
                            <i class="fa-regular fa-thumbs-up"></i>
                        </a>
                        <a id="rechazarFoto" onclick="movimiento(this)" href="#" class=" boton-ap-re rojo" style="@if($documentosN['foto']->estado=="Rechazado") pointer-events : none @endif">
                            <i class="fa-regular fa-thumbs-down"></i>
                        </a>
                    </div>
                    <input type="text" name="motivoFoto" id="motivoFoto" value="{{$documentosN['foto']->observaciones}}" class="observaciones">
                    
                </div>        
            @else
                @if ($documentosN['foto']->documento!="")
                    <div class="cVrddT">
                        <p class="text-center">Estado</p>
                        <p class="text-center">{{$documentosN['foto']->estado}}</p>
                        <label for="motivoFoto" class="form-control">Observaciones</label>
                        <input class="observaciones disabled" type="text" name="motivoFoto" id="motivoFoto" value="{{$documentosN['foto']->observaciones}}" readonly>
                    </div>
                @endif
            @endif
            @if ($documentosN['foto']->documento!=""&&Auth::user()->tipo=="Admin")
                    <div class="cVrddT">
                        <p id="estadoFoto" class="text-center">{{$documentosN['foto']->estado}}</p>
                        <label for="motivoFoto" class="form-control">Observaciones</label>
                        <input class="form-control disabled" type="text" name="motivoFoto" id="motivo2Foto" value="{{$documentosN['foto']->observaciones}}" readonly>
                    </div>
                @endif
                <div class="qKabfr">
                    <ul>
                        <li>Se aceptarán fotos visibles que incluyan desde el rostro hasta los hombros.</li>
                    </ul>
                    <div class="gjjCVU">
                        <div class="ExfRZh">
                            <img class="yYBCkR" src="{{ asset('img/EjemploFoto.png') }}"/>
                        </div>
                        <p class="oErWzH">Imagen de ejemplo.</p>
                    </div>
                </div>
        </div>
        <div class="tabla">
            <div class="cVrddT">
                <div class="nombre">Identificación de beneficiario</div>
                <div class="input-contenedor">
                    <input type="hidden" id="documentoIneBeneficiario" name="documentoIneBeneficiario" value="{{$documentosN['ineBeneficiario']->id}}">
                    <div class="grid-x @if ($documentosN['ineBeneficiario']->estado=="Aprobado")  d-none @endif " id="subirIneBeneficiario">
                        <input type="file" name="ineBeneficiario" id="ineBeneficiario" class="input-file" accept="image/png, .jpeg, .jpg, .pdf"/>
                        <input type="text" name="hiddenineBeneficiario" value="{{$documentosN['ineBeneficiario']->documento}}" style="display: none;">
                        <label for="ineBeneficiario" class="label-file">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="upload" class="svg-inline--fa fa-upload fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"></path>
                            </svg>
                            <span>Subir archivo.</span>
                        </label>
                        <div class="contenedor-nombre"><span id="nombre-ineBeneficiario"></span></div>  
                    </div>  
                </div>
                <div class="estado">
                    <div class="estado">
                        @if(($documentosN['ineBeneficiario']->documento)!="")
                            @php
                                $ruta = "storage/".str_replace("public/","",$documentosN['ineBeneficiario']->documento);
                            @endphp              
                            <h6>Ya se subió un documento</h6>
                        @endif
                    </div>
                </div>
            </div>
            <div class="cVrddT">
                @if(($documentosN['ineBeneficiario']->documento)!="")
                    <div class="visualizacion-contenedor">
                        <embed id="ineBeneficiariopro" src="{{asset($ruta)}}"  frameborder="0">
                    </div>
                    <a class="lupa" href="{{$ruta}}" target="_blank"><i class="fa-solid fa-magnifying-glass"></i></a>
                    @endif
            </div>
            @if (Auth::user()->tipo=="Admin"&&$documentosN['ineBeneficiario']->estado!="")
                <div class="cVrddT">
                    @if (($documentosN['ineBeneficiario']->documento)!="")
                    <div class="botones-contenedor">
                        <a id="aprobarineBeneficiario" onclick="movimiento(this)" href="#" class=" boton-ap-re verde" style="@if($documentosN['ineBeneficiario']->estado=="Aprobado") pointer-events : none @endif">
                            <i class="fa-regular fa-thumbs-up"></i>
                        </a>
                        <a id="rechazarineBeneficiario" onclick="movimiento(this)" href="#" class=" boton-ap-re rojo" style="@if($documentosN['ineBeneficiario']->estado=="Rechazado") pointer-events : none @endif">
                            <i class="fa-regular fa-thumbs-down"></i>
                        </a>
                    </div>
                    <input id="motivoineBeneficiario" name="motivoineBeneficiario" type="text" placeholder="Observaciones" value="{{$documentosN['ineBeneficiario']->observaciones}}" class="observaciones">
                    @endif
                    
                </div>        
                @else
                    @if ($documentosN['ineBeneficiario']->estado!="")
                        <div class="cVrddT">
                            <p class="text-center">Estado</p>
                            <p class="text-center">{{$documentosN['ineBeneficiario']->estado}}</p>
                            <label for="motivoineBeneficiario" class="form-control">Observaciones</label>
                            <input class="observaciones disabled" type="text" name="motivoineBeneficiario" id="motivoineBeneficiario" value="{{$documentosN['ineBeneficiario']->observaciones}}" readonly>
                        </div>
                    @endif
            @endif    
                    @if ($documentosN['ineBeneficiario']->estado!=""&&Auth::user()->tipo=="Admin")
                            <div>
                                <p id="estadoineBeneficiario" class="text-center">{{$documentosN['ineBeneficiario']->estado}}</p>
                                <label for="motivoineBeneficiario" class="form-control">Observaciones</label>
                                <input class="form-control disabled" type="text" name="motivo2ineBeneficiario" id="motivo2ineBeneficiario" value="{{$documentosN['ineBeneficiario']->observaciones}}" readonly>
                            </div>
                    @endif
                <div class="qKabfr">
                    <ul>
                        <li>Se aceptan los siguientes documentos: INE (vigente), Pasaporte, Cédula profesional.</li>
                    </ul>
                </div>
            
        </div>
        <button type="submit" class="boton">Enviar</button>
        @php
            $aprobados = true;
            foreach ($documentosN as $documento) {
                if ($documento->estado!="Aprobado") {
                    $aprobados = false;
                    break;
                }
            }
            //$solicitud = Solicitude::where('idcliente', $documentosN['ine']->idcliente)->first();
            $solicitud = Solicitude::where('idcliente', $documentosN['ine']->idcliente)->first();
        @endphp


            <a id="botonIntegracion" style="text-decoration: none" class="boton @if (!$aprobados||(Auth::user()->tipo!="Admin")) d-none
                @endif" href="{{route('documentosIntegracion', ['idsolicitud' => $solicitud])}}">A integracion</a>

    
                <div id="map" style="height: 500px;width: 500px;" ></div>
</section>

<script>
document.getElementById('ine').addEventListener('change', ev => {
const archivo = ev.target.files[0];
const nombreArchivo = archivo ? archivo.name : '';
document.getElementById('nombre-ine').textContent = nombreArchivo;
});

document.getElementById('ingresos').addEventListener('change', ev => {
const archivo = ev.target.files[0];
const nombreArchivo = archivo ? archivo.name : '';
document.getElementById('nombre-ingresos').textContent = nombreArchivo;
});

document.getElementById('comprobantedomicilio').addEventListener('change', ev => {
const archivo = ev.target.files[0];
const nombreArchivo = archivo ? archivo.name : '';
document.getElementById('nombre-domicilio').textContent = nombreArchivo;
});

document.getElementById('fotografia').addEventListener('change', ev => {
const archivo = ev.target.files[0];
const nombreArchivo = archivo ? archivo.name : '';
document.getElementById('nombre-foto').textContent = nombreArchivo;
});

document.getElementById('ine2').addEventListener('change', ev => {
const archivo = ev.target.files[0];
const nombreArchivo = archivo ? archivo.name : '';
document.getElementById('nombre-ine2').textContent = nombreArchivo;
});

document.getElementById('ineBeneficiario').addEventListener('change', ev => {
const archivo = ev.target.files[0];
const nombreArchivo = archivo ? archivo.name : '';
document.getElementById('nombre-ineBeneficiario').textContent = nombreArchivo;
});

function movimiento(boton)
{
    let accion = boton.innerText;
    let documento = boton.id.replaceAll("aprobar","");
    documento = documento.replaceAll("rechazar","");
    let documentoid = null;
    let resultado = "";
    if(boton.id.indexOf('aprobar') != -1) resultado = "Aprobado";
    else if(boton.id.indexOf('rechazar') != -1)resultado = "Rechazado";
    let motivo;
    switch(documento)
    {
        case "Ine":
            documentoid = document.getElementById("documentoIne").value;
            motivo = document.getElementById("motivoIne").value;
            if(resultado=="Rechazado"||resultado=="En revision") document.getElementById("subirIne").classList.remove("d-none");
            else document.getElementById("subirIne").classList.add("d-none");
        break;
        case "Ine2":
            documentoid = document.getElementById("documentoIne2").value;
            motivo = document.getElementById("motivoIne2").value;
            if(resultado=="Rechazado"||resultado=="En revision") document.getElementById("subirIne2").classList.remove("d-none");
            else document.getElementById("subirIne2").classList.add("d-none");
        break;
        case "Ingresos":
            documentoid = document.getElementById("documentoIngresos").value;
            motivo = document.getElementById("motivoIngresos").value;
            if(resultado=="Rechazado"||resultado=="En revision") document.getElementById("subirIngresos").classList.remove("d-none");
            else document.getElementById("subirIngresos").classList.add("d-none");
        break;
        case "Domicilio":
            documentoid = document.getElementById("documentoDomicilio").value;
            motivo = document.getElementById("motivoDomicilio").value;
            if(resultado=="Rechazado"||resultado=="En revision") document.getElementById("subirDomicilio").classList.remove("d-none");
            else document.getElementById("subirDomicilio").classList.add("d-none");
        break;
        case "Foto":
            documentoid = document.getElementById("documentoFoto").value;
            motivo = document.getElementById("motivoFoto").value;
            if(resultado=="Rechazado"||resultado=="En revision") document.getElementById("subirFoto").classList.remove("d-none");
            else document.getElementById("subirFoto").classList.add("d-none");
        break;
        case "ineBeneficiario":
            documentoid = document.getElementById("documentoIneBeneficiario").value;
            motivo = document.getElementById("motivoineBeneficiario").value;
            if(resultado=="Rechazado"||resultado=="En revision") document.getElementById("subirIneBeneficiario").classList.remove("d-none");
            else document.getElementById("subirFoto").classList.add("d-none");
        break;
    }
    var formData = new FormData();

    formData.append("_token", document.getElementsByTagName('input')[0].value);
    formData.append("documento", documentoid);
    formData.append("movimiento", resultado);
    formData.append("motivo", motivo);
    fetch('/cambiarEstado', {
                        method: 'POST',
                        body: formData
                     }).then((response) => {
                                return response.json();
                            })
                            .then((data) => {
                                console.log(data['estado']);
                                //boton.classList.add("disabled");
                                boton.style.pointerEvents="none";
                                if(data['estado']=="Aprobado")
                                {
                                    boton.nextElementSibling.style.pointerEvents="";
                                    document.getElementById("estado"+documento).innerText="Aprobado";
                                }else if(data['estado']=="Rechazado")
                                {
                                    boton.previousElementSibling.style.pointerEvents="";
                                    document.getElementById("estado"+documento).innerText="Rechazado";
                                }
                                if(documentosListos(boton))
                                {
                                    document.getElementById("botonIntegracion").classList.remove("d-none");
                                }else
                                {
                                    document.getElementById("botonIntegracion").classList.add("d-none");
                                }
                                document.getElementById("motivo2"+documento).value=document.getElementById("motivo"+documento).value;
                            }

                            );
    

}

function documentosListos(boton)
{
    let todoListo = true;
    if(boton.id.indexOf("aprobar")==-1)
    {
        console.log("Se apretó el botón de rechazar para el documento "+boton.id.replaceAll("rechazar",""));
        document.getElementById("botonIntegracion").classList.add("d-none");
        todoListo = false;

    }else
    {
        const ine = document.getElementById("estadoIne")?.innerText;
        const ingresos = document.getElementById("estadoIngresos")?.innerText;
        const domicilio = document.getElementById("estadoDomicilio")?.innerText;
        const foto = document.getElementById("estadoFoto")?.innerText;
        const ine2 = document.getElementById("estadoIne2")?.innerText;
        const benef = document.getElementById("estadoBeneficiario")?.innerText;
        let documentos = [ine,ine2,ingresos,domicilio,foto,benef];
        for(let i = 0; i < documentos.length; i++)
        {
            console.log(documentos[i]);
            if(typeof(documentos[i])!='undefined')
            {
                if(documentos[i].indexOf("Aprobado")==-1) todoListo = false;
            }
        }
    }
    console.log(todoListo);
    return todoListo;
}
</script>

<script>
let ubi=null;
const funcionInit = () => {
	if (!"geolocation" in navigator) {
		return alert("Tu navegador no soporta el acceso a la ubicación. Intenta con otro");
	}

	const onUbicacionConcedida = ubicacion => {
		console.log("Tengo la ubicación: ", ubicacion);
        ubi = ubicacion.coords;
        return ubi;
	}
  
	const onErrorDeUbicacion = err => {
		console.log("Error obteniendo ubicación: ", err);
        return "Valio burguer";
	}

	const opcionesDeSolicitud = {
		enableHighAccuracy: true, // Alta precisión
		maximumAge: 0, // No queremos caché
		timeout: 5000 // Esperar solo 5 segundos
	};
	// Solicitar
	//navigator.geolocation.getCurrentPosition(onUbicacionConcedida, onErrorDeUbicacion, opcionesDeSolicitud);

};

const getCoords = async () => {
        const pos = await new Promise((resolve, reject) => {
          navigator.geolocation.getCurrentPosition(resolve, reject);
        });
    
        return {
          long: pos.coords.longitude,
          lat: pos.coords.latitude,
        };
    };

async function Abr()
{
    const coords = await getCoords();
    console.log(coords);
}
Abr();
// Ahora se llamaría con un await funcionInit();


async function startMap()
{
    const coordenadas = await getCoords();
    console.log(coordenadas);
    var map = L.map('map').
    setView([coordenadas.lat, coordenadas.long],
    15);

    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18
    }).addTo(map);
    L.control.scale().addTo(map);
    L.marker([coordenadas.lat, coordenadas.long],{draggable: true}).addTo(map);
}


startMap();
</script>
@endsection
