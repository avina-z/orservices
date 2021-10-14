@extends('backLayout.app')
@section('title')
create language
@stop

@section('content')

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Create new language</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
                {!! Form::open(['route' => 'languages.store', 'class' => 'form-horizontal']) !!}
                    <div class="form-group {{ $errors->has('language_name') ? 'has-error' : ''}}">
                        {!! Form::label('language_name', 'language name', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6">
                            {!! Form::text('language_name', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('language_name', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('note') ? 'has-error' : ''}}">
                        {!! Form::label('note', 'Note', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-6">
                            {!! Form::textarea('note', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('note', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            {!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}
                            <a href="{{route('languages.index')}}" class="btn btn-primary">Back</a>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
		</div>
    </div>
</div>

@endsection