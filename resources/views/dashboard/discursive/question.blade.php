@extends('dashboard.templates.default')
<script src="https://www.gstatic.com/firebasejs/3.6.2/firebase.js"></script>
<body class="dashboard discursives">
<main class="Main">

    @section('content')
        <discursive
                countQuestion="{{$countQuestion}}"
                questions="{{$questions}}"
                user-id="{{$userId}}"
                exam-name="@lang('generics.exam_name')"
                title="@lang('generics.title')"
        ></discursive>
    @endsection
</main>
</body>