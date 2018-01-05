<div id="menuMask" class="MenuMask"></div>
<nav class="SlideMenu"><a href="javascript:" class="SlideMenu-close"><i class="Icon Icon--closeBefore"></i></a>
  <ul class="SlideMenu-list list-unstyled">
    <li class="SlideMenu-listItem">
      <a href="{{route('homes.index')}}" class="SlideMenu-link {{ AppHelper\setActive('/') }}" title="Home">Home</a>
    </li>
    <li class="SlideMenu-listItem">
      <a href="{{route('posts.recent')}}" class="SlideMenu-link {{ AppHelper\setActive('posts') }}" title="Recentes">Recentes</a>
    </li>
    <li class="SlideMenu-listItem">
      <a href="{{route('posts.popular')}}" class="SlideMenu-link {{ AppHelper\setActive('posts/populares') }}" title="Populares">Populares</a>
    </li>
    @foreach($categories as $category)
    <li class="SlideMenu-listItem">
      <a href="{{route('posts.category', $category->slug)}}" class="SlideMenu-link {{ AppHelper\setActive("posts/{$category->slug}") }}" title="{{{$category->name}}}">{{{$category->name}}}</a>
    </li>
    @endforeach
  </ul>
  <ul class="SlideMenu-subList list-unstyled">
    <li class="SlideMenu-subListItem">
      <a href="http://maquinadeaprovacao.com" class="SlideMenu-subLink" title="Conheça" target="_blank">Conheça</a>
    </li>
    <li class="SlideMenu-subListItem">
      <a href="http://promo.examedaoab.com/82off" class="SlideMenu-subLink" title="Cadastre-se" target="_blank">Cadastre-se</a>
    </li>
    {{--<li class="SlideMenu-subListItem">--}}
      {{--<a href="http://qualconcurso.com.br/contato" class="SlideMenu-subLink" title="Fale conosco" target="_blank">Fale conosco</a>--}}
    {{--</li>--}}
  </ul>
  <ul class="SlideMenu-social list-inline">
    <li class="SlideMenu-socialItem">
      <a href="https://www.facebook.com/engcivilconcursos/" class="SlideMenu-socialLink" title="Facebook" target="_blank"><i class="Icon Icon--facebookBefore"></i></a>
    </li>
    <li class="SlideMenu-socialItem">
      <a href="https://twitter.com/qualconcurso" class="SlideMenu-socialLink" title="Twitter" target="_blank"><i class="Icon Icon--twitterBefore"></i></a>
    </li>
    <li class="SlideMenu-socialItem">
      <a href="https://instagram.com/qualconcurso.com.br/" class="SlideMenu-socialLink" title="Instagram" target="_blank"><i class="Icon Icon--instagramBefore"></i></a>
    </li>
    <li class="SlideMenu-socialItem">
      <a href="https://www.youtube.com/channel/UCe54zjFcV4xpyYMoqB_7GfQ" class="SlideMenu-socialLink" title="Youtube" target="_blank"><i class="Icon Icon--youtubeBefore"></i></a>
    </li>
    <li class="SlideMenu-socialItem">
      <a href="https://linkedin.com/company/qual-concurso" class="SlideMenu-socialLink" title="Linkedin" target="_blank"><i class="Icon Icon--linkedinBefore"></i></a>
    </li>
  </ul>
</nav>
