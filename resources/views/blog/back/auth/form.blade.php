@include('flash::message', ['fixed' => false])

<div class="form-group form-group-default required">
    {!! Form::label('email', 'E-mail') !!}
    <div class="controls">
        {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Seu e-mail', 'required']) !!}
    </div>
</div>
<span class="error m-b-10">{{{ $errors->first('email', ':message') }}}</span>

<div class="form-group form-group-default required">
    {!! Form::label('password', 'Senha') !!}
    <div class="controls">
        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Sua senha', 'required']) !!}
    </div>
</div>
<span class="error m-b-10">{{{ $errors->first('password', ':message') }}}</span>

<div class="row">
    <div class="col-md-6">
        <div class="checkbox ">
            {!! Form::checkbox('remember', 'remember', null, ['id' => 'remember']) !!}
            {!! Form::label('remember', 'Lembrar meus dados') !!}
        </div>
    </div>
</div>

{!! Form::submit('Acessar', ['class' => 'btn btn-success btn-cons m-t-10']) !!}
