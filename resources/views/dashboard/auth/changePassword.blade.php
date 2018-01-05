@extends('dashboard.templates.login')

@section('content')

    <change-password
            user-id     = "{{$userId}}"
            expired     = "{{$expired}}"
            user-name   = "{{$name}}"
    ></change-password>

@endsection
