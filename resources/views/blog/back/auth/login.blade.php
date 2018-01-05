@extends('blog.back.templates.default')

@section('title', 'Acessar')

@section('content')
<div class="login-wrapper ">
    <div class="bg-pic">
        <img src="{{ asset('/brzbox/assets/img/brzBg.jpg') }}" data-src="{{ asset('/brzbox/assets/img/brzBg.jpg') }}" data-src-retina="{{ asset('/brzbox/assets/img/brzBg.jpg') }}" class="lazy">
    </div>
    <div class="login-container bg-white">
        <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
            <img src="{{ asset('/brzbox/assets/img/brzLogo.png') }}" alt="logo" data-src="{{ asset('/brzbox/assets/img/brzLogo.png') }}" data-src-retina="{{ asset('/brzbox/assets/img/brzLogo2x.png') }}" width="150" height="35">
            <p class="p-t-35">Faça login para continuar</p>

            {!! Form::open(['route' => 'painel.auth.login', 'method' => 'POST', 'id' => 'form-login', 'class' => 'p-t-15', 'role' => 'form']) !!}
            @include('blog.back.auth.form')
            {!! Form::close() !!}

            <div class="row">
                <div class="m-t-20 m-b-20 col-xs-12">
                    <a href="{{ route('painel.reminders.reminder') }}" class="text-info small" title="Esqueceu sua senha?">Esqueceu sua senha?</a>
                </div>
            </div>

            <div class="pull-bottom xs-pull-bottom">
                <div class="m-b-30 p-r-80 sm-m-t-20 sm-p-r-15 sm-p-b-20 clearfix">
                    <div class="col-sm-3 col-md-2 no-padding">
                        <a href="{{ url('http://brzdigital.com.br') }}" target="_blank" title="Made in BRZ"><img class="m-t-5" src="{{ asset('/brzbox/assets/img/author.png') }}" data-src="{{ asset('/brzbox/assets/img/author.png') }}" data-src-retina="{{ asset('/brzbox/assets/img/author2x.png') }}" alt="Made in BRZ" width="82" height="20"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
