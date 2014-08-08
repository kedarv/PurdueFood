<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<META NAME="description" CONTENT="Welcome to Purdue Food, where you can discover the dining menus at Purdue University. You can also write reviews for food items, upload pictures of your meals, and share what you eat.">
	<META NAME="keywords" CONTENT="Purdue Food, PurdueFood, Purdue, Purdue Dining Courts, Purdue Dining">
	<META NAME="robot" CONTENT="index,follow">
    <title>Purdue Food</title>
	{{ HTML::style('css/bootstrap.min.css'); }}
	{{ HTML::style('https://fonts.googleapis.com/css?family=Roboto:300,500'); }}
	{{ HTML::style('css/home.css'); }}
	{{ HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css'); }}
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'); }}
	{{ HTML::script('js/bootstrap.min.js'); }}
</head>
<body>
{{ HTML::script('js/tracking.js'); }}
	@include('nav')
  <header class="header-image">
        <div class="headline">
            <div class="container">
                <h1>Purdue Food</h1>
                <h2><span class="headline-bold">Discover</span> Menus. <span class="headline-bold">Review</span> Entrees. <span class="headline-bold">Share</span> what you eat.</h2>
				<div class="hidden-xs">
					@if (Auth::guest())
						{{ HTML::linkAction('UsersController@create', 'Sign Up', array(), array('class' => 'btn btn-lg btn-default', 'style' => 'width: 225px;')) }}
						<div class="or_wrap">
							<div class="or_btn">OR</div>
						</div>
						<a href="{{ action('UsersController@fbGoToLoginUrl')}}" class="btn btn-lg btn-facebook" style="width:225px;"><i class="fa fa-facebook btn-facebook-i"></i> Connect with Facebook</a>
						<br/><br/>
						<span class="already_member">Already signed up? {{ HTML::linkAction('UsersController@login', 'Login &raquo;')}}</span>
					@else
						<span class="already_member">Welcome Back, {{Auth::user()->firstname}}!</a>
					@endif
				</div>
				<div class="visible-xs">
					@if (Auth::guest())
						{{ HTML::linkAction('UsersController@create', 'Sign Up', array(), array('class' => 'btn btn-lg btn-default', 'style' => 'width: 225px;')) }}
						<a href="{{ action('UsersController@fbGoToLoginUrl')}}" class="btn btn-lg btn-facebook" style="width:225px;margin-top:5px;"><i class="fa fa-facebook btn-facebook-i"></i> Connect with Facebook</a>
						<br/><br/>
						<span class="already_member">Already signed up? {{ HTML::linkAction('UsersController@login', 'Login')}}</span>
					@else
						<span class="already_member">Welcome Back, {{Auth::user()->firstname}}!</a>
					@endif
					</div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <div class="container">
        <hr class="featurette-divider">

        <!-- First Featurette -->
        <div class="featurette" id="about">
            <img class="featurette-image img-circle img-responsive pull-right" src="{{asset('img/home_features/menus.jpg')}}" alt="View Menus">
            <h2 class="featurette-heading">View Menus
            </h2>
            <p class="lead">Easily see when and where your favorite dishes will be served in the upcoming week. You can even receive email updates!</p>
        </div>

        <hr class="featurette-divider">

        <!-- Second Featurette -->
        <div class="featurette" id="services">
            <img class="featurette-image img-circle img-responsive pull-left" src="{{asset('img/home_features/reviews.jpg')}}" alt="Reviews">
            <h2 class="featurette-heading">Review Items
            </h2>
            <p class="lead">You can rate dishes and leave comments, just like you would on Yelp. We will provide the Purdue Food Services with useful feedback on what you like!</p>
        </div>

        <hr class="featurette-divider">

        <!-- Third Featurette -->
        <div class="featurette" id="contact">
            <img class="featurette-image img-circle img-responsive pull-right" src="{{asset('img/home_features/search.jpg')}}" alt="Search">
            <h2 class="featurette-heading">Search for Items
            </h2>
            <p class="lead">If you liked last night's pasta, go search for pasta and add that dish to your favorites!</p>
        </div>

        <hr class="featurette-divider">

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>&copy; PurdueFood.com</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

</body>
</html>