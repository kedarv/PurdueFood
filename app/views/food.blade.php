@extends('layout')

@section('content')
Rating
	<pre>{{var_dump($json)}}</pre>
	What others are saying about {{$json['Name']}}:
	--comments--
@stop
