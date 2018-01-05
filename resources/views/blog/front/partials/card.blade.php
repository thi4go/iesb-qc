<div class="Post">
  <a href="{{route('posts.view', [$posts[$i]->category->slug, $posts[$i]->slug, $posts[$i]->id])}}" class="Post-link" title="{{{$posts[$i]->title}}}">
    @if($posts[$i]->image)
    <img src="{{$posts[$i]->image->getUrl('thumbs')}}" alt="{{{$posts[$i]->title}}}" class="Post-image img-responsive" data-no-retina="true">
    @endif
    <h3 onmouseover="this.style.color = '{{$posts[$i]->category->color}}';" onmouseout="this.style.color = '#6f6f6e';" class="Post-title">{{{$posts[$i]->title}}}</h3>
  </a>
  <p class="Post-text">{{{$posts[$i]->subtitle}}}</p>
  <a href="{{route('posts.category', $posts[$i]->category->slug)}}" style="color: {{$posts[$i]->category->color}};" class="Post-category" title="{{{$posts[$i]->category->name}}}">{{{$posts[$i]->category->name}}}</a>
  <span class="Post-time">{{$posts[$i]->created_at->diffForHumans()}}</span>
  <a href="{{route('posts.author', $posts[$i]->user->slug)}}" class="Post-author" title="Posts de {{{$posts[$i]->user->full_name}}}">{{{$posts[$i]->user->full_name}}}</a>
</div>
