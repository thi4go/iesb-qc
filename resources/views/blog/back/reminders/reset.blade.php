@extends('blog.back.templates.default')

@section('title', 'Cadastrar nova senha')

@section('content')
<div class="register-container full-height sm-p-t-30">
    <div class="container-sm-height full-height">
        <div class="row row-sm-height">
            <div class="col-sm-12 col-sm-height col-middle">
                <img src="{{ asset('/brzbox/assets/img/brzLogo.png') }}" alt="logo" data-src="{{ asset('/brzbox/assets/img/brzLogo.png') }}" data-src-retina="{{ asset('/brzbox/assets/img/brzLogo2x.png') }}" width="150" height="35">
                <p>Informe sua nova senha abaixo.</p>

                {!! Form::open(['route' => ['painel.reminders.reset', $id, $code], 'method' => 'POST', 'id' => 'form-recover', 'class' => 'p-t-15', 'role' => 'form']) !!}

                @include('flash::message', ['fixed' => false])

                <div>
                    <div class="form-group form-group-default required">
                        {!! Form::label('password', 'Senha') !!}
                        {!! Form::password('password', ['class'=>'form-control']) !!}
                    </div>
                    <span class="error">{{{ $errors->first('password', ':message') }}}</span>
                </div>

                <div>
                    <div class="form-group form-group-default required">
                        {!! Form::label('password_confirmation', 'Confirmar senha') !!}
                        {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
                    </div>
                    <span class="error">{{{ $errors->first('password_confirmation', ':message') }}}</span>
                </div>

                {!! Form::submit('Atualizar', ['class' => 'btn btn-success btn-cons m-t-10']) !!}

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
