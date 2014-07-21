@extends('layout')

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
<script type="text/javascript">
$("#input-1").rating({
starCaptions: {1: "Very Poor", 2: "Poor", 3: "Ok", 4: "Good", 5: "Very Good"},
starCaptionClasses: {1: "text-danger", 2: "text-warning", 3: "text-info", 4: "text-primary", 5: "text-success"},
});
$("#input-1").on("rating.change", function(event, value, caption) {
    alert("You rated: " + value + " = " + $(caption).text());

});

</script>

@stop