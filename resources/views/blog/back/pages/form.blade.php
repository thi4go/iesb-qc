<div class="row clearfix">
    <div class="col-sm-4">
        <div class="form-group form-group-default required">
            {!! Form::label('title', 'Página') !!}
            {!! Form::text('title', null, ['class'=>'form-control', 'required']) !!}
        </div>
        <span class="error">{{{ $errors->first('title', ':message') }}}</span>
    </div>
</div>

<div class="row clearfix">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::label('body', 'Conteúdo HTML') !!}
            {!! Form::textarea('body', null, ['class'=>'AceEditor']) !!}
        </div>
        <span class="error">{{{ $errors->first('body', ':message') }}}</span>
    </div>
</div>

@include('blog.back.partials.forms.seo')

<div class="row">
    <div class="col-sm-12">
        <hr>
        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-success']) !!}
            <a href="{{ route('painel.pages.index') }}" class="btn btn-danger" title="Cancelar">Cancelar</a>
        </div>
    </div>
</div>

@section('extraJS')
{!! Html::script('/brzbox/assets/plugins/ace/ace.js') !!}
{!! Html::script('/brzbox/assets/plugins/ace/ext-emmet.js') !!}
{!! Html::script('/brzbox/assets/plugins/ace/mode-html.js') !!}
{!! Html::script('/brzbox/assets/plugins/ace/theme-monokai.js') !!}
{!! Html::script('/brzbox/assets/plugins/ace-textarea/textarea-as-ace-editor.js') !!}

<script type="text/javascript">
$(document).ready(function() {
    // Ace Editor
    $(".AceEditor").asAceEditor();
    editor = $('.AceEditor').data('ace-editor');
    editor.session.setMode("ace/mode/html");
    editor.setTheme("ace/theme/monokai");
    editor.setOptions({maxLines: Infinity});
    editor.setShowPrintMargin(false);
});
</script>
@stop
