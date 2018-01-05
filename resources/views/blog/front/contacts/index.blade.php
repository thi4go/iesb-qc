@extends('blog.front.templates.default')

@section('content')
<section class="Section Section--contact">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>Contato</h2>
            </div>
            <div class="col-xs-12">
                @include('flash::message', ['fixed' => false])
                {!! Form::open(['route' => 'contacts.store', 'method'=>'post', 'role' => 'form']) !!}
                @include('front.contacts.forms.contact')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection
