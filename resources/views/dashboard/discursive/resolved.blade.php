@extends('dashboard.templates.default')
<script src="https://www.gstatic.com/firebasejs/3.6.2/firebase.js"></script>
<body class="dashboard discursives">
<main class="Main">

    @section('content')
        <discursive-resolved-questions
                :questions="{{$questions}}"
                exam-name="@lang('generics.exam_name')"
                title="@lang('generics.title')"
                user-id     = "{{$user->id}}"
        ></discursive-resolved-questions>
    @endsection
</main>
</body>