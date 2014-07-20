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
	{{generateStars($data['sum'])}}
<?php
// Should find a better place to put this func
function generateStars($rating) {

    $rounded = round($rating * 2) / 2; // rounds to nearest .5
    $intpart = floor( $rounded ); // number of full stars
    $fraction = $rounded - $intpart; // .5 if half star
    for($x=1; $x <= $intpart; $x++) {
        echo '<span class="fa fa-star fa-5x"></span>';
    }
    if($fraction==.5) {
        echo '<span class="fa fa-star-half-empty fa-5x"></span>';

    }
    else {
       echo '<span class="fa fa-star-o fa-5x"></span>';
    }
    for($x=1; $x<=4-$intpart; $x++) {
        echo '<span class="fa fa-star-o fa-5x"></span>';

    }
    echo "rated ".$rounded." out of 5 stars";
}
?>
@stop
