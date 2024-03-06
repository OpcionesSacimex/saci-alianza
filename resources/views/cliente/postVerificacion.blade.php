@extends('layouts.app')
@section('content')
    <link href="{{asset('css/pantallaPostVerificacion.css')}}" rel="stylesheet">
    <link href="{{ asset('img/SacimexImagotipo.png') }}" rel="icon">
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
  <section>
  <a href="https://www.google.com/search?sca_esv=555242323&rlz=1C1CHBF_esMX1061MX1061&q=gatitos&tbm=isch&source=lnms&sa=X&sqi=2&ved=2ahUKEwjCjNiyx9CAAxUmkWoFHakgDdMQ0pQJegQIDRAB&biw=1536&bih=707&dpr=1.25" class="kITrbH"><i class="fa-solid fa-arrow-left"></i><span>Volver</span></a>
    <h3>Has verificado tu cuenta exitosamente.</h3>
    <div class="img-contenedor">
      <img src="{{asset('img/BotVerificacion.png')}}">
    </div>
    <a class="boton-aceptar" href="{{route('file-upload')}}">Aceptar</a>
  </section>

@endsection