@extends('layout')

@section('bottom_js')
@parent
{{ HTML::script('js/rating.js') }}
@stop

@section('append_header')
@parent
	<div style="display:inline-block;font-size:12px;">
		<input id="input-avgRating" value="{{$data['averageRating']}}" class="rating" data-disabled="true" data-show-clear="false" data-show-caption="false">
	</div>
@stop

@section('content')
	{{var_dump($json)}}
	<hr/>
	@if (Auth::check())
	<b>Commenting as {{Auth::user()->username}}</b> [User ID: {{Auth::user()->id}} on {{$data['id']}}]
		<input id="input-1" class="rating" data-user="{{Auth::user()->id}}" data-food="{{$data['id']}}">
		formdata
	@else
	Hey, you need an account to comment! {{ HTML::linkAction('UserController@create', 'Register', 'Register') }} or {{ HTML::linkAction('UserController@login', 'Login', 'Login') }}
	@endif
	<hr/>
    @foreach($reviews as $review)
	<div class="col-md-6">
		<div class="well">
			<img src="http://www.gravatar.com/avatar/" alt="{{$review['username']}}" class="img-responsive" style="float:left;padding-right:10px;"/>
			<h4 style="margin:0px 0px 0px 95px;">{{$review['username']}}</h4>
			<input id="input-avgRating" value="{{$review['rating']}}" class="rating" data-size="xs" data-disabled="true" data-show-clear="false" data-show-caption="false">
			<small>Posted {{$review['created_at']}}</small>
			<hr/>
			{{$review['comment']}}
		</div>
	</div>
	@endforeach	
@stop