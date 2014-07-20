@extends('layout')

@section('content')
Rating
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
	
	{{-- Parse Stars --}}
	@for($i = 0; $i < $data['full_stars']; $i++)
		<span class="fa fa-star fa-5x"></span>
	@endfor
	@if($data['half_stars'] > 0)
		<span class="fa fa-star-half-full fa-5x"></span>
		@for($i = 0; $i < 4 - $data['full_stars']; $i++)
			<span class="fa fa-star-o fa-5x"></span>
		@endfor
	@else
		@for($i = 0; $i < 5 - $data['full_stars']; $i++)
			<span class="fa fa-star-o fa-5x"></span>
		@endfor
	@endif
	
@stop