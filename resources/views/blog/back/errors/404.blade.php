@extends('blog.back.templates.error')

@section('content')
<div class="container-xs-height full-height">
    <div class="row-xs-height">
        <div class="col-xs-height col-middle">
            <div class="error-container text-center">
                <h1 class="error-number">404</h1>
                <h2 class="semi-bold">Página não encontrada</h2>
                <p>A página que você procura não foi encontrada. <a href="{{route('painel.dashboard.index')}}" title="Voltar">Voltar</a></p>
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
