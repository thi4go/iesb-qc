<h5>Post</h5>

<div class="row clearfix">
    <div class="col-sm-2">
      <div class="form-group form-group-default form-group-default-select2 required">
        {!! Form::label('category_id', 'Categoria') !!}
        {!! Form::select('category_id', $categories, null, ['class' => 'full-width', 'data-init-plugin' => 'select2']) !!}
      </div>
      <small class="help-block error">{{{ $errors->first('category_id', ':message') }}}</small>
    </div>

    <div class="col-sm-4">
      <div class="form-group form-group-default required">
        {!! Form::label('title', 'Título') !!}
        {!! Form::text('title', null, ['class'=>'form-control', 'required']) !!}
      </div>
      <span class="help-block error">{{{ $errors->first('title', ':message') }}}</span>
    </div>

    <div class="col-sm-6">
      <div class="form-group form-group-default required">
        {!! Form::label('subtitle', 'Chamada') !!}
        {!! Form::text('subtitle', null, ['class'=>'form-control', 'required']) !!}
      </div>
      <small class="help-block error">{{{ $errors->first('subtitle', ':message') }}}</small>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
      <div class="form-group form-group-default required">
        {!! Form::label('tags', 'Tags') !!}
        {!! Form::text('tags', isset($data->tagList) ? $data->tagList : old('tags'), ['class'=>'form-control', 'data-role' => 'tagsinput']) !!}
      </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('text', 'Post') !!}
            {!! Form::textarea('text', null, ['class'=>'tinymce', 'rows' => 5]) !!}
        </div>
        <small class="help-block error">{{{ $errors->first('text', ':message') }}}</small>
    </div>
</div>

<div class="row clearfix">
    <div class="col-sm-4">
        <div class="fileinput fileinput-new form-group form-group-default input-group" data-provides="fileinput">
            {!! Form::label('image', 'Capa (Ideal 1920x1080)') !!}
            <div class="form-control" data-trigger="fileinput">
                <span class="fileinput-filename"></span>
            </div>
            <span class="input-group-addon btn-file">
                <i class="fa fa-image"></i>
                {!! Form::file('image') !!}
            </span>
            <a href="#" class="input-group-addon fileinput-exists" data-dismiss="fileinput"><i class="fa fa-close"></i></a>
        </div>
        <span class="error">{{{ $errors->first('image', ':message') }}}</span>
    </div>
    <div class="col-sm-2 col-sm-offset-1">
      <div class="form-group form-group-default form-group-default-select2 required">
        {!! Form::label('card_type', 'Tipo Card') !!}
        {!! Form::select('card_type', [1 => 'Pequeno [175px]', 2 => 'Médio [250px]', 3 => 'Grande [300px]'], null, ['class' => 'full-width', 'data-init-plugin' => 'select2']) !!}
      </div>
      <small class="help-block error">{{{ $errors->first('card_type', ':message') }}}</small>
    </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="form-group">
      <div class="checkbox check-success">
        {!! Form::checkbox('release', true, isset($data->release) ? $data->release : false, ['id' => 'release']) !!}
        <label for="release">Destaque?</label>
      </div>
    </div>
  </div>
</div>

@include('blog.back.partials.forms.seo')

<div class="row">
    <div class="col-sm-12">
        <hr>
        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-success']) !!}
            <a href="{{ route('painel.posts.index') }}" class="btn btn-danger" title="Cancelar">Cancelar</a>
        </div>
    </div>
</div>

@section('extraCSS')
{!! Html::style('/brzbox/assets/plugins/dropzone/dist/min/dropzone.min.css') !!}
@endsection

@section('extraJS')
{!! Html::script('/brzbox/assets/plugins/angular/angular.min.js') !!}
{!! Html::script('/brzbox/assets/plugins/dropzone/dist/min/dropzone.min.js') !!}
{!! Html::script('/brzbox/assets/plugins/tinymce/js/tinymce/tinymce.min.js') !!}
{!! Html::script('/brzbox/assets/js/tinymce.js') !!}
{!! Html::script('/brzbox/assets/js/gallery.js') !!}
@endsection
