@php
    use App\Models\User;
    use App\Models\Convenios;
    use App\Models\Solicitude;  
    use App\Models\Documentoscliente;
@endphp
@extends('layouts.app')

@section('template_title')
    {{ $cliente->name ?? "{{ __('Detalle del') Cliente" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Detalle del') }} cliente</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('clientes.index') }}"> {{ __('Atras') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Nombre:</strong>
                            {{ $cliente->nombre }}
                        </div>
                        <div class="form-group">
                            <strong>Telefono:</strong>
                            <a href='https://web.whatsapp.com/send/?phone=+52{{ $cliente->telefono }}'>{{ $cliente->telefono }}</a>
                        </div>
                        <div class="form-group">
                            <strong>Convenio:</strong>
                            {{ Convenios::find($cliente->convenio)->nombreCorto }}
                        </div>
                        <div class="form-group">
                            <strong>Ingresoquincenal:</strong>
                            {{ $cliente->ingresoquincenal }}
                        </div>
                        <div class="form-group">
                            <strong>Disponiblequincenal:</strong>
                            {{ $cliente->disponiblequincenal }}
                        </div>
                        <div class="form-group">
                            <strong>Correo:</strong>
                            {{ User::find($cliente->user_id)->email }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $cliente->estado }}
                        </div><div class="form-group">
                            <strong>Solicitud:</strong>
                            @php
                                $solicitud = Solicitude::where('idcliente',$cliente->id)->first();
                            @endphp
                            <a href="{{route('solicitudes.show',$solicitud->id)}}" class="btn btn-success btn-sm"> {{ __('Ver Solicitud') }}</a>
                        </div>
                        <div class="float-right">
                            <form action="{{ route('clientes.update',$cliente->id) }}" method="POST">
                                {{ method_field('PATCH') }}
                                @csrf
                                <input name="estado" type="hidden"  value="Aprobado" />
                                <button type="submit" class="btn btn-success btn-sm"> {{ __('Aprobar') }}</button>
                            </form>
                        </div>
                        <div class="float-right">
                            <form action="{{ route('clientes.update',$cliente->id) }}" method="POST">
                                {{ method_field('PATCH') }}
                                @csrf
                                <input name="estado" type="hidden"  value="Rechazado" />
                                <button type="submit" class="btn btn-danger btn-sm"> {{ __('Rechazar') }}</button>
                            </form>
                        </div>
                        <div class="float-right">
                            <form action="{{ route('clientes.destroy',$cliente->id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"> {{ __('Eliminar') }}</button>
                            </form>
                        </div>
                        @php
                            $documentos = Documentoscliente::where('idcliente',$cliente->id)->get();
                        @endphp
                        @if(count($documentos)>0)
                            <div class="float-right">
                                <a class="btn btn-info btn-sm" href="{{route('file-upload',['idcliente'=>$cliente->id])}}">Ver documentos</a>
                            </div>
                        @endif
                        

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
