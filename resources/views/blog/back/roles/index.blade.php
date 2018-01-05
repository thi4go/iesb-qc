@extends('blog.back.templates.default')

@section('title', 'Grupos')

@section('content')
<div class="row">
    <div class="panel panel-transparent">
        <div class="panel-heading m-b-15">
            <div class="row">
                <div class="col-xs-8">
                    <h3 class="no-margin">@yield('title')</h3>
                </div>
                <div class="col-xs-4 text-right">
                    @if(Permission::has('painel.roles.write'))
                    <a href="{{ route('painel.roles.create') }}" class="btn btn-success" title="Adicionar">Adicionar</a>
                    @endif
                    <a href="{{ route('painel.dashboard.index') }}" class="btn btn-danger hidden-xs" title="Voltar">Voltar</a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col-xs-1">Id</th>
                            <th class="col-xs-4">Grupo</th>
                            <th class="col-xs-2">Criado em</th>
                            <th class="col-xs-2">Atualizado em</th>
                            @if(Permission::has('painel.roles.write'))
                            <th class="col-xs-2 text-right">Ações</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $result)
                        <tr>
                            <td class="v-align-middle">
                                {{{ $result->id }}}
                            </td>
                            <td class="v-align-middle ">
                                {{{ $result->name }}}
                            </td>
                            <td class="v-align-middle ">
                                {{ $result->created_at->format('d/m/Y') }}
                            </td>
                            <td class="v-align-middle">
                                {{ $result->updated_at->format('d/m/Y') }}
                            </td>
                            @if(Permission::has('painel.roles.write'))
                            <td class="v-align-middle text-right">
                                <a href="{{ route('painel.roles.edit', $result->id) }}" class="btn btn-success btn-xs" title="Editar">Editar</a>
                                <a data-id="{{ $result->id }}" data-toggle="modal" data-target="#confirm-delete" data-href="{{ route('painel.roles.destroy', $result->id) }}" class="btn btn-danger btn-xs" title="Excluir">Excluir</a>
                            </td>
                            @endif
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
