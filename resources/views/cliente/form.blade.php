<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $cliente->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('telefono') }}
            {{ Form::text('telefono', $cliente->telefono, ['class' => 'form-control' . ($errors->has('telefono') ? ' is-invalid' : ''), 'placeholder' => 'Telefono']) }}
            {!! $errors->first('telefono', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('ingresoquincenal') }}
            {{ Form::text('ingresoquincenal', $cliente->ingresoquincenal, ['class' => 'form-control' . ($errors->has('ingresoquincenal') ? ' is-invalid' : ''), 'placeholder' => 'Ingresoquincenal']) }}
            {!! $errors->first('ingresoquincenal', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('disponiblequincenal') }}
            {{ Form::text('disponiblequincenal', $cliente->disponiblequincenal, ['class' => 'form-control' . ($errors->has('disponiblequincenal') ? ' is-invalid' : ''), 'placeholder' => 'Disponiblequincenal']) }}
            {!! $errors->first('disponiblequincenal', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('ajuste') }}
            {{ Form::text('ajuste', $cliente->ajuste, ['class' => 'form-control' . ($errors->has('ajuste') ? ' is-invalid' : ''), 'placeholder' => 'Ajuste']) }}
            {!! $errors->first('ajuste', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <!--
        <div class="form-group">
            {{ Form::label('user_id') }}
            {{ Form::text('user_id', $cliente->user_id, ['class' => 'form-control' . ($errors->has('user_id') ? ' is-invalid' : ''), 'placeholder' => 'User Id']) }}
            {!! $errors->first('user_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        -->
        {{Form::hidden('user_id',$userid)}}
        {{Form::hidden('confirmaciontelefono', $cliente->confirmaciontelefono) }}

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
    </div>
</div>