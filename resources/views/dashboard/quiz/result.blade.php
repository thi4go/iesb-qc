@extends('dashboard.templates.default')


@section('content')
        <feedback
                subject-name = "{{$subjectName}}"
                :user-id      = "{{$userId}}"
                :subject-id   = "{{$subjectId}}"
                title        = "@lang('generics.title')"
        >

        </feedback>



@endsection
