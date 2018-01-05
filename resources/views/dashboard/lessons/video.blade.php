<section class="Module container">
  <div class="row">
    <div class="col-sm-12">
      <div class="Module-video">
        <div class="embed-responsive embed-responsive-16by9">
          <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{{ $lesson->video_id }}}?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
        </div>
      </div>
      <div class="text-right">
        <a>Marcar como Estudada</a>
        <div class="checkbox checkbox-slider-xs checkbox-slider--b-flat u-noMargin">
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
          <a href={{$url}}>Hora de Praticar</a>
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
                <h4 class="List-title">Prepare-se para os próximos vídeos:</h4>
                <ul class="List list-unstyled">
                  @foreach($related as $relate)
                  <li class="List-item List-item--border">
                    <div class="List-content">
                      <div class="List-icon">
                        <i class="Icon Icon--playCircleBefore" data-color="{{{ $course->color }}}"></i>
                      </div>
                      <div class="List-details List-details--block">
                        @if($relate->userMade)
                          <span style="text-decoration: line-through;">
                          <a style="text-decoration: overline;" href="{{ route('dashboard.lessons.show', ['course' => $course->id, 'lesson' => $relate->id]) }}" class="List-link" title="{{{ $relate->title }}}">{!! $relate->title !!}</a>
                        </span>
                        @else
                          <a style="text-decoration: overline;" href="{{ route('dashboard.lessons.show', ['course' => $course->id, 'lesson' => $relate->id]) }}" class="List-link" title="{{{ $relate->title }}}">{!! $relate->title !!}</a>
                        @endif                      </div>
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
