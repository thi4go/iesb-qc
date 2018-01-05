<h5>Seus dados</h5>

<div class="row clearfix">
    <div class="col-sm-4">
        <div class="form-group form-group-default required">
            {!! Form::label('first_name', 'Nome') !!}
            {!! Form::text('first_name', null, ['class'=>'form-control', 'required']) !!}
        </div>
        <span class="error">{{{ $errors->first('first_name', ':message') }}}</span>
    </div>
    <div class="col-sm-4">
        <div class="form-group form-group-default required">
            {!! Form::label('last_name', 'Sobrenome') !!}
            {!! Form::text('last_name', null, ['class'=>'form-control', 'required']) !!}
        </div>
        <span class="error">{{{ $errors->first('last_name', ':message') }}}</span>
    </div>
    <div class="col-sm-4">
        <div class="form-group form-group-default required">
            {!! Form::label('email', 'E-mail') !!}
            {!! Form::email('email', null, ['class'=>'form-control', 'required']) !!}
        </div>
        <span class="error">{{{ $errors->first('email', ':message') }}}</span>
    </div>
</div>

<h5>Segurança</h5>

<div class="row clearfix">
    <div class="col-sm-3">
        <div class="form-group form-group-default">
            {!! Form::label('password', 'Senha') !!}
            {!! Form::password('password', ['class'=>'form-control']) !!}
        </div>
        <span class="error">{{{ $errors->first('password', ':message') }}}</span>
    </div>
    <div class="col-sm-3">
        <div class="form-group form-group-default">
            {!! Form::label('password_confirmation', 'Confirmar senha') !!}
            {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
        </div>
        <span class="error">{{{ $errors->first('password_confirmation', ':message') }}}</span>
    </div>
</div>

<h5>Permissões</h5>

<div class="row clearfix">
    <div class="col-sm-4">
        <div class="form-group form-group-default form-group-default-select2">
            {!! Form::label('roles[]', 'Grupo') !!}
            {!! Form::select('roles[]', $roles, isset($userRoles) ? $userRoles : null, ['class' => 'full-width', 'data-init-plugin' => 'select2', 'multiple' => 'multiple']) !!}
        </div>
        <span class="error">{{{ $errors->first('roles', ':message') }}}</span>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <hr>
        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-success']) !!}
            <a href="{{ route('painel.users.index') }}" class="btn btn-danger" title="Cancelar">Cancelar</a>
        </div>
    </div>
</div>
