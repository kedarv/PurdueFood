<!Doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
	@section('css')
	{{ HTML::style('css/bootstrap.min.css'); }}
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
<div class="container">
	<div class="row" style="margin-top:50px;">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">{{ $title }}</div>
				<div class="panel-body">
				@yield('content')
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>