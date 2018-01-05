@extends('dashboard.templates.default')

@section('title','Controle')

@section('content')
    <cycle-wrapper
        :user="{{$user}}">
        
    </cycle-wrapper>
@endsection
