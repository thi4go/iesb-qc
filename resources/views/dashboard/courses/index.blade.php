@extends('dashboard.templates.default')

@section('content')

<course-wrapper
    :courses = "{{$courses}}"
    :user    = "{{$user}}"
/>

@endsection
