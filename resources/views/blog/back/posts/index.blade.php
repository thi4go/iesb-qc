@extends('blog.back.templates.default')

@section('title', 'Posts')

@section('content')
<div class="row">
    <div class="panel panel-transparent">
        <div class="panel-heading m-b-15">
            <div class="row">
                <div class="col-xs-8">
                    <h3 class="no-margin">@yield('title')</h3>
                </div>
                <div class="col-xs-4 text-right">
                    <a href="{{ route('painel.dashboard.index') }}" class="btn btn-danger hidden-xs" title="Voltar">Voltar</a>
                    <a href="{{ route('painel.posts.create') }}" class="btn btn-success hidden-xs" title="Novo">Novo</a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col-xs-2">Categoria</th>
                            <th class="col-xs-3">Título</th>
                            <th class="col-xs-2">Avaliações</th>
                            <th class="col-xs-2">Média</th>
                            <th class="col-xs-2 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $result)
                        <tr>
                            <td class="v-align-middle ">
                                {{ $result->category->name }}
                            </td>
                            <td class="v-align-middle ">
                                {{ $result->title }}
                            </td>
                            <td class="v-align-middle ">
                                {{{ $result->ratings()->count() }}}
                            </td>
                            <td class="v-align-middle ">
                                {{{ round($result->ratingPercent(5), 2) }}}
                            </td>
                            <td class="v-align-middle text-right">
                                <a href="{{ route('painel.posts.edit', $result->id) }}" class="btn btn-success btn-xs" title="Editar">Editar</a>
                                <a data-id="{{ $result->id }}" data-toggle="modal" data-target="#confirm-delete" data-href="{{ route('painel.posts.destroy', $result->id) }}" class="btn btn-danger btn-xs" title="Excluir">Excluir</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {!! $data->render() !!}
        </div>
    </div>
</div>
@endsection
