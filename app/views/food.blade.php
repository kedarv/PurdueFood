@extends('layout')

@section('content')
Rating
	{{var_dump($json)}}
	What others are saying about {{$data['name']}}:
	--comments--
    {{var_dump($reviews)}}
    {{generateStars($reviews['rating'])}}

<?php
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
