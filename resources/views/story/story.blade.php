@extends('app')

@section('content')
	<div class="page-header">
		@include('flash::message')

		@if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif

		<h1>Story</h1>
	</div>	

	<div class="page-body">

		<div class="media">
			<div class="media-left">
				<a href="story/{{ $story->id }}">
				<img class="media-object" src="../images/{{ $story->photo }}" alt="...">
				</a>
			</div>
			<div class="media-body">
				<h4 class="media-heading">
					<a href="story/{{ $story->id }}">
						{{ $story->name }} 
					</a>
					<span>
						[ 
							created at {{ $story->created_at }}, by
							<a href="user/{{ $story->user_id }}">
								@if(Auth::user()->id == $story->user->id)
									Me
								@else
									{{ $story->user->name }}
								@endif		
							</a> 
						]
					</span>
				</h4>
				<p>{{ $story->description }}<p>
			
				<!-- Comment secton -->
				<div class="well well-sm">

					<div class="form-group">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
					</div>
					{!! Form::open(array('url' => 'story/addComment')) !!}

					{!! Form::text('comment', null, ['class' => 'comment-box', 'placeholder' => 'Comment']) !!}
					
					<!-- hidden input -->
						{!! Form::hidden('user_id', Crypt::encrypt(Auth::user()->id)) !!}
					<!-- hidden input -->

					<!-- hidden input -->
						{!! Form::hidden('story_id', Crypt::encrypt($story->id)) !!}
					<!-- hidden input -->

					{!! Form::submit('Save') !!}

					{!! Form::close() !!}
				</div>


				@foreach($story->comment->reverse() as $comment)

				<div class="well well-sm">
					<p>
						<a href="">{{ $comment->user->name }}</a>: 
						{{ $comment->comment }}
					</p>
				</div>

				@endforeach
				<!-- Comment secton -->

			</div> 
		</div>

	</div>
@stop