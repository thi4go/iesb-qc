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
        <div class="form-group form-group-default">
            {!! Form::label('email', 'E-mail') !!}
            {!! Form::email('email', null, ['class'=>'form-control', 'readonly']) !!}
        </div>
    </div>
</div>

<h5>Foto de Perfil</h5>

<div class="row clearfix">
    <div class="col-sm-4">
        <div class="fileinput fileinput-new form-group form-group-default input-group" data-provides="fileinput">
            {!! Form::label('avatar', 'Arquivo') !!}
            <div class="form-control" data-trigger="fileinput">
                <span class="fileinput-filename"></span>
            </div>
            <span class="input-group-addon btn-file">
                <i class="fa fa-image"></i>
                {!! Form::file('avatar') !!}
            </span>
            <a href="#" class="input-group-addon fileinput-exists" data-dismiss="fileinput"><i class="fa fa-close"></i></a>
        </div>
        <span class="error">{{{ $errors->first('avatar', ':message') }}}</span>
    </div>
    <div class="col-sm-8"></div>
</div>

<h5>Segurança</h5>

<div class="row clearfix">
    <div class="col-sm-4">
        <div class="form-group form-group-default">
            {!! Form::label('password', 'Senha') !!}
            {!! Form::password('password', ['class'=>'form-control']) !!}
        </div>
        <span class="error">{{{ $errors->first('password', ':message') }}}</span>
    </div>
    <div class="col-sm-4">
        <div class="form-group form-group-default">
            {!! Form::label('password_confirmation', 'Confirmar senha') !!}
            {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
        </div>
        <span class="error">{{{ $errors->first('password_confirmation', ':message') }}}</span>
    </div>
</div>

<div class="row clearfix m-t-15">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::submit('Atualizar', ['class'=>'btn btn-success']) !!}
            <a href="{{ route('painel.account.index') }}" class="btn btn-danger">Cancelar</a>
        </div>
    </div>
</div>
