@extends('layout')

@section('content')
{{var_dump($allowedTo)}}

{{var_dump($count)}}
<hr/>
Query Log
{{dd(DB::getQueryLog())}}
@stop