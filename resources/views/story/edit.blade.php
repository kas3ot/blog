@extends('app')

@section('content')
	<div class="page-header text-center">
		<h1>Edite story: {{ $story->name }}</h1>
	</div>	

	<div class="page-body col-md-6 col-md-offset-3">

		{!! Form::model($story, ['method' => 'PATCH', 'action' => ['StoryController@update', $story->id], 'files' => true]) !!}

		<div class="form-group">
			{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Story title']) !!}
		</div>

		<div class="form-group">
			{!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Description', 'rows' => '4']) !!}
		</div>

		<!-- hidden input -->
			{!! Form::hidden('user_id', Crypt::encrypt(Auth::user()->id)) !!}
		<!-- hidden input -->

		<div class="form-group">
			{!! Form::file('photo', ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			{!! Form::submit('Save', ['class' => 'form-control btn btn-primary']) !!}
		</div>

		{!! Form::close() !!}

		@if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif

	</div>
@stop