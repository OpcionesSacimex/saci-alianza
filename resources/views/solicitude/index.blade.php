@php
    use App\Models\Cliente;
@endphp
@extends('layouts.app')

@section('template_title')
    Solicitude
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Solicitude') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('solicitudes.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Pagominimo</th>
										<th>Pagomaximo</th>
										<th>Pagodeseado</th>
										<th>Plazo</th>
										<th>Creditomaximo</th>
										<th>Prestamosolicitado</th>
										<th>Estado</th>
										<th>Cliente</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($solicitudes as $solicitude)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $solicitude->pagominimo }}</td>
											<td>{{ $solicitude->pagomaximo }}</td>
											<td>{{ $solicitude->pagodeseado }}</td>
											<td>{{ $solicitude->plazo }}</td>
											<td>{{ $solicitude->creditomaximo }}</td>
											<td>{{ $solicitude->prestamosolicitado }}</td>
											<td>{{ $solicitude->estado }}</td>
											<td>{{ Cliente::find($solicitude->idcliente)->nombre }}</td>

                                            <td>
                                                <form action="{{ route('solicitudes.destroy',$solicitude->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('solicitudes.show',$solicitude->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('solicitudes.edit',$solicitude->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $solicitudes->links() !!}
            </div>
        </div>
    </div>
@endsection
