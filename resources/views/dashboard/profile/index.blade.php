@extends('dashboard.templates.profile')

@section('content')
    <profile-wrapper
        user-name="{{$userName}}"
        avatar="{{$avatar}}"
        email="{{$email}}"
        gender="{{$gender}}"
        user-id="{{$userId}}"
        birth="{{$birth}}"
    >
    </profile-wrapper>
@endsection

