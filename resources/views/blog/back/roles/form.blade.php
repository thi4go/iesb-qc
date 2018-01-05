<div class="row clearfix">
    <div class="col-sm-4">
        <div class="form-group form-group-default required">
            {!! Form::label('name', 'Nome') !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'required']) !!}
        </div>
        <span class="error">{{{ $errors->first('name', ':message') }}}</span>
    </div>
</div>

<h5>Permissões</h5>

<div class="row clearfix">
    <div class="col-sm-12">
        @foreach($permissions as $slug => $name)
            @if(Permission::has($slug))
            <div class="checkbox check-success">
                @if(isset($data))
                <?php $check = $data->hasAccess($slug) ? true : false ?>
                @else
                <?php $check = null ?>
                @endif
                {!! Form::checkbox("permissions[{$slug}]", 1, $check, ['id' => $slug]) !!}
                {!! Form::label($slug, $name) !!}
            </div>
            @endif
        @endforeach
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <hr>
        <div class="form-group">
            {!! Form::submit('Salvar', ['class'=>'btn btn-success']) !!}
            <a href="{{ route('painel.roles.index') }}" class="btn btn-danger" title="Cancelar">Cancelar</a>
        </div>
    </div>
</div>
