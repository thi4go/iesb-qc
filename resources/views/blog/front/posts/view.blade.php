@extends('blog.front.templates.default')

@section('content')
<section class="Article">
  <header class="Article-header">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-md-8 col-md-offset-2">
          <h1 style="color: {{$post->category->color}};" class="Article-title">{{$post->title}}</h1>
          <h3 class="Article-subtitle">{{$post->subtitle}}</h3>
          <a href="{{route('posts.category', $post->category->slug)}}" style="color: {{$post->category->color}};" class="Article-category" title="{{{$post->category->name}}}">{{{$post->category->name}}}</a>
          <span class="Article-time">{{$post->created_at->diffForHumans()}}</span>
          <a href="{{route('posts.author', $post->user->slug)}}" class="Article-author" title="Posts de {{{$post->user->full_name}}}">por <strong>{{$post->user->fullName}}</strong></a>
        </div>
      </div>
    </div>
  </header>
  @if($post->image)
  <div style="background-image: url({{$post->image->getUrl('cover')}})" class="Article-image">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-md-8 col-md-offset-2">
          <p class="Article-imageCaption"><i class="Icon Icon--pictureBefore Article-captionIcon"></i><span>Reprodução</span></p>
        </div>
      </div>
    </div>
  </div>
  @endif
  <article class="Article-content">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-md-8 col-md-offset-2">
          <article class="Article-text">{!! $post->text !!}</article>
          <ul class="Article-tags list-inline">
            @foreach($post->tags as $tag)
              <li class="Article-tagsItem">
                <a href="{{route('posts.tag', $tag->slug)}}" class="Article-tagsLink" title="{{{$tag->name}}}">{{{$tag->name}}}</a>
              </li>
            @endforeach
          </ul>
          <div class="Rating" data-id="{{ $post->id }}" data-token="{!! csrf_token() !!}">
            <button data-value="1" class="Rating-stars Rating-stars--1 Icon Icon--starBefore" title="1 estrela"><span class="sr-only">1</span></button>
            <button data-value="2" class="Rating-stars Rating-stars--2 Icon Icon--starBefore" title="2 estrelas"><span class="sr-only">2</span></button>
            <button data-value="3" class="Rating-stars Rating-stars--3 Icon Icon--starBefore" title="3 estrelas"><span class="sr-only">3</span></button>
            <button data-value="4" class="Rating-stars Rating-stars--4 Icon Icon--starBefore" title="4 estrelas"><span class="sr-only">4</span></button>
            <button data-value="5" class="Rating-stars Rating-stars--5 Icon Icon--starBefore" title="5 estrelas"><span class="sr-only">5</span></button>
          </div>
        </div>
      </div>
    </div>
  </article>

    <div class="container">
      <div class="col-xs-12 col-md-8 col-md-offset-2">

      </div>
    </div><br>


  <aside class="Recommended">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-md-8 col-md-offset-2">
          <h4 class="Recommended-title">recomendados para você</h4>
          @foreach($recommended as $post)
          <div class="RecommendedArticle">
            <a href="{{route('posts.view', [$post->category->slug, $post->slug, $post->id])}}" title="{{{$post->title}}}">
              <h5 onmouseover="this.style.color = '{{$post->category->color}}';" onmouseout="this.style.color = '#6f6f6e';" class="RecommendedArticle-title">{{{$post->title}}}</h5>
            </a>
            <a href="{{route('posts.category', $post->category->slug)}}" title="{{{$post->category->name}}}">
              <span style="color: {{$post->category->color}};" class="RecommendedArticle-category">{{{$post->category->name}}}</span>
            </a>
            <span class="RecommendedArticle-time">{{$post->created_at->diffForHumans()}}</span>
            <a href="{{route('posts.author', $post->user->slug)}}" title="Posts de {{$post->user->full_name}}">
              <span class="RecommendedArticle-author">{{$post->user->full_name}}</span>
            </a>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </aside>

  <footer class="Comments">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-md-8 col-md-offset-2">
          <div data-href="{{Request::url()}}" data-width="100%" class="fb-comments"></div>
        </div>
      </div>
    </div>
  </footer>
</section>

<div class="Share">
  <ul class="Share-list">
    <li class="Share-item">
      <a href="#" data-title="{{$post->title}}" data-url="{{ Request::url() }}" title="Compartilhar no Facebook" class="Share-link Share-link--facebook Icon Icon--facebookBefore facebook"><span class="sr-only">Compartilhar no Facebook</span></a>
    </li>
    <li class="Share-item">
      <a href="#" data-title="{{$post->title}}" data-url="{{ Request::url() }}" title="Compartilhar no Twitter" class="Share-link Share-link--twitter Icon Icon--twitterBefore twitter"><span class="sr-only">Compartilhar no Twitter</span></a>
    </li>
    <li class="Share-item">
      <a href="#" data-title="{{$post->title}}" data-url="{{ Request::url() }}" title="Compartilhar no Google+" class="Share-link Share-link--googleplus Icon Icon--googleplusBefore googleplus"><span class="sr-only">Compartilhar no Google+</span></a>
    </li>
  </ul>
</div>
@endsection
