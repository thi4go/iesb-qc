<nav class="Navbar Navbar-down">
  <div class="container">
    <div class="row">
      <div class="col-xs-6 col-sm-3 col-md-2">
        <a href="{{route('homes.index')}}" class="Navbar-homeLink" title="Exame da OAB">
          <img src="/assets/images/logo.png" alt="Exame da OAB" class="Navbar-logo">
        </a>
      </div>
      <div class="hidden-xs col-sm-7 col-md-8">
        <ul class="Navbar-list">
          <li class="Navbar-listItem">
            <a href="{{route('posts.recent')}}" class="Navbar-listLink {{ AppHelper\setActive('posts') }}" title="Mais recentes">Mais recentes</a>
          </li>
          <li class="Navbar-listItem">
            <a href="{{route('posts.popular')}}" class="Navbar-listLink {{ AppHelper\setActive('posts/populares') }}" title="Posts populares">Posts populares</a>
          </li>
          <li class="Navbar-listItem">
            <a href="javascript:" class="Navbar-listLink Tags-open {{ AppHelper\setActive('posts/tag/*') }}" title="Tags">Tags</a>
          </li>
        </ul>
      </div>
      <div class="col-xs-6 col-sm-2 col-md-2">
        <ul class="Navbar-sideList list-unstyled">
          <li class="Navbar-sideItem">
            <a href="javascript:" class="Navbar-sideLink SlideMenu-open"><i class="Icon Icon--menuBefore"></i></a>
          </li>
          <li class="Navbar-sideItem">
            <a href="javascript:" class="Navbar-sideLink Search-open"><i class="Icon Icon--magnifierBefore"></i></a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
