@component('mail::message')
# ¡Nuevo usuario registrado!

Un usuario acaba de comenzar su registro

@component('mail::panel')
**Correo registrado:** {{ $email }}
@endcomponent


@endcomponent