@extends('dashboard.templates.tutorialTemplate')

@section('content')

<section class="Dashboard Dashboard--call" style="background-color: #0d2540; margin-top: 70px">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 text-center">
                <h2 class="Dashboard-title">Bem vindo ao Tutorial!</h2>
            </div>
        </div>
    </div>
</section>
<div>

<tutorial
    user-id="{{$userId}}"
    token="{{$token}}"
    wizard="{{$wizard}}"
></tutorial>
</div>

@endsection
