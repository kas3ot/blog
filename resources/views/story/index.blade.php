@extends('app')

@section('content')
	<div class="page-header">
		@include('flash::message')

		<h1>Stories</h1>
	</div>	

	<div class="page-body">
		@foreach($stories as $story)
		<div class="media">

			@if(Auth::user()->id == $story->user_id) 
			<a href="story/{{ $story->id }}/destroy" class="glyphicon glyphicon-remove pull-right"></a>
			<a href="story/{{ $story->id }}/edit" class="glyphicon glyphicon-edit pull-right"></a>
			@endif

			<div class="media-left">
				<a href="story/{{ $story->id }}">
				<img class="media-object" src="images/{{ $story->photo }}" alt="...">
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

				<a class="comments-seciton" href="story/{{ $story->id }}">
					{{ $story->comment->count() }} 
					@if($story->comment->count() == 1)
						comment
					@else
						comments
					@endif
				</a>
				
			</div> 
		</div>
		@endforeach
	</div>
@stop