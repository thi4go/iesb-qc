@extends('dashboard.templates.plans')

@section('content')
<div id="payment">
    <promo-subscription
            {{--avatar="{{}}"--}}
            name="Name"
            token="{{ csrf_token() }}"
            name="{{$userName}}"
            contact-email="@lang('generics.contact_email')"
    ></promo-subscription>
</div>

@endsection
