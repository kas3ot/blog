@extends('app')

@section('content')
	<div class="page-header">
		@include('flash::message')

		<h1>My Stories</h1>
	</div>	

	<div class="page-body">
		@foreach($stories as $story)
		<div class="media">

			<a href="../story/{{ $story->id }}/destroy" class="glyphicon glyphicon-remove pull-right"></a>
			<a href="../story/{{ $story->id }}/edit" class="glyphicon glyphicon-edit pull-right"></a>

			<div class="media-left">
				<a href="../story/{{ $story->id }}">
				<img class="media-object" src="../../images/{{ $story->photo }}" alt="...">
				</a>
			</div>
				<div class="media-body">
				<h4 class="media-heading">
					<a href="../story/{{ $story->id }}">
						{{ $story->name }} 
					</a>
					<span>
						created at {{ $story->created_at }}					
					</span>
				</h4>
				<p>{{ $story->description }}<p>
				<a class="comments-seciton" href="../story/{{ $story->id }}">5 comments</a>
			</div> 
		</div>
		@endforeach
	</div>
@stop