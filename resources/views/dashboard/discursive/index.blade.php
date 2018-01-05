@extends('dashboard.templates.default')

<body class='dashboard filter'>
@section('content')

                    <discursive-filter
                        subjects    = "{{$subjects}}"
                        count       = "{{$count}}"
                        user-id     = "{{$userId}}"
                    />

@endsection
</body>