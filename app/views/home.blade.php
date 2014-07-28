<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Purdue Food</title>
	{{ HTML::style('css/bootstrap.min.css'); }}
	{{ HTML::style('https://fonts.googleapis.com/css?family=Roboto:400,300'); }}
	{{ HTML::style('css/home.css'); }}
	{{ HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css'); }}
	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'); }}
	{{ HTML::script('js/bootstrap.min.js'); }}	
</head>
<body>
	@include('nav')
  <header class="header-image">
        <div class="headline">
            <div class="container">
                <h1>Purdue Food</h1>
                <h2>Discover Menus. Review Entrees. Share what you eat.</h2>
				<br/>
					@if (Auth::guest())
						{{ HTML::linkAction('UserController@create', 'Sign Up', array(), array('class' => 'btn btn-lg btn-default', 'style' => 'width: 225px;')) }}
						<span class="or_btn">OR</span>
						<a href="{{ action('UserController@login')}}" class="btn btn-lg btn-facebook" style="width:230px;"><i class="fa fa-facebook btn-facebook-i"></i> Connect with Facebook</a>
						<br/><br/>
						<span class="already_member">Already signed up? {{ HTML::linkAction('UserController@login', 'Login')}}</span>
					@else
						Welcome Back, {{Auth::user()->username}}!
					@endif
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <div class="container">
        <hr class="featurette-divider">

        <!-- First Featurette -->
        <div class="featurette" id="about">
            <img class="featurette-image img-circle img-responsive pull-right" src="assets/img/350x350.gif">
            <h2 class="featurette-heading">View Menus
            </h2>
            <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
        </div>

        <hr class="featurette-divider">

        <!-- Second Featurette -->
        <div class="featurette" id="services">
            <img class="featurette-image img-circle img-responsive pull-left" src="assets/img/350x350.gif">
            <h2 class="featurette-heading">Review Items
            </h2>
            <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
        </div>

        <hr class="featurette-divider">

        <!-- Third Featurette -->
        <div class="featurette" id="contact">
            <img class="featurette-image img-circle img-responsive pull-right" src="assets/img/350x350.gif">
            <h2 class="featurette-heading">Search for Items
            </h2>
            <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
        </div>

        <hr class="featurette-divider">

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; PurdueFood.com</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

</body>
</html>