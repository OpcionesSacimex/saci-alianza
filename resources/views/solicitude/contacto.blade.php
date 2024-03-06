@extends('layouts.app')
<link href="{{asset('css/preferencias.css')}}" rel="stylesheet">
<link href="{{ asset('img/SacimexImagotipo.png') }}" rel="icon">
<title>Preferencias de contacto</title>
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

@section('content')
  <section>
  <a class="volver-boton">Volver</a>
    <div class="contenedor-principal">
      <div class="titulo-contenedor">
        <h3>¿Cómo te gustaría que te contactáramos?</h3>
      </div>
      <form action="{{route('contacto')}}" method="POST">
        @csrf
        <div class="inps">
          <label class="radio-button">
            <input type='checkbox' name='whatsapp'/> WhatsApp<span></span>
          </label>
          <label class="radio-button">
            <input type='checkbox' name='llamada'/> Llamada telefónica<span></span>
          </label>
          <label class="radio-button">
            <input type='checkbox' name='sms'/> SMS<span></span>
          </label>
        </div>
        <div class="btn-contenedor">
          <button type="submit">Aceptar</button>
        </div>
      </form>
    </div>
  </section>
@endsection