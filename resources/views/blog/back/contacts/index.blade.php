@extends('blog.back.templates.default')

@section('title', 'Mensagens')

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
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col-xs-2">Recebido em</th>
                            <th class="col-xs-3">Nome</th>
                            <th class="col-xs-3">E-mail</th>
                            <th class="col-xs-2">Telefone</th>
                            <th class="col-xs-2 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $result)
                        <tr>
                            <td class="v-align-middle ">
                                {{ $result->created_at->format('d/m/Y') }}
                            </td>
                            <td class="v-align-middle ">
                                {{{ $result->name }}}
                            </td>
                            <td class="v-align-middle ">
                                {{{ $result->email }}}
                            </td>
                            <td class="v-align-middle ">
                                <span class="mask-phone">{{{ $result->phone }}}</span>
                            </td>
                            <td class="v-align-middle text-right">
                                <a href="{{ route('painel.contacts.show', $result->id) }}" class="btn btn-success btn-xs" title="Visualizar">Visualizar</a>
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
