@extends('blog.front.templates.home')

@section('content')
<section class="Content Content--postsHome">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-4">
        @for($i = 0; $i < count($posts); $i++)
          @if($i % 3 == 0)
            @include('blog.front.partials.card')
          @endif
        @endfor
      </div>
      <div class="col-xs-12 col-sm-4">
        @for($i = 0; $i < count($posts); $i++)
          @if($i % 3 == 1)
            @include('blog.front.partials.card')
          @endif
        @endfor
      </div>
      <div class="col-xs-12 col-sm-4">
        @for($i = 0; $i < count($posts); $i++)
          @if($i % 3 == 2)
            @include('blog.front.partials.card')
          @endif
        @endfor
      </div>
    </div>
  </div>
</section>
@endsection
