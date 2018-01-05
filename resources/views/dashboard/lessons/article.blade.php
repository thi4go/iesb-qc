<section class="Module container" xmlns="http://www.w3.org/1999/html">
  <div class="Dashboard Dashboard--section u-m-t-20">
    <h2 class="Dashboard-title Dashboard-title--color30">{!! $lesson->title !!}</h2>
  </div>


  @if($lesson->link)
      <iframe src="{{$lesson->link}}" width="100%" height="1000px"></iframe>
      @else
      <div class="row u-m-t-20">
        <div class="col-sm-12">
          <p>Em breve</p>
          <br>
            <a  href="{{$lesson->notice}}" width="100%" height="100px">Veja o Calendário</a>
        </div>
      </div>
  @endif

  <div class="row u-m-t-20">
    <div class="col-sm-12">

      <div class="Module-bar">
        <a align="right" class="pull-right">Marcar como Estudada</a>
        <div class="checkbox checkbox-slider-xs checkbox-slider--b-flat u-noMargin pull-right">
          <label for="studiedCheck">
            @if($userMadeLesson)
            <input style="display:flex" class="pull-right" name="studied" id="studiedCheck" type="checkbox" value="true" checked>
            @else
            <input style="display:flex" class="pull-right" name="studied" id="studiedCheck" type="checkbox" value="true">
            @endif
            <span>
            </span>
          </label>
        </div>

      </div>

      @if($url)
        <div class="module-bar">
          <a href={{$url}}><img src="https://s3-us-west-2.amazonaws.com/oabimages/hora+de+praticar.png" style="width:9em; height:9em;margin-bottom: 1em;"/></a>
        </div>
      @endif

      <div class="Card-content">
        <div class="Card Card--module Card--fixedBorder">
          <div class="Card-info">
            <div class="Card-titleArea pull-left">
              <h2 class="Card-title">{!! $lesson->title !!}</h2>
            </div>
            <div class="Rating Rating--vote Rating--mobileBlock pull-right" data-id="{!! $lesson->id !!}" data-token="{{ csrf_token() }}">
              <span class="Rating-title">Classifique este conteúdo:</span>
              <button data-value="1" class="Rating-stars Rating-stars--1 Icon Icon--starBefore" title="1 estrela"><span class="sr-only">1</span></button>
              <button data-value="2" class="Rating-stars Rating-stars--2 Icon Icon--starBefore" title="2 estrelas"><span class="sr-only">2</span></button>
              <button data-value="3" class="Rating-stars Rating-stars--3 Icon Icon--starBefore" title="3 estrelas"><span class="sr-only">3</span></button>
              <button data-value="4" class="Rating-stars Rating-stars--4 Icon Icon--starBefore" title="4 estrelas"><span class="sr-only">4</span></button>
              <button data-value="5" class="Rating-stars Rating-stars--5 Icon Icon--starBefore" title="5 estrelas"><span class="sr-only">5</span></button>
            </div>
          </div>
          <div class="Card-content">
            <div class="row">
              <div class="col-sm-8">
                <p class="Card-text">{{{ $lesson->details }}}</p>
                <div class="Module-comments">
                  <h4 class="Module-commentsTitle">Comentários</h4>
                  <div class="fb-comments" data-href="{{ Request::url() }}" data-numposts="3" data-width="100%" data-order-by="social"></div>
                </div>
              </div>
              <div class="col-sm-4">
                <h4 class="List-title">Entenda mais sobre os assuntos a seguir:</h4>
                <ul class="List list-unstyled">
                  @foreach($related as $relate)
                  <li class="List-item List-item--border">
                    <div class="List-content">
                      <div class="List-icon">
                        <i class="Icon Icon--fileTextBefore" style="data-color:{{ $course->color }};"></i>
                      </div>
                      <div class="List-details List-details--block">
                        @if($relate->userMade)
                          <span style="text-decoration: line-through;">
                          <a style="text-decoration: overline;" href="{{ route('dashboard.lessons.show', ['course' => $course->id, 'lesson' => $relate->id]) }}" class="List-link" title="{{{ $relate->title }}}">{!! $relate->title !!}</a>
                        </span>
                        @else
                          <a style="text-decoration: overline;" href="{{ route('dashboard.lessons.show', ['course' => $course->id, 'lesson' => $relate->id]) }}" class="List-link" title="{{{ $relate->title }}}">{!! $relate->title !!}</a>
                        @endif

                      </div>
                    </div>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
