<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{{ $data['name'] }}} Dining Hall</title>
	{{ HTML::style('css/bootstrap.min.css'); }}
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	{{ HTML::script('js/bootstrap.min.js'); }}
	{{ HTML::script('js/login.js'); }}
</head>
<body>
 <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Purdue Food</a>
            </div>

            <div class="collapse navbar-collapse" id="nav-collapse">
                <ul class="nav navbar-nav">
                    <li>{{ HTML::linkAction('home', 'Home') }}</li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Today's Menu <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>{{ HTML::linkAction('DiningController@pushData', 'Earhart', ['name' => 'Earhart']) }}</li>
                            <li>{{ HTML::linkAction('DiningController@pushData', 'Ford', ['name' => 'Ford']) }}</li>
                            <li>{{ HTML::linkAction('DiningController@pushData', 'Hillenbrand', ['name' => 'Hillenbrand']) }}</li>
                            <li>{{ HTML::linkAction('DiningController@pushData', 'Wiley', ['name' => 'Wiley']) }}</li>
                            <li>{{ HTML::linkAction('DiningController@pushData', 'Windsor', ['name' => 'Windsor']) }}</li>
                        </ul>
                    </li>
					<li><a href="?page=search">Historical Menu Lookup</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li>{{ HTML::linkAction('UserController@create', 'Register') }}</li>
						<li>{{ HTML::linkAction('UserController@login', 'Login') }}</li>
					@else
						<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>{{ HTML::linkAction('UserController@details', 'Account Details') }}</li>
							<li>{{ HTML::linkAction('UserController@logout', 'Logout') }}</li>
						</ul>
					@endif
				</ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <div class="container" style="margin-top:20px;">
        <div class="row">
            <div class="col-md-12">
			<h1>{{{ $data['name'] }}} Dining Hall</h1>
			@yield('content')
</body>
</html>