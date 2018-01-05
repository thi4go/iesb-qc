<section class="Home">
  <nav class="HomeNav">
    <div class="container">
      <div class="row">
        <div class="col-xs-6 col-sm-3 col-md-2">
          <a href="{{route('homes.index')}}" class="HomeNav-homeLink" title="Exame da OAB">
            <img src="{{asset('/assets/images/logo.png')}}" alt="Exame da OAB" class="HomeNav-logo">
          </a>
        </div>
        <div class="col-xs-6 col-sm-2 col-sm-offset-8">
          <ul class="HomeNav-sideList list-unstyled">
            <li class="HomeNav-sideItem"><a href="javascript:" class="HomeNav-sideLink SlideMenu-open"><i class="Icon Icon--menuBefore"></i></a></li>
            <li class="HomeNav-sideItem"><a href="javascript:" class="HomeNav-sideLink Search-open"><i class="Icon Icon--magnifierBefore"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <div class="Home-slider">
    @if(count($releases) > 0)
    <div class="Home-slidershow owl-carousel">
      @foreach($releases as $release)
      <div class="Home-sliderItem item">
        @if($release->image)
        <div class="Home-sliderBackground" style="background-image: url({{$release->image->getUrl('cover')}});"></div>
        @endif
        <div class="u-table">
          <div class="u-vAlign">
            <div class="container">
              <div class="row">
                <div class="col-sm-7">
                  <div class="Home-sliderCaption">
                    <a href="{{route('posts.view', [$release->category->slug, $release->slug, $release->id])}}" class="Home-sliderLink" title="{{{$release->title}}}">
                      <h2 class="Home-sliderTitle">{{{$release->title}}}</h2>
                    </a>
                    <div class="row Home-sliderText">
                      <div class="col-sm-5">
                        <a href="{{route('posts.category', $release->category->slug)}}" class="Home-sliderCategory" title="{{{$release->category->name}}}">{{{$release->category->name}}}</a>
                      </div>
                      <div class="col-sm-6">
                        <p class="Home-sliderSubtitle">{{{$release->subtitle}}}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <div class="Home-sliderDots"></div>
    @endif
  </div>
  <div class="Home-side">
    <div class="container">
      <div class="row">
        <div class="col-xs-2 col-xs-offset-10">
          <ul class="Home-social list-unstyled hidden-xs">
            <li class="Home-socialItem">
              <a href="https://www.facebook.com/Engenharia-Civil-Máquina-de-Aprovação-em-Concursos-1672942099672575/" class="Home-socialLink" title="Facebook" target="_blank"><i class="Icon Icon--facebookBefore"></i></a>
            </li>
            <li class="Home-socialItem">
              <a href="https://twitter.com/qualconcurso" class="Home-socialLink" title="Twitter" target="_blank"><i class="Icon Icon--twitterBefore"></i></a>
            </li>
            <li class="Home-socialItem">
              <a href="https://instagram.com/qualconcurso.com.br/" class="Home-socialLink" title="Instagram" target="_blank"><i class="Icon Icon--instagramBefore"></i></a>
            </li>
            <li class="Home-socialItem">
              <a href="https://www.youtube.com/channel/UCe54zjFcV4xpyYMoqB_7GfQ" class="Home-socialLink" title="Youtube" target="_blank"><i class="Icon Icon--youtubeBefore"></i></a>
            </li>
            <li class="Home-socialItem">
              <a href="https://linkedin.com/company/qual-concurso" class="Home-socialLink" title="Linkedin" target="_blank"><i class="Icon Icon--linkedinBefore"></i></a>
            </li>
          </ul>
          @if(count($posts) > 0)
          <a href="javascript:" class="Home-next Icon Icon--doubleArrowDownBefore"></a>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
