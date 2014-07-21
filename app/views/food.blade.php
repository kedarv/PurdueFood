@extends('layout')

@section('bottom_js')
@parent
{{ HTML::script('js/rating.js') }}
@stop

@section('content')

Rating:<br><input id="input-avgRating" value="{{$data['averageRating']}}" class="rating" data-disabled="true" data-show-clear="false" data-show-caption="false"> among {{$data['numVotes']}} votes
	{{var_dump($json)}}
	<hr/>
	@if (Auth::check())
	<b>Commenting as {{Auth::user()->username}}</b> [User ID: {{Auth::user()->id}} on {{$data['id']}}]


	@else
	Hey, you need an account to comment! {{ HTML::linkAction('UserController@create', 'Register', 'Register') }} or {{ HTML::linkAction('UserController@login', 'Login', 'Login') }}
	@endif
	<hr/>
	What others are saying about {{$data['name']}}:
    {{var_dump($reviews)}}
	<input id="input-1"class="rating">
@stop