@extends('dashboard.templates.default')

@section('content')

    <question-resolution
            :subject    = "{{ $subject }}"
            :topic      = "{{ $topic   }}"
            :questions  = "{{ $questions }}"
            :user       = "{{ $user }}"
            :count      = "{{ $count }}"
            generic     = "{{ $generic }}"
            :user-id    = "{{ $userId }}"
            :status     = "{{ $status }}"
            :start-year = "{{$startYear}}"
            :end-year   = "{{$endYear}}"
            key-word    = "{{$keyWord}}"
            title      =  "@lang('generics.title')"
    >
    </question-resolution>
@endsection
