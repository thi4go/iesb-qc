<div class="row clearfix">
    <div class="col-sm-4">
        <div class="form-group form-group-default required">
            {!! Form::label('name', 'Nome') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'required']) !!}
        </div>
        <span class="help-block error">{{{ $errors->first('name', ':message') }}}</span>
    </div>

    <div class="col-sm-4">
        <div class="form-group form-group-default required">
            {!! Form::label('color', 'Cor') !!}
            {!! Form::text('color', null, ['class'=>'form-control jscolor', 'required']) !!}
        </div>
        <span class="help-block error">{{{ $errors->first('color', ':message') }}}</span>
    </div>
</div>

@include('blog.back.partials.forms.seo')

<div class="row">
    <div class="col-sm-12">
        <hr>
        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-success']) !!}
            <a href="{{ route('painel.categories.index') }}" class="btn btn-danger" title="Cancelar">Cancelar</a>
        </div>
    </div>
</div>

@section('extraJS')
{!! Html::script('/brzbox/assets/plugins/jscolor/jscolor.js') !!}
@endsection
