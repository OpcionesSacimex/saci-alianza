@php
    use App\Models\Cliente;
    use App\Models\Convenios;
    use App\Models\User;
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <header>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="logo-contenedor">
                <a href="{{route('home')}}"><img src="{{asset('img/logo.png')}}"></a>
            </div>
            

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <h2 class="titulo-saci">Tu crédito de confianza.</h2>
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @php
                                        $cliente = Cliente::where('user_id',Auth::id())->first();
                                        $convenio = null;
                                        $user = User::find(Auth::id());
                                        if($user->tipo=="Admin"||$user->tipo=="Asesor"||$user->tipo=="Aliado")
                                        {
                                            $convenio = $user->convenio;
                                        }else if(!is_null($cliente)) 
                                        {
                                            $convenio = Convenios::find($cliente->convenio);
                                        }
                                    @endphp
                                    @if(!is_null(Auth::user()->name)&&Auth::user()->name!=="")
                                        <span>{{ Auth::user()->name }}</span>
                                    @else
                                        <span style="font-family: 'Presidencia Fina', sans-serif">{{ Auth::user()->email }}</span>
                                    @endif
                                    @if (!is_null($convenio))
                                        <br>
                                        <span style="font-family: 'Presidencia Fina', sans-serif">Convenio {{ strtoupper(Auth::user()->convenio) }}</span>
                                    @endif
                                    
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar sesión') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </header>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    
</body>
</html>
