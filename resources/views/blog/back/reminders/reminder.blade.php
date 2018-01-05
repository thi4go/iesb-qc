@extends('blog.back.templates.default')

@section('title', 'Esqueci minha senha')

@section('content')
<div class="register-container full-height sm-p-t-30">
    <div class="container-sm-height full-height">
        <div class="row row-sm-height">
            <div class="col-sm-12 col-sm-height col-middle">
                <img src="{{ asset('/brzbox/assets/img/brzLogo.png') }}" alt="logo" data-src="{{ asset('/brzbox/assets/img/brzLogo.png') }}" data-src-retina="{{ asset('/brzbox/assets/img/brzLogo2x.png') }}" width="150" height="35">
                <p>Para redefinir sua senha, informe abaixo o seu e-mail.</p>

                {!! Form::open(['route' => 'painel.reminders.reminder', 'method' => 'POST', 'id' => 'form-recover', 'class' => 'p-t-15', 'role' => 'form']) !!}

                @include('flash::message', ['fixed' => false])

                <div>
                    <div class="form-group form-group-default required">
                        {!! Form::label('email', 'E-mail') !!}
                        {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'E-mail utilizado ao criar sua conta', 'required']) !!}
                    </div>
                    <span class="error">{{{ $errors->first('email', ':message') }}}</span>
                </div>

                {!! Form::submit('Enviar', ['class' => 'btn btn-success btn-cons m-t-10']) !!}

                <a href="{{ route('painel.auth.login') }}" class="btn btn-danger btn-cons m-t-10" title="Cancelar">Cancelar</a>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<div class="pull-bottom xs-pull-bottom full-width">
    <div class="col-xs-12 text-center m-b-30">
        <a href="{{ url('http://brzdigital.com.br') }}" target="_blank" title="Made in BRZ"><img class="m-t-5" src="{{ asset('/brzbox/assets/img/author.png') }}" data-src="{{ asset('/brzbox/assets/img/author.png') }}" data-src-retina="{{ asset('/brzbox/assets/img/author2x.png') }}" alt="Made in BRZ" width="82" height="20"></a>
    </div>
</div>
@endsection
