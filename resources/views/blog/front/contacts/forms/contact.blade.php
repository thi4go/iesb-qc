{!! Form::hidden('type_id', 1) !!}
<div class="row">
    <div class="col-sm-3">
        <div class="form-group {{ $errors->first('name', 'has-error') }}">
            {!! Form::label('name', 'Nome') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'required']) !!}
            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group {{ $errors->first('email', 'has-error') }}">
            {!! Form::label('email', 'E-mail') !!}
            {!! Form::text('email', null, ['class'=>'form-control', 'required']) !!}
            <span class="help-block">{{ $errors->first('email', ':message') }}</span>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group {{ $errors->first('phone', 'has-error') }}">
            {!! Form::label('phone', 'Telefone') !!}
            {!! Form::text('phone', null, ['class'=>'form-control mask-phone', 'required']) !!}
            <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group {{ $errors->first('subject', 'has-error') }}">
            {!! Form::label('subject', 'Assunto') !!}
            {!! Form::text('subject', null, ['class'=>'form-control', 'required']) !!}
            <span class="help-block">{{ $errors->first('subject', ':message') }}</span>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group {{ $errors->first('message', 'has-error') }}">
            {!! Form::label('message', 'Mensagem') !!}
            {!! Form::textarea('message', null, ['class'=>'form-control', 'rows' => '5', 'required']) !!}
            <span class="help-block">{{ $errors->first('message', ':message') }}</span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::submit('Enviar', ['class'=>'btn btn-success']) !!}
        </div>
    </div>
</div>
