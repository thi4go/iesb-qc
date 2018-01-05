<div class="Lightbox Search">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        {!! Form::open(['route' => 'posts.search', 'role' => 'search', 'method' => 'get', 'id' => 'searchForm']) !!}
        <input type="text" id="searchInput" class="Search-input" placeholder="O que você procura?" autocomplete="off">
        {!! Form::close() !!}
        <a href="javascript:" class="Search-close"><i class="Icon Icon--closeBefore"></i></a>
      </div>
      <div class="col-xs-12">
        <hr class="Search-separator">
      </div>
      <div class="col-xs-12">
        <div class="row">
          <div id="post-results"></div>
        </div>
      </div>
    </div>
  </div>
</div>
