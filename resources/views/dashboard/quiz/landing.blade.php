@extends('dashboard.templates.quiz')
{{-- 
<body class='dashboard feedback'> --}}


@section('content')
	<quiz-landing
            total-studied="{{$totalStudied}}"
            subjects="{{$subjects}}"
            subjects-quiz="{{$subjectsQuiz}}"/>
@endsection