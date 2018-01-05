@extends('blog.back.templates.default')

@section('title', 'Adicionar Post')

@section('content')
<div class="row">
    <div class="panel panel-transparent">
        <div class="panel-heading m-b-15">
            <div class="row">
                <div class="col-xs-8">
                    <h3 class="no-margin">@yield('title')</h3>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            {!! Form::model($data,['route' => ['painel.categories.edit', $data->id], 'method'=>'put', 'role' => 'form', 'files' => true]) !!}
            @include('blog.back.categories.form')
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
