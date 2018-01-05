@extends('dashboard.templates.default')

<body class='dashboard result'>

@section('content')
    <question-feedback
            :iduser    = "{{ $iduser }}"
            :subject   = "{{ $subject }}"
            :topics    = "{{ $topics }}"
            :idtopic   = "{{ $idtopic }}"
    />
@endsection
