<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
@extends('layouts.app')
@section('content')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/input-styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <title>Iniciar sesión</title>
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

    <section>
    <form action="{{ route('login') }}" method="post" id="form-login" autocomplete="off" class="form">
        @csrf
        <h1 class="titulo">Te damos la bienvenida a Sacimex</h1>
        <div class="inp-contenedor">
            <input type="text" id="email" name="email" onchange="quitarConveniosAdmin()" class="inp" required>
            <label for="email" class="etq">Correo electrónico</label>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong id="mensaje-error">{{ $message }}</strong>
                </span>
            @enderror
            <span class="bar"></span>
            <p id="alerta-correo" class="alerta"></p>
        </div>
        <div class="inp-contenedor">
            <input type="password" id="password" name="password" class="inp" required>
            <label for="email" class="etq">Contraseña</label>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <span class="bar"></span>
            <input id="checkbox" name="checkbox" type="checkbox" tabindex="-1">
            <label for="checkbox" class="label-checkbox"><img id="ojo" src="{{ asset('img/view.png')}}"></label>
            <p id="alerta-correo" class="alerta"></p>
        </div>
        <div class="inp-contenedor">
            <input type="text" id="convenio" name="convenio" class="inp" oninput="formatInput(this)" required>
            <label for="convenio" class="etq">Convenio</label>
            @error('convenio')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <span class="bar"></span>
            <p id="alerta-convenio" class="alerta"></p>
        </div>

        <button id="boton-login" class="btn">Iniciar sesión</button>

        <div class="lnk-contenedor">
            <p class="par">¿No tienes una cuenta?</p>
            <a href="  {{ route('register') }}  " class="lnk">Regístrate</a>
        </div>
        <div class="lnk-contenedor" id="restablecer">
            <p class="par">¿Olvidaste tu contraseña?</p>
            <a href="  {{ route('password.request') }}  " class="lnk">Restablacer contraseña</a>
        </div>

    </form>
    <div id="bot-ayuda" class="bot-ayuda">
        <img id="img-bot" src="{{asset('img/BotAyuda1.png')}}" alt="Bot de ayuda"/>
    </div>
    </section>
    


    <!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/64b5cda294cf5d49dc64323c/1h5j2mgkf';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->


<script src="{{asset('js/validarLogin.js')}}"></script>

<script>
    document.getElementById('bot-ayuda').addEventListener('click', () => {
        document.getElementById('img-bot').src = "{{asset('img/BotAyuda2.png')}}";
        document.getElementById('bot-ayuda').style.cursor = "auto";
    });
</script>
<script>
    document.getElementById('checkbox').addEventListener("change", function () {
        document.getElementById('ojo').src = this.checked ? "{{ asset('img/hide.png')}}" : "{{ asset('img/view.png')}}";
        document.getElementById('password').type = this.checked ? "text" : "password";
    });
</script>
<script>
     const formatInput = input => {
      
      if(input.value.length <= 3) input.value = input.value.replace(/\D/g, '');
      
      
      if (input.value.length === 3) {
        input.value = input.value.slice(0, 3) + '-' + input.value.slice(3);
      };

      if (input.value === '00') {
        input.value = input.value.slice(0, 2) + '-' + input.value.slice(3);
      };

      input.value = input.value.toUpperCase();
    };

    function llevarAlRegistro()
    {
        let areaMensajeError = document.getElementById("mensaje-error");
        let mensaje = areaMensajeError==null?"":areaMensajeError.innerText;
        if(mensaje=="No se encontró un usuario con ese correo")
        {
            window.location.replace("/register");
        } else if(mensaje=="Las credenciales no coinciden.")
        {
            document.getElementById("restablecer").style="font-size: x-large";
        }
    }

    document.getElementsByTagName("body")[0].addEventListener("load",llevarAlRegistro());
  </script>
@endsection