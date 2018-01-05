@if(count($posts) > 0)
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
@else
<div class="col-xs-12">
  <p>Nenhum resultado encontrado.</p>
</div>
@endif
