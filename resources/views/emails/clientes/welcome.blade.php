@component('mail::message')
# ¡Felicidades!

Haz iniciado tu solicitud de préstamo en {{ config('app.name') }}

@component('mail::panel')
**Correo registrado:** {{ $datos['correo'] }}
@endcomponent

@component('mail::button', ['url' => env('APP_URL') . '/home', 'color' => 'green'])
Continuar solicitud
@endcomponent

Saludos, Sacimex
@endcomponent
