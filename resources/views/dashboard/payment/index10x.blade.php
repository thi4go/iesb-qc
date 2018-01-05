@extends('dashboard.templates.plans')

@section('content')
<div>
    <promo-subscription-10x
            token="{{ csrf_token() }}",
            contact-email="@lang('generics.contact_email')"
    ></promo-subscription-10x>
</div>

@endsection
