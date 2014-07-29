<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="token" content="{{ Session::token() }}">
    <title>{{{ $data['name'] }}}</title>
	@section('css')
	{{ HTML::style('css/bootstrap.min.css'); }}
	{{ HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css'); }}
	{{ HTML::style('css/star-rating.min.css'); }}
	@show
	
	@section('js')
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'); }}
	{{ HTML::script('js/bootstrap.min.js'); }}
	@show
</head>
<body>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-53348908-1', 'auto');
    ga('send', 'pageview');

</script>
 @include('nav')
    <div class="container" style="margin-top:20px;">
        <div class="row">
            <div class="col-md-12">
			<h1>{{{ $data['name'] }}} @section('append_header')@show</h1>
			@yield('content')
			
	@section('bottom_js')
	@show
</body>
</html>