@extends('layout')

@section('content')
Rating
	{{var_dump($json)}}
	<hr/>
	@if (Auth::check())
	<b>Commenting as {{Auth::user()->username}}</b> [User ID: {{Auth::user()->id}} on {{$data['id']}}]
	@else
	Hey, you need an account to comment! {{ HTML::linkAction('UserController@create', 'Register Now &raquo;', 'Register') }}
	@endif
	<hr/>
	What others are saying about {{$data['name']}}:
    {{var_dump($reviews)}}
	
	@foreach($reviews as $review)
		{{generateStars($review['rating'])}}
	@endforeach
<?php
// Should find a better place to put this func
function generateStars($rating)
{
    $rounded = round($rating * 2) / 2; // rounds to nearest .5

    $intpart = floor( $rounded ); // number of full stars
    $fraction = $rounded - $intpart; // .5 if half star
    for($x=1; $x<=$rounded; $x++)
    {
        print('<span class="fa fa-star fa-5x"></span>');
    }
    if($fraction==.5)
    {
        print('<span class="fa fa-star-half-empty fa-5x"></span>');

    }

    else
    {
        print('<span class="fa fa-star-empty fa-5x"></span>');
    }
    for($x=1; $x<=4-$intpart; $x++)
    {
        print('<span class="fa fa-star-o fa-5x"></span>');

    }
    print("rated ".$rounded." out of 5 stars");
}
?>
@stop
