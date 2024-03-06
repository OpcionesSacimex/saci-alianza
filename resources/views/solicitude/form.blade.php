<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('pagominimo') }}
            {{ Form::text('pagominimo', $solicitude->pagominimo, ['class' => 'form-control' . ($errors->has('pagominimo') ? ' is-invalid' : ''), 'placeholder' => 'Pagominimo']) }}
            {!! $errors->first('pagominimo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('pagomaximo') }}
            {{ Form::text('pagomaximo', $solicitude->pagomaximo, ['class' => 'form-control' . ($errors->has('pagomaximo') ? ' is-invalid' : ''), 'placeholder' => 'Pagomaximo']) }}
            {!! $errors->first('pagomaximo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('pagodeseado') }}
            {{ Form::text('pagodeseado', $solicitude->pagodeseado, ['class' => 'form-control' . ($errors->has('pagodeseado') ? ' is-invalid' : ''), 'placeholder' => 'Pagodeseado']) }}
            {!! $errors->first('pagodeseado', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('plazo') }}
            {{ Form::text('plazo', $solicitude->plazo, ['class' => 'form-control' . ($errors->has('plazo') ? ' is-invalid' : ''), 'placeholder' => 'Plazo']) }}
            {!! $errors->first('plazo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('creditomaximo') }}
            {{ Form::text('creditomaximo', $solicitude->creditomaximo, ['class' => 'form-control' . ($errors->has('creditomaximo') ? ' is-invalid' : ''), 'placeholder' => 'Creditomaximo']) }}
            {!! $errors->first('creditomaximo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('prestamosolicitado') }}
            {{ Form::text('prestamosolicitado', $solicitude->prestamosolicitado, ['class' => 'form-control' . ($errors->has('prestamosolicitado') ? ' is-invalid' : ''), 'placeholder' => 'Prestamosolicitado']) }}
            {!! $errors->first('prestamosolicitado', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <!--
        <div class="form-group">
            {{ Form::label('estado') }}
            {{ Form::text('estado', $solicitude->estado, ['class' => 'form-control' . ($errors->has('estado') ? ' is-invalid' : ''), 'placeholder' => 'Estado']) }}
            {!! $errors->first('estado', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        -->
        {{ Form::hidden('estado','En proceso')}}
        <!--
        <div class="form-group">
            {{ Form::label('idcliente') }}
            {{ Form::text('idcliente', $solicitude->idcliente, ['class' => 'form-control' . ($errors->has('idcliente') ? ' is-invalid' : ''), 'placeholder' => 'Idcliente']) }}
            {!!$errors->first('idcliente', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        -->
        {{Form::hidden('idcliente',$idcliente)}}
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
    </div>
</div>