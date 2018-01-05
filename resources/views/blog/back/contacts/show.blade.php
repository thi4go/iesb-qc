@extends('blog.back.templates.default')

@section('title', 'Visualizar Mensagem')

@section('content')
<div class="row">
    <div class="panel panel-transparent">
        <div class="panel-heading m-b-15">
            <div class="row">
                <div class="col-xs-8">
                    <h3 class="no-margin">@yield('title')</h3>
                </div>
                <div class="col-xs-4 text-right">
                    <a href="{{ route('painel.contacts.index') }}" class="btn btn-danger hidden-xs" title="Voltar">Voltar</a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col-xs-2">Recebido em</th>
                            <th class="col-xs-3">Nome</th>
                            <th class="col-xs-4">E-mail</th>
                            <th class="col-xs-3">Telefone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="v-align-middle ">
                                {{ $data->created_at->format('d/m/Y') }}
                            </td>
                            <td class="v-align-middle">
                                {{{ $data->name }}}
                            </td>
                            <td class="v-align-middle ">
                                {{{ $data->email }}}
                            </td>
                            <td class="v-align-middle">
                                {{{ $data->phone }}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                {{{ $data->message }}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
