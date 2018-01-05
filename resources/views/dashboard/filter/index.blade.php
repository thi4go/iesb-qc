@extends('dashboard.templates.default')

<body class='dashboard filter'>
    @section('content')

    <question-filter :user="{{ $user }}"></question-filter>

    @endsection
</body>
