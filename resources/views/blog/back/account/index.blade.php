@extends('blog.back.templates.default')

@section('title', 'Meu Perfil')

@section('content')
<div class="row">
    <div class="panel panel-transparent">
        <div class="panel-heading m-b-15">
            <div class="row">
                <div class="col-xs-8">
                    <h3 class="no-margin">@yield('title')</h3>
                </div>
                <div class="col-xs-4 text-right">
                    <a href="{{ route('painel.account.edit') }}" class="btn btn-success" title="Editar">Editar</a>
                    <a href="{{ route('painel.dashboard.index') }}" class="btn btn-danger hidden-xs" title="Voltar">Voltar</a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="m-b-10">
                <div class="social-user-profile col-xs-height text-center col-top">
                    <div class="thumbnail-wrapper d48 circular bordered b-white">
                        <img src="{{ $data->avatar }}" alt="Foto de perfil" width="55" height="55">
                    </div>
                </div>
                <div class="col-xs-height p-l-20">
                    <h3 class="no-margin">{{ $data->full_name }} </h3>
                    <p class="no-margin hint-text m-t-5 small">{{ $data->email }}</p>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Últimas atividades</div>
                </div>
                <div class="panel-body">
                    @forelse($logs as $result)
                    <ul class="list-unstyled">
                        <li>
                            <span>{!! "{$result->name} {$result->description} <b>{$result->linked}</b>" !!}</span>
                            <small class="text-muted">{{ $result->created_at->diffForHumans() }}</small>
                        </li>
                    </ul>
                    @empty
                    <small class="text-muted m-b-0">Nenhuma atividade realizada.</small>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
