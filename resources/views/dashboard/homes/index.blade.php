@extends('dashboard.templates.default')

@section('content')

<body >

    <dashboard-panel
            total-studied = "{{$totalStudied}}"
            subjects      = "{{$subjects}}"
            subjects-quiz = "{{$subjectsQuiz}}"
            user-id       = "{{$userId}}"
            user-efficiency = "{{$userEfficiency}}"
            quiz-count     = "{{$quizCount}}"
    ></dashboard-panel>

    {{-- @include('dashboard.partials.steps') --}}

</body>
@endsection
