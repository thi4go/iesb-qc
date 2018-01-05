@extends('dashboard.templates.default')

@section('content')

    <lesson-wrapper
        :course = "{{ $course }}"
        :lesson = "{{ $lesson }}"
        :related = "{{ $related }}"
        :user-id = "{{ $userId }}"
    />

@endsection
