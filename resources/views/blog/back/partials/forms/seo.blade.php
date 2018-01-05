<h5>SEO</h5>

<div class="row clearfix">
    <div class="col-sm-6">
        <div class="form-group form-group-default required">
            {!! Form::label('meta_title', 'Título da página') !!}
            {!! Form::text('meta_title', isset($data->seo->meta_title) ? $data->seo->meta_title : null, ['class'=>'form-control', 'required']) !!}
        </div>
        <span class="error">{{{ $errors->first('meta_title', ':message') }}}</span>
    </div>
    <div class="col-sm-6">
        <div class="form-group form-group-default required">
            {!! Form::label('meta_description', 'Descrição') !!}
            {!! Form::text('meta_description', isset($data->seo->meta_description) ? $data->seo->meta_description : null, ['class'=>'form-control', 'required']) !!}
        </div>
        <span class="error">{{{ $errors->first('meta_description', ':message') }}}</span>
    </div>
</div>
<div class="row clearfix">
    <div class="col-xs-12">
      <div class="form-group form-group-default required">
        {!! Form::label('meta_keywords', 'Palavras-chave') !!}
        {!! Form::text('meta_keywords', isset($data->seo->meta_keywords) ? $data->seo->meta_keywords : null, ['class'=>'form-control', 'data-role' => 'tagsinput']) !!}
      </div>
    </div>
</div>
