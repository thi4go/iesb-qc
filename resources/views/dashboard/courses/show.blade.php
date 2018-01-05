@extends('dashboard.templates.default')

@section('content')

    <course-show
        :course = "{{ $course }}"
    />
@endsection
