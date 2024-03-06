@extends('layouts.app')

@section('template_title')
    {{ $solicitude->name ?? "{{ __('Show') Solicitude" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Detalles') }} de la solicitud</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('home') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">


                        <div class="row">
                            <strong>Resultados del crédito</strong>
                            <strong>Monto del crédito</strong>
                            <strong>{{$datos['Monto']}}</strong>
                            <strong>Plazo:</strong>
                            <strong>{{$datos['cuotasQuincenales']}} Quincenas</strong>
                            <strong>{{$datos['cuotasMensuales']}} Meses</strong>
                            <strong> Cuota quincenal   {{$datos['MontoCuotaQuincenal']}} </strong>
                            <strong> Cuota mensual   {{$datos['MontoCuotaMensual']}} </strong>
                            <strong>{{ $datos['retenciones'] }} Pagos retenidos</strong>
                            <strong>{{ $datos['montoRetenciones'] }}</strong>
                            <strong>Cobertura de riesgo{{ $datos['MontoSeguro'] }}</strong>
                            <strong>Monto a recibir {{$datos['montoRecibir']}}</strong>

                        </div>
                        
                        <div class="form-group">
                            <strong>Pagominimo:</strong>
                            {{ $solicitude->pagominimo }}
                        </div>
                        <div class="form-group">
                            <strong>Pagomaximo:</strong>
                            {{ $solicitude->pagomaximo }}
                        </div>
                        <div class="form-group">
                            <strong>Pagodeseado:</strong>
                            {{ $solicitude->pagodeseado }}
                        </div>
                        <div class="form-group">
                            <strong>Plazo:</strong>
                            {{ $solicitude->plazo }}
                        </div>
                        <div class="form-group">
                            <strong>Creditomaximo:</strong>
                            {{ $solicitude->creditomaximo }}
                        </div>
                        <div class="form-group">
                            <strong>Prestamosolicitado:</strong>
                            {{ $solicitude->prestamosolicitado }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $solicitude->estado }}
                        </div>
                        <div class="form-group">
                            <strong>Idcliente:</strong>
                            {{ $solicitude->idcliente }}
                        </div>


                        <div class="row col-3">
                            <a class="btn btn-primary  " href="{{ ''.$solicitude->id.'?opcion=imprimir' }}"> {{ __('Imprimir') }}</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
