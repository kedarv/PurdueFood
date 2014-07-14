<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Purdue Food</title>
	{{ HTML::style('css/bootstrap.min.css'); }}
	{{ HTML::style('css/cover.css'); }}
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'); }}
	{{ HTML::script('js/bootstrap.min.js'); }}	
</head>
<body>
    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
                <div class="masthead clearfix">
                    <div class="inner">
                        <h3 class="masthead-brand">Purdue Food</h3>
                        <ul class="nav masthead-nav">
                            <li class="active"><li>{{ HTML::linkAction('home', 'Home') }}</li></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dining Court Menus <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li>{{ HTML::linkAction('DiningController@pushData', 'Earhart', ['name' => 'Earhart']) }}</li>
									<li>{{ HTML::linkAction('DiningController@pushData', 'Ford', ['name' => 'Ford']) }}</li>
									<li>{{ HTML::linkAction('DiningController@pushData', 'Hillenbrand', ['name' => 'Hillenbrand']) }}</li>
									<li>{{ HTML::linkAction('DiningController@pushData', 'Wiley', ['name' => 'Wiley']) }}</li>
									<li>{{ HTML::linkAction('DiningController@pushData', 'Windsor', ['name' => 'Windsor']) }}</li>
								</ul>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="inner cover">
                    <h1 class="cover-heading">Purdue Food Court Menu</h1>
                    <p class="lead">Discover Menus. Rate Entrees and Courts. Share what you eat.</p>
                    <p class="lead">
					@if (Auth::guest())
						{{ HTML::linkAction('UserController@create', 'Sign Up &raquo;', array(), array('class' => 'btn btn-lg btn-default')) }}
						{{ HTML::linkAction('UserController@login', 'Login &raquo;', array(), array('class' => 'btn btn-lg btn-default')) }}
					@else
						Welcome Back, {{Auth::user()->username}}!
					@endif
                    </p>
                </div>

                <div class="mastfoot">
                    <div class="inner">
                        <p>&copy; 2014 Kedar V</p>
                    </div>
                </div>
            </div>
        </div>
	</div>
</body>
</html>
