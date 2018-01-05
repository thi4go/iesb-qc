@extends('dashboard.templates.quiz')

@section('title','Simulados')

@section('content')
    <quiz
            quiz-id="{{$quiz->idquiz}}"
            subject-id="{{$subjectId}}"
            subject-name="{{$quiz->subjects->text}}"
            user-id="{{$userId}}"
            title="@lang('generics.title')"
    >

    </quiz>




@endsection