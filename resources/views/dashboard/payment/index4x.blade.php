@extends('dashboard.templates.plans')

@section('content')
    <div>
        <promo-subscription-4x
                token="{{ csrf_token() }}"
                contact-email="@lang('generics.contact_email')"
        ></promo-subscription-4x>
    </div>

@endsection
