@extends('dashboard.templates.login')

@section('content')

    <register-page
        promowindow="@lang('urls.promo')"
        v-bind:org-id="{{env('PIPEDRIVE_ORGID')}}"
        v-bind:stage-id="{{env('PIPEDRIVE_STAGEID')}}"
    ></register-page>
@endsection
