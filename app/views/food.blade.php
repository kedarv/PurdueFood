@extends('layout')

@section('content')
Rating
	{{var_dump($json)}}
	What others are saying about {{$json['Name']}}:
	--comments--
@stop
