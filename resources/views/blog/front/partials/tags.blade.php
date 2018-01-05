<div class="Lightbox Tags">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 text-right">
        <a href="javascript:" class="Tags-close" title="Fechar"><i class="Icon Icon--closeBefore"></i></a>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 col-md-8 col-md-offset-2">
        <ul class="Tags-list list-inline">
          @foreach($tags as $tag)
          <li class="Tags-listItem">
            <a href="{{route('posts.tag', $tag->slug)}}" class="Tags-link" title="{{{ $tag->name }}}">{{{ $tag->name }}}</a>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
