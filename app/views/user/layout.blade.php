<!Doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
	{{ HTML::style('css/bootstrap.min.css'); }}
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'); }}
	{{ HTML::script('js/bootstrap.min.js'); }}	
</head>
<body>
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