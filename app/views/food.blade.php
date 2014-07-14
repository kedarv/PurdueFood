<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$json['Name']}}</title>
	{{ HTML::style('css/bootstrap.min.css'); }}
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	{{ HTML::script('js/bootstrap.min.js'); }}
	{{ HTML::script('js/login.js'); }}
</head>
<body>
<pre>{{var_dump($json)}}</pre>
