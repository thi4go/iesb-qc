@extends('blog.back.templates.default')

@section('title', 'Acessos')

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
            <div class="row m-b-10">
                <div class="col-sm-12">
                    @include('blog.back.analytics.partials.visitors')
                </div>
            </div>
            <div class="row m-b-30">
                <div class="col-sm-6 col-md-3">
                    @include('blog.back.analytics.partials.pages')
                </div>
                <div class="col-sm-6 col-md-3">
                    @include('blog.back.analytics.partials.keywords')
                </div>
                <div class="col-sm-6 col-md-3">
                    @include('blog.back.analytics.partials.referrers')
                </div>
                <div class="col-sm-6 col-md-3">
                    @include('blog.back.analytics.partials.browsers')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extraJS')
{!! Html::script('/brzbox/assets/plugins/chartjs/Chart.min.js') !!}
@stop

