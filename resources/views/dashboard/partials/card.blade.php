<div class="Card Card--module" style="border-color:{{ $courses[$i]->color }}">
  <div class="Card-info">
    <div class="Card-count pull-left">{{ count($courses[$i]->videos)}} Vídeo(s) | {{ count($courses[$i]->articles) }} Artigo(s)</div>
  </div>
  <div class="Card-content">
    <div class="row">
      <div class="col-sm-7">
        <h3 class="Card-title" style="data-color:{{ $courses[$i]->color }};">{{$courses[$i]->title }}</h3>
        <p class="Card-text u-m-b-20">{{{ $courses[$i]->details }}}</p>
        <a href="{{ route('dashboard.courses.show', ['module' => $courses[$i]->id]) }}"  style="background-color:{{ $courses[$i]->color}};" class="Button Button--module btn"  title="Iniciar curso">iniciar curso</a>
      </div>
      <figure class="Card-figure col-sm-5 hidden-xs">
          <img src="{{$courses[$i]->thumb}}" alt="{{$courses[$i]->title}}" class="img-responsive" data-no-retina>
      </figure>
    </div>
  </div>
</div>
